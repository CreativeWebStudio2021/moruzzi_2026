#!/bin/bash
# Monitor 4xx/5xx Googlebot sui log Apache di moruzzi.it.
# Conta solo IP verificati (rDNS *.googlebot.com / *.google.com + forward confirm,
# oppure range ufficiali Googlebot in cache). Gli UA Googlebot con IP non verificati
# finiscono nella sezione --- fake_googlebot --- (non generano alert).
# Alert: (403+429+5xx) verificati >= ALERT_HARD oppure 404 verificati >= ALERT_404.
# Il 410 è escluso dall'alert.
set -euo pipefail

LOGS=(
  /var/log/apache2/moruzzi.it-ssl-access.log
  /var/log/apache2/moruzzi.it-access.log
)

OUT_DIR=/var/log/moruzzi
REPORT="$OUT_DIR/googlebot-4xx-$(date +%F).log"
STATE="$OUT_DIR/googlebot-4xx.state"
ALERT_LOG="$OUT_DIR/googlebot-4xx-alerts.log"
IP_CACHE="$OUT_DIR/googlebot-ip-cache.tsv"
RANGES_CACHE="$OUT_DIR/googlebot-ipranges.json"
RANGES_URL="${RANGES_URL:-https://developers.google.com/static/search/apis/ipranges/googlebot.json}"
RANGES_MAX_AGE_SEC="${RANGES_MAX_AGE_SEC:-86400}"
IP_CACHE_MAX_AGE_SEC="${IP_CACHE_MAX_AGE_SEC:-604800}"

WINDOW_HOURS="${WINDOW_HOURS:-2}"
ALERT_HARD="${ALERT_HARD:-5}"   # 403 + 429 + 5xx (solo verificati)
ALERT_404="${ALERT_404:-20}"
TAIL_LINES="${TAIL_LINES:-400000}"
NO_ALERT="${NO_ALERT:-0}"
APPEND_REPORT="${APPEND_REPORT:-1}"
SKIP_DNS="${SKIP_DNS:-0}"
REFRESH_RANGES="${REFRESH_RANGES:-0}"

mkdir -p "$OUT_DIR"
touch "$IP_CACHE"

HOUR_FILTERS=$(
  for ((i=0; i<WINDOW_HOURS; i++)); do
    date -u -d "$i hour ago" +'[%d/%b/%Y:%H' 2>/dev/null || date -u -d "-$i hour" +'[%d/%b/%Y:%H'
  done | sort -u | paste -sd'|' -
)

TMP=$(mktemp)
TMP_LINES=$(mktemp)
TMP_IPS=$(mktemp)
TMP_VERIFIED=$(mktemp)
TMP_FAKE_IPS=$(mktemp)
TMP_FAKE=$(mktemp)
TMP_CIDR=$(mktemp)
trap 'rm -f "$TMP" "$TMP_LINES" "$TMP_IPS" "$TMP_VERIFIED" "$TMP_FAKE_IPS" "$TMP_FAKE" "$TMP_CIDR"' EXIT

# --- Googlebot official ranges (optional fast path) ---
refresh_ranges() {
  if command -v curl >/dev/null 2>&1; then
    curl -fsSL --max-time 20 "$RANGES_URL" -o "$RANGES_CACHE.tmp" \
      && mv "$RANGES_CACHE.tmp" "$RANGES_CACHE" \
      || rm -f "$RANGES_CACHE.tmp"
  fi
}

if [[ "$REFRESH_RANGES" == "1" ]] || [[ ! -f "$RANGES_CACHE" ]]; then
  refresh_ranges || true
elif [[ -f "$RANGES_CACHE" ]]; then
  age=$(( $(date +%s) - $(stat -c %Y "$RANGES_CACHE" 2>/dev/null || echo 0) ))
  if [[ "$age" -gt "$RANGES_MAX_AGE_SEC" ]]; then
    refresh_ranges || true
  fi
fi

