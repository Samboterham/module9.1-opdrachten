<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Services\BlogPageData;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function __construct(private readonly BlogPageData $blogPageData) {}

    public function index(Request $request): View
    {
        $filters = $request->validate([
            'category' => ['nullable', 'string', 'exists:categories,slug'],
            'filter' => ['nullable', 'in:all,featured'],
            'search' => ['nullable', 'string', 'max:100'],
        ]);

        $data = $this->blogPageData->all();
        $search = mb_strtolower(trim($filters['search'] ?? ''));

        $data['posts'] = $data['posts']
            ->filter(function (Post $post) use ($filters, $search): bool {
                if (isset($filters['category']) && ! $post->categories->contains('slug', $filters['category'])) {
                    return false;
                }

                if (($filters['filter'] ?? 'all') === 'featured' && ! $post->is_featured) {
                    return false;
                }

                if ($search !== '') {
                    $searchableText = mb_strtolower(implode(' ', [
                        $post->title,
                        $post->excerpt,
                        $post->body,
                        $post->author->name,
                        $post->categories->pluck('name')->implode(' '),
                    ]));

                    if (! str_contains($searchableText, $search)) {
                        return false;
                    }
                }

                return true;
            })
            ->values();

        $data['filters'] = [
            'category' => $filters['category'] ?? '',
            'filter' => $filters['filter'] ?? 'all',
            'search' => $filters['search'] ?? '',
        ];

        return view('posts.index', $data);
    }

    public function show(string $slug): View
    {
        $data = $this->blogPageData->all();
        $post = $this->blogPageData->findPost($slug);

        abort_unless($post, 404);

        $data['post'] = $post;

        return view('posts.show', $data);
    }
}
