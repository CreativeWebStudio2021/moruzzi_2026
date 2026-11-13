<?php
/**
 * Genera SQL di correzione HTML malformato in description/short_description.
 * NON esegue nulla sul DB.
 */
require __DIR__ . '/../../vendor/autoload.php';
$app = require __DIR__ . '/../../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

const VOID_TAGS = ['br','hr','img','meta','input','link','source','wbr','area','base','col','embed','param','track'];

function sqlEscape(string $s): string {
    return str_replace(["\\", "'"], ["\\\\", "\\'"], $s);
}

/**
 * Plain text con lexer che riconosce tag rotti.
 * </b,  → chiude tag e lascia la virgola nel testo
 * All<’ → ignora il '<' spurio prima dell'apostrofo
 */
function smartPlain(string $html): string {
    $out = '';
    $len = strlen($html);
    $i = 0;
    while ($i < $len) {
        if ($html[$i] !== '<') { $out .= $html[$i]; $i++; continue; }
        if (substr($html, $i, 4) === '<!--') {
            $end = strpos($html, '-->', $i + 4);
            $i = $end === false ? $len : $end + 3;
            continue;
        }
        // </b, → close tag, keep comma as text
        if (preg_match('/\G<\/\s*([a-zA-Z][a-zA-Z0-9]*),/', $html, $m, 0, $i)) {
            $i += strlen($m[0]) - 1; // stop before comma
            continue;
        }
        // </b<
        if (preg_match('/\G<\/\s*([a-zA-Z][a-zA-Z0-9]*)<+/', $html, $m, 0, $i)) {
            $i += strlen($m[0]);
            continue;
        }
        // <b<
        if (preg_match('/\G<([a-zA-Z][a-zA-Z0-9]*)<+/', $html, $m, 0, $i)) {
            $i += strlen($m[0]);
            continue;
        }
        // letter<' or letter<’ → skip spurious <
        if ($i > 0 && preg_match('/[A-Za-z]/', $html[$i - 1]) && preg_match('/^[\'’]/u', substr($html, $i + 1, 3))) {
            $i++;
            continue;
        }
        if (preg_match('/\G<\/\s*([a-zA-Z][a-zA-Z0-9]*)\s*>/', $html, $m, 0, $i)) {
            $i += strlen($m[0]); continue;
        }
        if (preg_match('/\G<([a-zA-Z][a-zA-Z0-9]*)(\s[^>]*)?\s*\/?\s*>/', $html, $m, 0, $i)) {
            $i += strlen($m[0]); continue;
        }
        // stray < as text (es. legende "XI < PONT")
        $out .= '<';
        $i++;
    }
    return $out;
}

/**
 * Tag syntax well-formed? Allows literal '<' in text (legend separators)
 * when not forming a tag name.
 */
function isTagSyntaxOk(string $html): bool {
    $stack = [];
    $len = strlen($html);
    $i = 0;
    while ($i < $len) {
        if ($html[$i] !== '<') { $i++; continue; }
        if (substr($html, $i, 4) === '<!--') {
            $end = strpos($html, '-->', $i + 4);
            if ($end === false) return false;
            $i = $end + 3;
            continue;
        }
        // malformed still present
        if (preg_match('/\G<\/?[a-zA-Z][a-zA-Z0-9]*</', $html, $m, 0, $i)) return false;
        if (preg_match('/\G<\/\s*[a-zA-Z][a-zA-Z0-9]*,/', $html, $m, 0, $i)) return false;

        if (preg_match('/\G<\/\s*([a-zA-Z][a-zA-Z0-9]*)\s*>/', $html, $m, 0, $i)) {
            $tag = strtolower($m[1]);
            $found = false;
            for ($j = count($stack) - 1; $j >= 0; $j--) {
                if ($stack[$j] === $tag) { array_splice($stack, $j); $found = true; break; }
            }
            if (!$found) return false;
            $i += strlen($m[0]);
            continue;
        }
        if (preg_match('/\G<([a-zA-Z][a-zA-Z0-9]*)(\s[^>]*)?\s*\/?\s*>/', $html, $m, 0, $i)) {
            $tag = strtolower($m[1]);
            $self = str_ends_with(rtrim($m[0]), '/>') || in_array($tag, VOID_TAGS, true);
            if (!$self) $stack[] = $tag;
            $i += strlen($m[0]);
            continue;
        }
        // literal < (text) — OK
        $i++;
    }
    return $stack === [];
}

