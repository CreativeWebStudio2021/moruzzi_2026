<?php

namespace App\Http\Controllers;

use App\Services\SitemapService;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SitemapController extends Controller
{
    public function __construct(
        protected SitemapService $sitemap
    ) {}

    public function index(): View
    {
        $sections = $this->sitemap->staticSections();
        $offersLink = $this->sitemap->offersLink();

        if ($offersLink) {
            $sections[0]['links'][] = $offersLink;
        }

        return view('web.sitemap.index', [
            'sections' => $sections,
            'categoryTree' => $this->sitemap->categoryTree(),
            'alternateUrls' => $this->sitemap->alternateUrls(
                fn (string $locale) => $this->sitemap->routeUrl($locale, 'sitemap')
            ),
            'xmlSitemaps' => [
                ['url' => route('sitemap.xml'), 'label' => __('sitemap.xml_index')],
                ['url' => route('sitemap.xml.pages'), 'label' => __('sitemap.xml_pages')],
                ['url' => route('sitemap.xml.images'), 'label' => __('sitemap.xml_images')],
                ['url' => route('sitemap.xml.videos'), 'label' => __('sitemap.xml_videos')],
            ],
        ]);
    }

    public function xml(): StreamedResponse
    {
        return $this->streamXml(function (): void {
            echo '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";

            foreach ($this->sitemap->xmlIndexEntries() as $entry) {
                echo "  <sitemap>\n";
                echo '    <loc>'.e($entry['loc'])."</loc>\n";
                echo '    <lastmod>'.e($entry['lastmod'])."</lastmod>\n";
                echo "  </sitemap>\n";
            }

            echo "</sitemapindex>\n";
        });
    }

    public function xmlPages(): StreamedResponse
    {
        return $this->streamXml(function (): void {
            echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">'."\n";

            foreach ($this->sitemap->xmlEntries() as $entry) {
                echo "  <url>\n";
                echo '    <loc>'.e($entry['loc'])."</loc>\n";

                if (! empty($entry['lastmod'])) {
                    echo '    <lastmod>'.e($entry['lastmod'])."</lastmod>\n";
                }

                foreach ($entry['alternates'] as $locale => $href) {
                    echo '    <xhtml:link rel="alternate" hreflang="'.e($locale).'" href="'.e($href).'" />'."\n";
                }

                echo '    <xhtml:link rel="alternate" hreflang="x-default" href="'.e($entry['alternates']['it']).'" />'."\n";
                echo "  </url>\n";
            }

            echo "</urlset>\n";
        });
    }

    public function xmlImages(): StreamedResponse
    {
        return $this->streamXml(function (): void {
            echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">'."\n";

            foreach ($this->sitemap->xmlImageEntries() as $entry) {
                echo "  <url>\n";
                echo '    <loc>'.e($entry['loc'])."</loc>\n";

                foreach ($entry['images'] as $image) {
                    echo "    <image:image>\n";
                    echo '      <image:loc>'.e($image['loc'])."</image:loc>\n";
                    if ($image['title'] !== '') {
                        echo '      <image:title>'.e($image['title'])."</image:title>\n";
                    }
                    echo "    </image:image>\n";
                }

                echo "  </url>\n";
            }

            echo "</urlset>\n";
        });
    }

    public function xmlVideos(): StreamedResponse
    {
        return $this->streamXml(function (): void {
            echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:video="http://www.google.com/schemas/sitemap-video/1.1">'."\n";

            foreach ($this->sitemap->xmlVideoEntries() as $entry) {
                $video = $entry['video'];

                echo "  <url>\n";
                echo '    <loc>'.e($entry['loc'])."</loc>\n";
                echo "    <video:video>\n";
                echo '      <video:thumbnail_loc>'.e($video['thumbnail_loc'])."</video:thumbnail_loc>\n";
                echo '      <video:title>'.e($video['title'])."</video:title>\n";
                echo '      <video:description>'.e($video['description'])."</video:description>\n";

                if (! empty($video['player_loc'])) {
                    echo '      <video:player_loc>'.e($video['player_loc'])."</video:player_loc>\n";
                }

                if (! empty($video['content_loc'])) {
                    echo '      <video:content_loc>'.e($video['content_loc'])."</video:content_loc>\n";
                }

                echo "    </video:video>\n";
                echo "  </url>\n";
            }

            echo "</urlset>\n";
        });
    }

    protected function streamXml(callable $writer): StreamedResponse
    {
        return response()->stream(function () use ($writer): void {
            echo '<?xml version="1.0" encoding="UTF-8"?>'."\n";
            $writer();
        }, 200, [
            'Content-Type' => 'application/xml; charset=UTF-8',
            'Cache-Control' => 'public, max-age=3600',
        ]);
    }
}
