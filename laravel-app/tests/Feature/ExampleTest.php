<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function test_the_home_page_links_to_the_article(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('href="#newsletter"', false)
            ->assertSee('id="newsletter"', false)
            ->assertSee(route('posts.show'), false)
            ->assertSee('id="category-filter"', false)
            ->assertSee('id="other-filter"', false)
            ->assertSee('id="search-input"', false)
            ->assertSee('id="no-posts-found"', false)
            ->assertSee('data-category="techniques updates"', false)
            ->assertSee('data-category="techniques"', false)
            ->assertSee('data-category="updates"', false);
    }

    public function test_the_article_page_is_available(): void
    {
        $this->get(route('posts.show'))
            ->assertOk()
            ->assertSee('href="#newsletter"', false)
            ->assertSee('id="newsletter"', false)
            ->assertSee('href="' . url('/') . '"', false)
            ->assertSee('Back to Posts')
            ->assertSee('This is a big title');
    }
}