function domAccepts(string $html): bool {
    $prev = libxml_use_internal_errors(true);
    libxml_clear_errors();
    $dom = new DOMDocument('1.0', 'UTF-8');
    $ok = @$dom->loadHTML('<?xml encoding="UTF-8"><div>'.$html.'</div>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
    $errs = libxml_get_errors();
    libxml_clear_errors();
    libxml_use_internal_errors($prev);
    if ($ok === false) return false;
    foreach ($errs as $e) {
        if ($e->level === LIBXML_ERR_FATAL) return false;
    }
    return true;
}

function hasTagMalformation(string $html): bool {
    if (preg_match('/<\/?[a-zA-Z][a-zA-Z0-9]*</', $html)) return true;
    if (preg_match('/<\/\s*[a-zA-Z][a-zA-Z0-9]*,/', $html)) return true;
    // All<' or All<’
    if (preg_match('/[A-Za-z]<[\'’]/u', $html)) return true;
    // Unbalanced b/i/strong/em/u
    if (!isTagSyntaxOk($html)) return true;
    return false;
}

function repairHtml(string $html): string {
    $s = $html;

    // </b, → </b>,
    $s = preg_replace('/<\/\s*([a-zA-Z][a-zA-Z0-9]*),/', '</$1>,', $s);

    // </b< / <b<
    $s = preg_replace('/<\/\s*([a-zA-Z][a-zA-Z0-9]*)<+/', '</$1>', $s);
    $s = preg_replace('/<([a-zA-Z][a-zA-Z0-9]*)<+/', '<$1>', $s);

    // <b>511</b>/</b>3a</b> → <b>511/3a</b>
    $s = preg_replace('/<b>([^<]*)<\/b>\s*\/\s*<\/b>([^<]*)<\/b>/i', '<b>$1/$2</b>', $s);

    // stray < before apostrophe: All<’ordine → All’ordine
    $s = preg_replace('/([A-Za-z])<([\'’])/u', '$1$2', $s);

    // <br><bt> junk
    $s = preg_replace('/<br\s*\/?>\s*<bt\s*>/i', '<br>', $s);

    // </b>WORD</b> orphan-open pattern (applied only via balancer now)
    $s = balanceInlineTags($s);
    return $s;
}

function balanceInlineTags(string $html): string {
    $inline = ['b','i','strong','em','u'];
    $tokens = [];
    $len = strlen($html);
    $i = 0;
    $buf = '';
    while ($i < $len) {
        if ($html[$i] !== '<') { $buf .= $html[$i]; $i++; continue; }
        if ($buf !== '') { $tokens[] = ['t'=>'text','v'=>$buf]; $buf=''; }
        if (substr($html, $i, 4) === '<!--') {
            $end = strpos($html, '-->', $i + 4);
            $chunk = $end === false ? substr($html, $i) : substr($html, $i, $end + 3 - $i);
            $tokens[] = ['t'=>'raw','v'=>$chunk];
            $i += strlen($chunk);
            continue;
        }
        if (preg_match('/\G<\/\s*([a-zA-Z][a-zA-Z0-9]*)\s*>/', $html, $m, 0, $i)) {
            $tokens[] = ['t'=>'close','tag'=>strtolower($m[1]),'v'=>$m[0]];
            $i += strlen($m[0]); continue;
        }
        if (preg_match('/\G<([a-zA-Z][a-zA-Z0-9]*)(\s[^>]*)?\s*\/?\s*>/', $html, $m, 0, $i)) {
            $tag = strtolower($m[1]);
            $self = str_ends_with(rtrim($m[0]), '/>') || in_array($tag, VOID_TAGS, true);
            $tokens[] = ['t'=>$self?'void':'open','tag'=>$tag,'v'=>$m[0]];
            $i += strlen($m[0]); continue;
        }
        $buf .= '<'; $i++;
    }
    if ($buf !== '') $tokens[] = ['t'=>'text','v'=>$buf];

    $stack = [];
    $out = [];
    $n = count($tokens);
    for ($k = 0; $k < $n; $k++) {
        $tok = $tokens[$k];
        if ($tok['t'] === 'open' && in_array($tok['tag'], $inline, true)) {
            if ($stack && end($stack) === $tok['tag']) {
                $out[] = '</'.$tok['tag'].'>';
                array_pop($stack);
                continue;
            }
            $stack[] = $tok['tag'];
            $out[] = $tok['v'];
            continue;
        }
        if ($tok['t'] === 'close' && in_array($tok['tag'], $inline, true)) {
            if ($stack && end($stack) === $tok['tag']) {
                array_pop($stack);
                $out[] = $tok['v'];
                continue;
            }
            $look = '';
            $foundClose = false;
            for ($j = $k + 1; $j < $n; $j++) {
                if ($tokens[$j]['t'] === 'text') { $look .= $tokens[$j]['v']; continue; }
                if ($tokens[$j]['t'] === 'close' && $tokens[$j]['tag'] === $tok['tag']) $foundClose = true;
                break;
            }
            if ($foundClose && trim($look) !== '' && strlen($look) <= 80 && !str_contains($look, '<')) {
                $out[] = '<'.$tok['tag'].'>';
                $stack[] = $tok['tag'];
                continue;
            }
            continue; // drop orphan close
        }
        if ($tok['t'] === 'open') {
            $stack[] = $tok['tag'];
            $out[] = $tok['v'];
            continue;
        }
        if ($tok['t'] === 'close') {
            if ($stack && end($stack) === $tok['tag']) {
                array_pop($stack);
                $out[] = $tok['v'];
            } elseif (in_array($tok['tag'], $stack, true)) {
                while ($stack && end($stack) !== $tok['tag']) {
                    $out[] = '</'.array_pop($stack).'>';
                }
                if ($stack && end($stack) === $tok['tag']) {
                    array_pop($stack);
                    $out[] = $tok['v'];
                }
            }
            continue;
        }
        $out[] = $tok['v'];
    }
    while ($stack) $out[] = '</'.array_pop($stack).'>';
    return implode('', $out);
}

$outDir = __DIR__;
$prefix = DB::getTablePrefix();
$table = $prefix.'prodotti';
$fields = ['description', 'short_description'];

$fixLines = [
    "-- HTML tag syntax fix for mor_prodotti.description / short_description\n",
    "-- Generated: ".date('c')."\n",
    "-- NOT executed. Run only after reviewing. Pair with backup/rollback.\n",
    "-- Validation: isTagSyntaxOk + DOMDocument + smartPlain identical.\n",
    "SET NAMES utf8mb4;\n",
    "START TRANSACTION;\n\n",
];
$bakLines = ["-- BACKUP: values BEFORE html fix (restore via rollback SQL)\n","-- Generated: ".date('c')."\n","SET NAMES utf8mb4;\n\n"];
$rbLines = ["-- ROLLBACK to pre-fix values\n","-- Generated: ".date('c')."\n","SET NAMES utf8mb4;\n","START TRANSACTION;\n\n"];

$stats = [];
$failures = [];
$examplesByIssue = [
    'malformed_open_b' => [],
    'malformed_close_b' => [],
    'unbalanced' => [],
];
$counts = [
    'description' => [
        'nonempty' => 0,
        'malformed_rows' => 0,
        'malformed_open_b' => 0,
        'malformed_close_comma_or_lt' => 0,
        'unbalanced_tags' => 0,
        'fixed' => 0,
        'failed' => 0,
        'examples' => [],
    ],
    'short_description' => [
        'nonempty' => 0,
        'malformed_rows' => 0,
        'malformed_open_b' => 0,
        'malformed_close_comma_or_lt' => 0,
        'unbalanced_tags' => 0,
        'fixed' => 0,
        'failed' => 0,
        'examples' => [],
    ],
];

foreach ($fields as $col) {
    $rows = DB::table('prodotti')->select('entity_id', $col)
        ->whereNotNull($col)->where($col, '!=', '')->orderBy('entity_id')->get();
    $counts[$col]['nonempty'] = count($rows);
    foreach ($rows as $row) {
        $before = (string) $row->$col;
        if (!hasTagMalformation($before)) continue;
        $counts[$col]['malformed_rows']++;
        if (preg_match('/<[a-zA-Z][a-zA-Z0-9]*</', $before)) $counts[$col]['malformed_open_b']++;
        if (preg_match('/<\/[a-zA-Z][a-zA-Z0-9]*(?:<+|,)/', $before)) $counts[$col]['malformed_close_comma_or_lt']++;
        if (!isTagSyntaxOk($before)) $counts[$col]['unbalanced_tags']++;

        $after = repairHtml($before);
        $okPlain = smartPlain($before) === smartPlain($after);
        $okForm = isTagSyntaxOk($after) && domAccepts($after);
        $changed = $after !== $before;

        if (!$changed && $okForm) {
            // was flagged but repair noop and now ok? recheck
            $counts[$col]['malformed_rows']--;
            continue;
        }

        if (!$okPlain || !$okForm) {
            $counts[$col]['failed']++;
            $failures[] = [
                'id' => $row->entity_id,
                'col' => $col,
                'okPlain' => $okPlain,
                'okForm' => $okForm,
                'before' => mb_substr($before, 0, 200),
                'after' => mb_substr($after, 0, 200),
            ];
            continue;
        }

        $counts[$col]['fixed']++;
        if (count($counts[$col]['examples']) < 5) {
            // highlight a repaired fragment
            $snipB = $before; $snipA = $after;
            if (preg_match('/.{0,30}<(?:\/)?b[<\s,].{0,40}/u', $before, $m)) $snipB = $m[0];
            elseif (preg_match('/.{0,40}<\/b>.{0,40}/u', $before, $m)) $snipB = $m[0];
            if (preg_match('/.{0,30}<b>.{0,40}/u', $after, $m)) $snipA = $m[0];
            $counts[$col]['examples'][] = [
                'id' => (int)$row->entity_id,
                'before' => mb_substr($snipB, 0, 100),
                'after' => mb_substr($snipA, 0, 100),
            ];
        }

        $id = (int) $row->entity_id;
        $escB = sqlEscape($before);
        $escA = sqlEscape($after);
        $fixLines[] = "UPDATE `{$table}` SET `{$col}` = '{$escA}' WHERE `entity_id` = {$id} AND `{$col}` = '{$escB}';\n";
        $bakLines[] = "-- entity_id={$id} {$col}\nUPDATE `{$table}` SET `{$col}` = '{$escB}' WHERE `entity_id` = {$id};\n";
        $rbLines[] = "UPDATE `{$table}` SET `{$col}` = '{$escB}' WHERE `entity_id` = {$id};\n";
    }
}

$fixLines[] = "\nCOMMIT;\n";
$rbLines[] = "\nCOMMIT;\n";

file_put_contents($outDir.'/fix-product-description-html.sql', implode('', $fixLines));
file_put_contents($outDir.'/backup-product-description-html.sql', implode('', $bakLines));
file_put_contents($outDir.'/rollback-product-description-html.sql', implode('', $rbLines));

// Category counts (expect 0)
$catCounts = [];
foreach ([
    'it'=>'description','en'=>'description_en','de'=>'description_de',
    'fr'=>'description_fr','es'=>'description_es',
] as $lang=>$col) {
    $n = 0; $ex = [];
    $rows = DB::table('categorie_new')->select('entity_id', $col)->whereNotNull($col)->where($col,'!=','')->get();
    foreach ($rows as $row) {
        if (hasTagMalformation((string)$row->$col)) {
            $n++;
            if (count($ex)<2) $ex[] = ['id'=>$row->entity_id,'snip'=>mb_substr((string)$row->$col,0,80)];
        }
    }
    $catCounts[$lang] = ['malformed'=>$n,'examples'=>$ex,'nonempty'=>count($rows)];
}

$report = [
    'generated_at' => date('c'),
    'scope_note' => 'Prodotti: un solo set IT (description, short_description). Nessuna colonna description_en/de/fr/es sui prodotti. Categorie: campi per lingua.',
    'products_it' => $counts,
    'categories_by_lang' => $catCounts,
    'failures' => $failures,
    'files' => [
        'fix' => 'seo-audit/html-fix/fix-product-description-html.sql',
        'backup' => 'seo-audit/html-fix/backup-product-description-html.sql',
        'rollback' => 'seo-audit/html-fix/rollback-product-description-html.sql',
        'generator' => 'seo-audit/html-fix/generate_fix.php',
    ],
];
file_put_contents($outDir.'/report.json', json_encode($report, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES));

echo json_encode([
    'products' => [
        'description' => ['malformed'=>$counts['description']['malformed_rows'],'fixed'=>$counts['description']['fixed'],'failed'=>$counts['description']['failed']],
        'short' => ['malformed'=>$counts['short_description']['malformed_rows'],'fixed'=>$counts['short_description']['fixed'],'failed'=>$counts['short_description']['failed']],
    ],
    'categories' => array_map(fn($c)=>$c['malformed'], $catCounts),
    'failures' => count($failures),
    'failure_ids' => array_map(fn($f)=>$f['id'].':'.$f['col'], $failures),
], JSON_PRETTY_PRINT);
