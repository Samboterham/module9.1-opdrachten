<?php

namespace App\Observers;

use App\Models\Category;
use App\Services\BlogPageData;
use Illuminate\Support\Facades\Cache;

class CategoryObserver
{
    public function saved(Category $category): void
    {
        Cache::forget(BlogPageData::CACHE_KEY);
    }

    public function deleted(Category $category): void
    {
        Cache::forget(BlogPageData::CACHE_KEY);
    }
}
