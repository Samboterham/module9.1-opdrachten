<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $settings['site_title'] ?? 'Blog' }}</title>
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body style="font-family: Open Sans, sans-serif">
    <section class="px-6 py-8">
        <nav class="md:flex md:justify-between md:items-center">
            <a href="{{ route('posts.index') }}">
                <img src="{{ asset($settings['site_logo_path'] ?? 'images/logo.svg') }}" alt="{{ $settings['site_title'] ?? 'Blog' }}" width="165" height="16">
            </a>

            <div class="mt-8 md:mt-0">
                <a href="{{ route('posts.index') }}" class="text-xs font-bold uppercase">{{ $settings['home_nav_label'] ?? '' }}</a>
                <a href="#newsletter"
                   class="transition-colors duration-300 bg-blue-500 hover:bg-blue-600 ml-3 rounded-full text-xs font-semibold text-white uppercase py-3 px-5">
                    {{ $settings['subscribe_link_label'] ?? 'Subscribe for Updates' }}
                </a>
            </div>
        </nav>

        @yield('content')

        <footer id="newsletter" class="bg-gray-100 border border-black border-opacity-5 rounded-xl text-center py-16 px-10 mt-16">
            <img src="{{ asset($settings['newsletter_image_path'] ?? 'images/lary-newsletter-icon.svg') }}" alt="" class="mx-auto -mb-6" style="width: 145px;">
            <h2 class="text-3xl">{{ $settings['newsletter_title'] ?? '' }}</h2>
            <p class="text-sm mt-3">{{ $settings['newsletter_text'] ?? '' }}</p>

            <div class="mt-10">
                <div class="relative inline-block mx-auto lg:bg-gray-200 rounded-full">
                    <form method="POST" action="#" class="lg:flex text-sm">
                        <div class="lg:py-3 lg:px-5 flex items-center">
                            <label for="email" class="hidden lg:inline-block">
                                <img src="{{ asset($settings['newsletter_mailbox_image_path'] ?? 'images/mailbox-icon.svg') }}" alt="">
                            </label>
                            <input id="email" type="email" placeholder="{{ $settings['newsletter_email_placeholder'] ?? '' }}"
                                   class="lg:bg-transparent pl-4 focus-within:outline-none">
                        </div>
                        <button type="submit"
                                class="transition-colors duration-300 bg-blue-500 hover:bg-blue-600 mt-4 lg:mt-0 lg:ml-3 rounded-full text-xs font-semibold text-white uppercase py-3 px-8">
                            {{ $settings['newsletter_button_label'] ?? '' }}
                        </button>
                    </form>
                </div>
            </div>
        </footer>
    </section>
</body>
</html>
