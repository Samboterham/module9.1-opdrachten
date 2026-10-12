<?php

namespace App\Services;

use App\Models\Author;
use App\Models\BlogSetting;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Support\Facades\Cache;

class BlogPageData
{
    public const CACHE_KEY = 'blog.page-data';

    public function all(): array
    {
        $pageCopy = Cache::remember(self::CACHE_KEY, now()->addMinutes(5), function (): array {
            return [
                'categories' => Category::query()->orderBy('name')->get()->toArray(),
                'author' => Author::query()->first()?->toArray(),
                'settings' => BlogSetting::query()->pluck('value', 'key')->all(),
            ];
        });

        return [
            'posts' => Post::published()
                ->with(['author', 'categories'])
                ->orderByDesc('is_featured')
                ->orderByDesc('published_at')
                ->get(),
            'categories' => Category::hydrate($pageCopy['categories']),
            'author' => $pageCopy['author'] === null
                ? null
                : Author::hydrate([$pageCopy['author']])->first(),
            'settings' => collect($pageCopy['settings']),
        ];
    }

    public function findPost(string $slug): ?Post
    {
        return $this->all()['posts']->firstWhere('slug', $slug);
    }
}
