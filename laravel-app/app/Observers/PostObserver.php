<?php

namespace App\Observers;

use App\Models\Post;
use App\Services\BlogPageData;
use Illuminate\Support\Facades\Cache;

class PostObserver
{
    public function saved(Post $post): void
    {
        Cache::forget(BlogPageData::CACHE_KEY);
    }

    public function deleted(Post $post): void
    {
        Cache::forget(BlogPageData::CACHE_KEY);
    }
}