# Estrai prefissi IPv4 dai ranges JSON (se presenti)
if [[ -f "$RANGES_CACHE" ]]; then
  python3 - "$RANGES_CACHE" "$TMP_CIDR" <<'PY' 2>/dev/null || true
import json, sys
src, dst = sys.argv[1], sys.argv[2]
try:
    data = json.load(open(src))
except Exception:
    open(dst, "w").close()
    raise SystemExit(0)
prefs = []
for p in data.get("prefixes", []):
    v4 = p.get("ipv4Prefix")
    if v4:
        prefs.append(v4)
open(dst, "w").write("\n".join(prefs) + ("\n" if prefs else ""))
PY
fi

ip_in_cidr_list() {
  local ip="$1"
  [[ -s "$TMP_CIDR" ]] || return 1
  python3 - "$ip" "$TMP_CIDR" <<'PY' 2>/dev/null
import ipaddress, sys
ip = ipaddress.ip_address(sys.argv[1])
for line in open(sys.argv[2]):
    line = line.strip()
    if not line:
        continue
    try:
        if ip in ipaddress.ip_network(line, strict=False):
            raise SystemExit(0)
    except ValueError:
        pass
raise SystemExit(1)
PY
}

# Cache: ip\tverdict\tts   verdict=verified|fake
cache_get() {
  local ip="$1" now cut
  now=$(date +%s)
  cut=$((now - IP_CACHE_MAX_AGE_SEC))
  awk -F'\t' -v ip="$ip" -v cut="$cut" '
    $1==ip && $3+0>=cut { print $2; exit }
  ' "$IP_CACHE"
}

cache_set() {
  local ip="$1" verdict="$2" now tmpc
  now=$(date +%s)
  tmpc=$(mktemp)
  awk -F'\t' -v ip="$ip" '$1!=ip {print}' "$IP_CACHE" > "$tmpc"
  printf '%s\t%s\t%s\n' "$ip" "$verdict" "$now" >> "$tmpc"
  mv "$tmpc" "$IP_CACHE"
}

verify_googlebot_ip() {
  local ip="$1" cached ptr fwd
  cached=$(cache_get "$ip" || true)
  if [[ "$cached" == "verified" || "$cached" == "fake" ]]; then
    [[ "$cached" == "verified" ]]
    return $?
  fi

  if ip_in_cidr_list "$ip"; then
    cache_set "$ip" "verified"
    return 0
  fi

  if [[ "$SKIP_DNS" == "1" ]]; then
    cache_set "$ip" "fake"
    return 1
  fi

  ptr=$(host "$ip" 2>/dev/null | awk '/domain name pointer/ {print $NF; exit}' | sed 's/\.$//')
  if [[ -z "$ptr" ]]; then
    cache_set "$ip" "fake"
    return 1
  fi
  if [[ ! "$ptr" =~ \.(googlebot|google)\.com$ ]]; then
    cache_set "$ip" "fake"
    return 1
  fi

  fwd=$(host "$ptr" 2>/dev/null || true)
  if echo "$fwd" | grep -Fq "$ip"; then
    cache_set "$ip" "verified"
    return 0
  fi

  cache_set "$ip" "fake"
  return 1
}

