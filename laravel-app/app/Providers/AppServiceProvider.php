<?php

namespace App\Providers;

use App\Models\Author;
use App\Models\BlogSetting;
use App\Models\Category;
use App\Models\Post;
use App\Observers\AuthorObserver;
use App\Observers\BlogSettingObserver;
use App\Observers\CategoryObserver;
use App\Observers\PostObserver;
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
        Author::observe(AuthorObserver::class);
        Post::observe(PostObserver::class);
        Category::observe(CategoryObserver::class);
        BlogSetting::observe(BlogSettingObserver::class);
    }
}
