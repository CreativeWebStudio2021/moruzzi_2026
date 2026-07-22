<?php

namespace App\Providers;

use App\Models\Category;
use App\Listeners\MergeCartAfterLogin;
use App\Services\MetaTagsService;
use App\Support\GuideRegistry;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        config([
            'localized_slugs' => array_merge(
                config('localized_slugs', []),
                GuideRegistry::localizedSlugs()
            ),
            'legacy_redirects.files' => array_merge(
                config('legacy_category_redirects.files', []),
                config('legacy_redirects.files', []),
                GuideRegistry::legacyRedirects(),
                config('legacy_lang_guide_map.files', []),
                config('legacy_editorial_redirects.files', []),
                config('legacy_lang_editorial_redirects.files', []),
                self::moneteDiRedirectRules(),
            ),
        ]);

        Event::listen(Login::class, MergeCartAfterLogin::class);

        View::composer('web.layout', function ($view) {
            $errorPage = View::shared('error_page');

            if (in_array($errorPage, ['404', '500', '503'], true)) {
                $view->with('metaTitle', __("errors.{$errorPage}.meta_title") . ' | ' . config('app.name'))
                    ->with('metaDescription', __("errors.{$errorPage}.meta_description"))
                    ->with('metaImage', '');

                return;
            }

            $meta = app(MetaTagsService::class)->getMeta(request());
            $view->with('metaTitle', $meta['title'])
                ->with('metaDescription', $meta['description'])
                ->with('metaImage', $meta['image'] ?? '');
        });

        $tags = cache_remember_safe(
            'categories_structure',
            now()->addHours(12),
            function () {
                return Category::where('level', 2)
                    ->where('parent_id', 2)
                    ->whereNotIn('entity_id', [1436, 969, 1435])
                    ->orderBy('position')
                    ->with('childrenRecursive')
                    ->get();
            }
        );

        View::share('tags', $tags);
    }

    /**
     * @return array<string, array{paths: array{it: string}}>
     */
    private static function moneteDiRedirectRules(): array
    {
        $rules = [];

        foreach (config('legacy_monete_di_redirects.files', []) as $filename => $path) {
            $rules[$filename] = ['paths' => ['it' => $path]];
        }

        return $rules;
    }
}
