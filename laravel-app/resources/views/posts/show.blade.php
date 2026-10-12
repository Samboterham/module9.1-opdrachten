@extends('layouts.blog')

@section('content')
    <main class="max-w-6xl mx-auto mt-10 lg:mt-20 space-y-6">
        <article class="max-w-4xl mx-auto lg:grid lg:grid-cols-12 gap-x-10">
            <div class="col-span-4 lg:text-center lg:pt-14 mb-10">
                @if ($post->image_path)
                    <img src="{{ asset($post->image_path) }}" alt="{{ $post->title }}" class="rounded-xl">
                @endif

                <p class="mt-4 block text-gray-400 text-xs">
                    {{ $settings['published_label'] ?? '' }} <time datetime="{{ $post->published_at->toDateString() }}">{{ $post->published_at->diffForHumans() }}</time>
                </p>

                <div class="flex items-center lg:justify-center text-sm mt-4">
                    @if ($post->author->avatar_path)
                        <img src="{{ asset($post->author->avatar_path) }}" alt="{{ $post->author->name }}">
                    @endif
                    <div class="ml-3 text-left">
                        <h2 class="font-bold">{{ $post->author->name }}</h2>
                        <p>{{ $post->author->role }}</p>
                    </div>
                </div>
            </div>

            <div class="col-span-8">
                <div class="flex justify-between mb-6">
                    <a href="{{ route('posts.index') }}"
                       class="transition-colors duration-300 relative inline-flex items-center text-lg hover:text-blue-500">
                        <span aria-hidden="true" class="mr-2">&larr;</span>
                        {{ $settings['back_to_posts_label'] ?? '' }}
                    </a>

                    <div class="space-x-2">
                        @foreach ($post->categories as $category)
                            <a href="{{ route('posts.index', ['category' => $category->slug]) }}"
                               class="px-3 py-1 border {{ $category->border_color }} {{ $category->text_color }} rounded-full text-xs uppercase font-semibold"
                               style="font-size: 10px">{{ $category->name }}</a>
                        @endforeach
                    </div>
                </div>

                <h1 class="font-bold text-3xl lg:text-4xl mb-10">{{ $post->title }}</h1>
                <div class="space-y-4 lg:text-lg leading-loose">
                    @foreach (preg_split('/\R{2,}/', $post->body) as $paragraph)
                        <p>{{ $paragraph }}</p>
                    @endforeach
                </div>
            </div>
        </article>
    </main>
@endsection
