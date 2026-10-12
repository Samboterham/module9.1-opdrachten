<?php

namespace App\Observers;

use App\Models\Author;
use App\Services\BlogPageData;
use Illuminate\Support\Facades\Cache;

class AuthorObserver
{
    public function saved(Author $author): void
    {
        Cache::forget(BlogPageData::CACHE_KEY);
    }

    public function deleted(Author $author): void
    {
        Cache::forget(BlogPageData::CACHE_KEY);
    }
}
