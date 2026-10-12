@extends('layouts.blog')

@section('content')
    <header class="max-w-xl mx-auto mt-20 text-center">
        <h1 class="text-4xl">
            {{ $settings['home_heading_prefix'] ?? '' }}
            <span class="text-blue-500">{{ $settings['home_heading_title'] ?? '' }}</span>
        </h1>

        @if ($author)
            <h2 class="inline-flex mt-2">
                {{ $settings['home_byline_prefix'] ?? '' }} {{ $author->name }}
                @if ($author->avatar_path)
                    <img src="{{ asset($settings['home_author_image_path'] ?? 'images/lary-head.svg') }}" alt="{{ $author->name }}" class="ml-1">
                @endif
            </h2>
        @endif

        <p class="text-sm mt-14">{{ $settings['home_intro'] ?? '' }}</p>

        <form method="GET" action="{{ route('posts.index') }}" class="space-y-2 lg:space-y-0 lg:space-x-4 mt-8">
            <div class="relative flex lg:inline-flex items-center bg-gray-100 rounded-xl">
                <label for="category-filter" class="sr-only">{{ $settings['category_filter_label'] ?? '' }}</label>
                <select id="category-filter" name="category" onchange="this.form.submit()"
                        class="flex-1 appearance-none bg-transparent py-2 pl-3 pr-9 text-sm font-semibold">
                    <option value="">{{ $settings['category_filter_label'] ?? '' }}</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->slug }}" @selected($filters['category'] === $category->slug)>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="relative flex lg:inline-flex items-center bg-gray-100 rounded-xl">
                <label for="other-filter" class="sr-only">{{ $settings['other_filter_label'] ?? '' }}</label>
                <select id="other-filter" name="filter" onchange="this.form.submit()"
                        class="flex-1 appearance-none bg-transparent py-2 pl-3 pr-9 text-sm font-semibold">
                    <option value="all" @selected($filters['filter'] === 'all')>{{ $settings['all_posts_filter_label'] ?? '' }}</option>
                    <option value="featured" @selected($filters['filter'] === 'featured')>{{ $settings['featured_filter_label'] ?? '' }}</option>
                </select>
            </div>

            <div class="relative flex lg:inline-flex items-center bg-gray-100 rounded-xl px-3 py-2">
                <label for="search-input" class="sr-only">{{ $settings['search_placeholder'] ?? '' }}</label>
                <input id="search-input" type="search" name="search" value="{{ $filters['search'] }}"
                       placeholder="{{ $settings['search_placeholder'] ?? '' }}"
                       class="bg-transparent placeholder-black font-semibold text-sm">
                <button type="submit" class="sr-only">{{ $settings['search_submit_label'] ?? '' }}</button>
            </div>
        </form>
    </header>

    <main class="max-w-6xl mx-auto mt-6 lg:mt-20 space-y-6">
        @if ($posts->isEmpty())
            <p class="text-center text-gray-500">{{ $settings['no_posts_message'] ?? '' }}</p>
        @else
            @include('posts._card', ['post' => $posts->first(), 'featured' => true])

            @if ($posts->count() > 1)
                <div class="grid gap-6 lg:grid-cols-2">
                    @foreach ($posts->skip(1) as $post)
                        @include('posts._card', ['post' => $post, 'featured' => false])
                    @endforeach
                </div>
            @endif
        @endif
    </main>
@endsection
