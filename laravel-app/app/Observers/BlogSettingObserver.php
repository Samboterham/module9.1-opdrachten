<?php

namespace App\Observers;

use App\Models\BlogSetting;
use App\Services\BlogPageData;
use Illuminate\Support\Facades\Cache;

class BlogSettingObserver
{
    public function saved(BlogSetting $blogSetting): void
    {
        Cache::forget(BlogPageData::CACHE_KEY);
    }

    public function deleted(BlogSetting $blogSetting): void
    {
        Cache::forget(BlogPageData::CACHE_KEY);
    }
}
