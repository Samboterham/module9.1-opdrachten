<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\BlogSetting;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $author = Author::updateOrCreate(
            ['name' => 'Lary Laracore'],
            ['role' => 'Mascot at Laracasts', 'avatar_path' => 'images/lary-avatar.svg'],
        );

        $categories = collect([
            [
                'name' => 'Techniques',
                'slug' => 'techniques',
                'border_color' => 'border-blue-300',
                'text_color' => 'text-blue-300',
            ],
            [
                'name' => 'Updates',
                'slug' => 'updates',
                'border_color' => 'border-red-300',
                'text_color' => 'text-red-300',
            ],
        ])->mapWithKeys(fn (array $category): array => [
            $category['slug'] => Category::updateOrCreate(
                ['slug' => $category['slug']],
                $category,
            ),
        ]);

        $settings = [
            'site_title' => 'Laravel From Scratch Blog',
            'site_logo_path' => 'images/logo.svg',
            'home_heading_prefix' => 'Latest',
            'home_heading_title' => 'Laravel From Scratch News',
            'home_intro' => "Another year. Another update. We're refreshing the popular Laravel series with new content. I'm going to keep you guys up to speed with what's going on!",
            'home_byline_prefix' => 'By',
            'home_author_image_path' => 'images/lary-head.svg',
            'home_nav_label' => 'Home Page',
            'subscribe_link_label' => 'Subscribe for Updates',
            'read_more_label' => 'Read More',
            'back_to_posts_label' => 'Back to Posts',
            'published_label' => 'Published',
            'category_filter_label' => 'All Categories',
            'other_filter_label' => 'Other Filters',
            'all_posts_filter_label' => 'All Posts',
            'featured_filter_label' => 'Featured Post Only',
            'search_placeholder' => 'Find something',
            'newsletter_image_path' => 'images/lary-newsletter-icon.svg',
            'newsletter_mailbox_image_path' => 'images/mailbox-icon.svg',
            'search_submit_label' => 'Search posts',
            'newsletter_title' => 'Stay in touch with the latest posts',
            'newsletter_text' => 'Promise to keep the inbox clean. No bugs.',
            'newsletter_email_placeholder' => 'Your email address',
            'newsletter_button_label' => 'Subscribe',
            'no_posts_message' => 'No posts match your filters.',
        ];

        foreach ($settings as $key => $value) {
            BlogSetting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        $posts = [
            [
                'slug' => 'laravel-from-scratch-news',
                'title' => 'A Fresh Start with Laravel',
                'image_path' => 'images/illustration-1.png',
                'excerpt' => 'Start building with Laravel: explore the framework, learn its core ideas, and follow the latest news from Laracasts.',
                'body' => "Welcome to the Laravel From Scratch blog. This is where we share practical lessons, useful techniques, and news from the Laravel community.\n\nExplore the articles to learn about collections, controllers, Eloquent relationships, and the latest framework updates.\n\nUse the category filters or search to find the topics that interest you.",
                'categories' => ['techniques', 'updates'],
                'is_featured' => true,
                'published_at' => now()->subDay(),
            ],
            [
                'slug' => 'laravel-collections',
                'title' => 'Working with Laravel Collections',
                'image_path' => 'images/illustration-1.png',
                'excerpt' => 'Discover techniques for working with Laravel collections and transforming application data.',
                'body' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.\n\nDuis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.",
                'categories' => ['techniques'],
                'is_featured' => false,
                'published_at' => now()->subDays(2),
            ],
            [
                'slug' => 'laravel-product-updates',
                'title' => 'The Latest Laravel Updates',
                'image_path' => 'images/illustration-2.png',
                'excerpt' => 'The latest updates and improvements from the Laravel ecosystem.',
                'body' => "Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium.\n\nNemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit.",
                'categories' => ['updates'],
                'is_featured' => false,
                'published_at' => now()->subDays(3),
            ],
            [
                'slug' => 'organizing-laravel-controllers',
                'title' => 'Organizing Laravel Controllers',
                'image_path' => 'images/illustration-3.png',
                'excerpt' => 'Practical techniques for keeping Laravel controllers organized and easy to maintain.',
                'body' => "Magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet.\n\nUt enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam.",
                'categories' => ['techniques'],
                'is_featured' => false,
                'published_at' => now()->subDays(4),
            ],
            [
                'slug' => 'laravel-release-notes',
                'title' => 'What Changed in Laravel',
                'image_path' => 'images/illustration-4.png',
                'excerpt' => 'A closer look at recent framework changes and what they mean for your projects.',
                'body' => "Another year. Another update. We're refreshing the popular Laravel series with new content.\n\nKeep up to speed with what's changing in the framework.",
                'categories' => ['updates'],
                'is_featured' => false,
                'published_at' => now()->subDays(5),
            ],
            [
                'slug' => 'eloquent-relationships',
                'title' => 'Understanding Eloquent Relationships',
                'image_path' => 'images/illustration-5.png',
                'excerpt' => 'Learn how to connect related records using Eloquent relationships.',
                'body' => "Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur.\n\nExplore these techniques and put them to work in your Laravel application.",
                'categories' => ['techniques', 'updates'],
                'is_featured' => false,
                'published_at' => now()->subDays(6),
            ],
        ];

        foreach ($posts as $postData) {
            $categorySlugs = $postData['categories'];
            unset($postData['categories']);

            $post = Post::updateOrCreate(
                ['slug' => $postData['slug']],
                [...$postData, 'author_id' => $author->id],
            );

            $post->categories()->sync($categories->only($categorySlugs)->pluck('id'));
        }
    }
}