# --- Estrai hit Googlebot 4xx/5xx nella finestra ---
{
  for log in "${LOGS[@]}"; do
    [[ -f "$log" ]] || continue
    if [[ "$WINDOW_HOURS" -gt 6 ]]; then
      cat "$log"
    else
      tail -n "$TAIL_LINES" "$log"
    fi
  done
} | awk -v filters="$HOUR_FILTERS" '
  BEGIN {
    IGNORECASE = 1
    n = split(filters, f, "|")
    for (i = 1; i <= n; i++) if (f[i] != "") hour[f[i]] = 1
  }
  index($0, "Googlebot") == 0 { next }
  {
    ok = 0
    for (h in hour) if (index($0, h)) { ok = 1; break }
    if (!ok) next
  }
  {
    if (!match($0, /"[A-Z]+ [^"]+" [0-9]{3} /)) next
    req = substr($0, RSTART, RLENGTH)
    split(req, p, "\"")
    split(p[2], rq, " ")
    path = rq[2]
    status = p[3] + 0
    if (status < 400) next
    ip = $1
    print ip "\t" status "\t" path
  }
' > "$TMP_LINES"

cut -f1 "$TMP_LINES" | sort -u > "$TMP_IPS"

: > "$TMP_VERIFIED"
: > "$TMP_FAKE_IPS"
while read -r ip; do
  ip="${ip//[[:space:]]/}"
  [[ -z "$ip" ]] && continue
  if verify_googlebot_ip "$ip"; then
    printf '%s\n' "$ip" >> "$TMP_VERIFIED"
  else
    printf '%s\n' "$ip" >> "$TMP_FAKE_IPS"
  fi
done < "$TMP_IPS"

verified_ips=$(grep -c . "$TMP_VERIFIED" 2>/dev/null || echo 0)
fake_ips=$(grep -c . "$TMP_FAKE_IPS" 2>/dev/null || echo 0)

# Aggrega verified e fake separatamente
aggregate() {
  local ip_list="$1" out="$2"
  awk -F'\t' -v list="$ip_list" -v wh="$WINDOW_HOURS" -v filters="$HOUR_FILTERS" '
    BEGIN {
      while ((getline line < list) > 0) if (line != "") ok[line] = 1
      close(list)
    }
    {
      ip = $1; status = $2 + 0; path = $3
      if (!(ip in ok)) next
      if (status == 403) bucket = "403"
      else if (status == 404) bucket = "404"
      else if (status == 410) bucket = "410"
      else if (status == 429) bucket = "429"
      else if (status >= 500 && status <= 599) bucket = "5xx"
      else bucket = "other"
      key = bucket SUBSEP path
      count[key]++
      by_bucket[bucket]++
      by_status[status]++
      total++
      if (index(ips[key], ip) == 0)
        ips[key] = ips[key] (ips[key] == "" ? "" : ",") ip
    }
    END {
      c403 = by_bucket["403"]+0
      c404 = by_bucket["404"]+0
      c410 = by_bucket["410"]+0
      c429 = by_bucket["429"]+0
      c5xx = by_bucket["5xx"]+0
      coth = by_bucket["other"]+0
      hard = c403 + c429 + c5xx
      print "total_4xx5xx=" (total+0)
      print "count_403=" c403
      print "count_404=" c404
      print "count_410=" c410
      print "count_429=" c429
      print "count_5xx=" c5xx
      print "count_other=" coth
      print "alert_hard_sum=" hard
      for (s in by_status) print "status_" s "=" by_status[s]
      print "---top---"
      for (k in count) {
        split(k, a, SUBSEP)
        print a[1] "\t" count[k] "\t" a[2] "\t" ips[k]
      }
    }
  ' "$TMP_LINES" > "$out"
}

aggregate "$TMP_VERIFIED" "$TMP"
aggregate "$TMP_FAKE_IPS" "$TMP_FAKE"

sed -i "s/alert_hard_sum=.*/&  # 403+429+5xx verified (410 escluso)/" "$TMP" || true

read_count() {
  awk -F= -v k="$1" '$1==k {print $2; exit}' "$2"
}

c403=$(read_count count_403 "$TMP"); c403=${c403:-0}
c404=$(read_count count_404 "$TMP"); c404=${c404:-0}
c410=$(read_count count_410 "$TMP"); c410=${c410:-0}
c429=$(read_count count_429 "$TMP"); c429=${c429:-0}
c5xx=$(read_count count_5xx "$TMP"); c5xx=${c5xx:-0}
coth=$(read_count count_other "$TMP"); coth=${coth:-0}
total=$(read_count total_4xx5xx "$TMP"); total=${total:-0}
hard=$((c403 + c429 + c5xx))

f403=$(read_count count_403 "$TMP_FAKE"); f403=${f403:-0}
f404=$(read_count count_404 "$TMP_FAKE"); f404=${f404:-0}
f410=$(read_count count_410 "$TMP_FAKE"); f410=${f410:-0}
f429=$(read_count count_429 "$TMP_FAKE"); f429=${f429:-0}
f5xx=$(read_count count_5xx "$TMP_FAKE"); f5xx=${f5xx:-0}
foth=$(read_count count_other "$TMP_FAKE"); foth=${foth:-0}
ftotal=$(read_count total_4xx5xx "$TMP_FAKE"); ftotal=${ftotal:-0}

alert=0
alert_reason=""
if [[ "$hard" -ge "$ALERT_HARD" ]]; then
  alert=1
  alert_reason="hard=${hard}>=${ALERT_HARD} (403+429+5xx verified)"
fi
if [[ "$c404" -ge "$ALERT_404" ]]; then
  alert=1
  if [[ -n "$alert_reason" ]]; then
    alert_reason="$alert_reason; 404=${c404}>=${ALERT_404}"
  else
    alert_reason="404=${c404}>=${ALERT_404}"
  fi
fi

emit_bucket_tops() {
  local src="$1" label_prefix="$2"
  local b n
  for b in 403 404 410 429 5xx other; do
    n=$(awk -F= -v k="count_$b" '$1==k{print $2;exit}' "$src"); n=${n:-0}
    echo
    echo "--- ${label_prefix}top 10 status $b (n=$n) ---"
    awk -F'\t' -v b="$b" '/^---top---/{f=1; next} f && $1==b {print $2 "\t" $3 "\t" $4}' "$src" \
      | sort -rn | head -10
  done
}

emit_report() {
  echo "=== Googlebot 4xx/5xx monitor (verified IPs only) ==="
  echo "ts=$(date +%Y-%m-%dT%H:%M:%S%z)"
  echo "window_hours=$WINDOW_HOURS"
  echo "hour_filters=$HOUR_FILTERS"
  echo "verified_ips=$verified_ips"
  echo "fake_ips=$fake_ips"
  echo "alert_hard_threshold=$ALERT_HARD"
  echo "alert_404_threshold=$ALERT_404"
  awk '/^---top---/{exit} {print}' "$TMP"
  echo "alert_triggered=$alert"
  [[ -n "$alert_reason" ]] && echo "alert_reason=$alert_reason"
  echo "note=410 escluso dall'alert (venduti); alert solo su IP Googlebot verificati"
  emit_bucket_tops "$TMP" ""

  echo
  echo "--- fake_googlebot ---"
  echo "fake_total_4xx5xx=$ftotal"
  echo "fake_count_403=$f403"
  echo "fake_count_404=$f404"
  echo "fake_count_410=$f410"
  echo "fake_count_429=$f429"
  echo "fake_count_5xx=$f5xx"
  echo "fake_count_other=$foth"
  echo "note=UA Googlebot con IP non verificato (non genera alert)"
  emit_bucket_tops "$TMP_FAKE" "fake "
  echo
}

if [[ "$APPEND_REPORT" == "1" ]]; then
  emit_report | tee -a "$REPORT"
else
  emit_report
fi

{
  echo "last_total=$total"
  echo "last_403=$c403"
  echo "last_404=$c404"
  echo "last_410=$c410"
  echo "last_429=$c429"
  echo "last_5xx=$c5xx"
  echo "last_other=$coth"
  echo "last_hard=$hard"
  echo "last_fake_total=$ftotal"
  echo "last_verified_ips=$verified_ips"
  echo "last_fake_ips=$fake_ips"
  echo "last_alert=$alert"
  echo "last_run=$(date -Iseconds)"
  echo "last_window_hours=$WINDOW_HOURS"
} > "$STATE"

if [[ "$NO_ALERT" != "1" && "$alert" -eq 1 ]]; then
  {
    echo "$(date -Iseconds) ALERT $alert_reason"
    emit_report
    echo "-----"
  } >> "$ALERT_LOG"
fi

exit 0
