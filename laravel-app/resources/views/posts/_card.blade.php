<article class="transition-colors duration-300 hover:bg-gray-100 border border-black border-opacity-0 hover:border-opacity-5 rounded-xl">
    <div class="py-6 px-5 {{ $featured ? 'lg:flex' : '' }}">
        @if ($post->image_path)
            <div class="{{ $featured ? 'flex-1 lg:mr-8' : '' }}">
                <img src="{{ asset($post->image_path) }}" alt="{{ $post->title }}" class="rounded-xl w-full">
            </div>
        @endif

        <div class="{{ $featured ? 'flex-1 flex flex-col justify-between' : 'mt-8 flex flex-col justify-between' }}">
            <header class="{{ $featured ? 'mt-8 lg:mt-0' : '' }}">
                <div class="space-x-2">
                    @foreach ($post->categories as $category)
                        <a href="{{ route('posts.index', ['category' => $category->slug]) }}"
                           class="px-3 py-1 border {{ $category->border_color }} {{ $category->text_color }} rounded-full text-xs uppercase font-semibold"
                           style="font-size: 10px">{{ $category->name }}</a>
                    @endforeach
                </div>

                <div class="mt-4">
                    <h2 class="{{ $featured ? 'text-3xl' : 'text-2xl' }}">{{ $post->title }}</h2>
                    <span class="mt-2 block text-gray-400 text-xs">
                        {{ $settings['published_label'] ?? '' }} <time datetime="{{ $post->published_at->toDateString() }}">{{ $post->published_at->diffForHumans() }}</time>
                    </span>
                </div>
            </header>

            <p class="text-sm mt-4">{{ $post->excerpt }}</p>

            <footer class="flex justify-between items-center mt-8">
                <div class="flex items-center text-sm">
                    @if ($post->author->avatar_path)
                        <img src="{{ asset($post->author->avatar_path) }}" alt="{{ $post->author->name }}">
                    @endif
                    <div class="ml-3">
                        <h3 class="font-bold">{{ $post->author->name }}</h3>
                        <p>{{ $post->author->role }}</p>
                    </div>
                </div>

                <a href="{{ route('posts.show', $post->slug) }}"
                   class="transition-colors duration-300 text-xs font-semibold bg-gray-200 hover:bg-gray-300 rounded-full py-2 px-8">
                    {{ $settings['read_more_label'] ?? '' }}
                </a>
            </footer>
        </div>
    </div>
</article>
