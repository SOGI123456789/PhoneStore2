<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use App\Models\Category;

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
        View::composer('partials.headerKH', function ($view) {
            $parentCategories = Category::whereNull('parent_id')
                ->with(['products', 'children.products'])
                ->get();
            $view->with('parentCategories', $parentCategories);
        });
    }
}
