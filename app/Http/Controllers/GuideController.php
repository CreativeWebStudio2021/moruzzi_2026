<?php

namespace App\Http\Controllers;

use App\Services\GuideCommerceService;
use App\Support\GuideRegistry;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class GuideController extends Controller
{
    public function __construct(
        private readonly GuideCommerceService $guideCommerce,
    ) {}

    public function index(): View
    {
        return $this->renderArticle('guide.index');
    }

    public function show(): View|RedirectResponse
    {
        $routeName = $this->resolveGuideRouteName();

        if ($routeName === null) {
            abort(404);
        }

        $article = GuideRegistry::findByRoute($routeName);
        if ($article !== null && $article['route'] !== 'guide.index') {
            $locale = app()->getLocale();
            $canonicalPath = GuideRegistry::pathForArticle($article, $locale);
            $currentPath = trim(request()->path(), '/');

            if ($locale !== 'it' && str_starts_with($currentPath, $locale.'/')) {
                $currentPath = substr($currentPath, strlen($locale) + 1);
            }

            if ($currentPath !== $canonicalPath) {
                return redirect()->to(locale_route($routeName), 301);
            }
        }

        return $this->renderArticle($routeName);
    }

    private function resolveGuideRouteName(): ?string
    {
        $routeName = request()->route()?->getName();

        if ($routeName !== null && str_starts_with($routeName, 'locale.')) {
            $routeName = substr($routeName, strlen('locale.'));
        }

        if ($routeName !== null && GuideRegistry::findByRoute($routeName) !== null) {
            return $routeName;
        }

        $path = trim(request()->path(), '/');
        $locale = app()->getLocale();

        if ($locale !== 'it' && str_starts_with($path, $locale.'/')) {
            $path = substr($path, strlen($locale) + 1);
        }

        $article = GuideRegistry::findByPath($path, $locale);

        return $article['route'] ?? null;
    }

    private function renderArticle(string $routeName): View|RedirectResponse
    {
        $article = GuideRegistry::findByRoute($routeName);

        if ($article === null) {
            abort(404);
        }

        if (! empty($article['redirect_route'])) {
            return redirect()->to(locale_route($article['redirect_route']), 301);
        }

        $guideKey = $article['id'];
        $guideProducts = $this->guideCommerce->productsForArticle($guideKey);
        $guideCatalogUrl = $this->guideCommerce->catalogUrlForArticle($guideKey);

        if ($routeName === 'guide.index') {
            return view('web.guide.hub', [
                'article' => $article,
                'guideKey' => $guideKey,
                'sectionKey' => $article['section'],
                'sectionArticles' => [],
                'guideProducts' => collect(),
                'guideCatalogUrl' => null,
            ]);
        }

        $sectionArticles = collect(GuideRegistry::articles())
            ->filter(fn (array $item) => $item['section'] === $article['section'] && ($item['nav'] ?? true))
            ->filter(fn (array $item) => $item['route'] !== 'guide.index')
            ->values()
            ->all();

        return view('web.guide.show', [
            'article' => $article,
            'guideKey' => $guideKey,
            'sectionKey' => $article['section'],
            'sectionArticles' => $sectionArticles,
            'guideProducts' => $guideProducts,
            'guideCatalogUrl' => $guideCatalogUrl,
        ]);
    }
}
