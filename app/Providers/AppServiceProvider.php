<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Company;
use App\Models\Page;

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
        // Share the $company variable globally
        View::share('company', Company::first());

        // Share the slugs of pages globally
        $pages = Page::select('title', 'slug')->get();
        View::share('pages', $pages);

    }
}
