<?php

use App\Http\Controllers\GuideController;
use App\Support\GuideRegistry;
use Illuminate\Support\Facades\Route;

$registerGuideRoutes = function (): void {
    foreach (GuideRegistry::articles() as $article) {
        $path = GuideRegistry::pathForArticle($article, 'it');

        if ($path === '') {
            continue;
        }

        Route::get('/'.$path, [GuideController::class, 'show'])
            ->name($article['route']);
    }
};

return $registerGuideRoutes;
