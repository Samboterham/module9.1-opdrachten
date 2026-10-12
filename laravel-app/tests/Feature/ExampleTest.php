<?php

namespace Tests\Feature;

use App\Models\BlogSetting;
use App\Models\Post;
use App\Services\BlogPageData;
use Database\Seeders\BlogSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(BlogSeeder::class);
    }

    public function test_the_home_page_renders_seeded_posts_and_database_copy(): void
    {
        $this->get(route('posts.index'))
            ->assertOk()
            ->assertSee('Laravel From Scratch News')
            ->assertSee('Lary Laracore')
            ->assertSee('Stay in touch with the latest posts')
            ->assertSee(route('posts.show', 'laravel-from-scratch-news'), false)
            ->assertSee(route('posts.show', 'eloquent-relationships'), false);
    }

    public function test_the_category_filter_returns_only_matching_posts(): void
    {
        $this->get(route('posts.index', ['category' => 'updates']))
            ->assertOk()
            ->assertSee(route('posts.show', 'laravel-product-updates'), false)
            ->assertDontSee(route('posts.show', 'laravel-collections'), false);
    }

    public function test_the_featured_filter_returns_only_the_featured_post(): void
    {
        $this->get(route('posts.index', ['filter' => 'featured']))
            ->assertOk()
            ->assertSee(route('posts.show', 'laravel-from-scratch-news'), false)
            ->assertDontSee(route('posts.show', 'laravel-product-updates'), false);
    }

    public function test_search_matches_post_content(): void
    {
        $this->get(route('posts.index', ['search' => 'eloquent relationships']))
            ->assertOk()
            ->assertSee(route('posts.show', 'eloquent-relationships'), false)
            ->assertDontSee(route('posts.show', 'laravel-product-updates'), false);
    }

    public function test_article_page_loads_post_and_related_database_data(): void
    {
        $this->get(route('posts.show', 'eloquent-relationships'))
            ->assertOk()
            ->assertSee('Understanding Eloquent Relationships')
            ->assertSee('Lary Laracore')
            ->assertSee('Back to Posts')
            ->assertSee('Techniques');
    }

    public function test_unknown_article_returns_a_not_found_response(): void
    {
        $this->get(route('posts.show', 'does-not-exist'))
            ->assertNotFound();
    }

    public function test_new_posts_are_visible_after_the_page_data_was_cached(): void
    {
        $this->get(route('posts.index'))->assertOk();

        $post = Post::create([
            'author_id' => 1,
            'title' => 'A newly published database post',
            'slug' => 'new-database-post',
            'excerpt' => 'Fresh content from the database.',
            'body' => 'The post observer clears the cached blog page data.',
            'is_featured' => false,
            'published_at' => now(),
        ]);
        $post->categories()->attach(1);

        $this->get(route('posts.index'))
            ->assertOk()
            ->assertSee(route('posts.show', 'new-database-post'), false);
    }

    public function test_updated_blog_settings_are_visible_after_the_page_data_was_cached(): void
    {
        $this->get(route('posts.index'))->assertOk();

        BlogSetting::where('key', 'newsletter_title')->firstOrFail()
            ->update(['value' => 'A fresh newsletter heading']);

        $this->get(route('posts.index'))
            ->assertOk()
            ->assertSee('A fresh newsletter heading');
    }

    public function test_page_cache_contains_plain_database_values_not_eloquent_models(): void
    {
        app(BlogPageData::class)->all();

        $cachedPageCopy = Cache::get(BlogPageData::CACHE_KEY);

        $this->assertIsArray($cachedPageCopy);
        $this->assertIsArray($cachedPageCopy['categories']);
        $this->assertIsArray($cachedPageCopy['categories'][0]);
        $this->assertIsArray($cachedPageCopy['author']);
        $this->assertIsArray($cachedPageCopy['settings']);
    }
}
