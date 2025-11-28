<x-public-layout>

    <!-- Hero Section -->
    <div class="relative bg-brand-green overflow-hidden">

        <!-- Background Image replaced here -->
        <div class="absolute inset-0 opacity-20"
            style="background-image: url('{{ asset('images/green-tea-hero-image.jpg') }}'); background-size: cover; background-position: center;">
        </div>

        <div
            class="relative max-w-7xl mx-auto py-24 px-4 sm:py-32 sm:px-6 lg:px-8 flex flex-col items-center text-center">
            <h1 class="text-4xl font-serif font-bold tracking-tight text-white sm:text-5xl md:text-6xl">
                {!! __('Modern Agriculture is <span class="text-amber-400 italic">Gold</span>') !!}
            </h1>
            <p class="mt-6 max-w-2xl text-xl text-green-100">
                {{ __('Mission Statement') }}
            </p>
            <div class="mt-10 flex gap-4">
                <a href="{{ route('posts.index') }}"
                    class="bg-amber-500 hover:bg-amber-600 text-white font-bold py-3 px-8 rounded shadow-lg transition">
                    {{ __('Read Latest Issue') }}
                </a>
                <a href="{{ route('pages.about') }}"
                    class="bg-transparent border border-white text-white hover:bg-white hover:text-brand-green font-bold py-3 px-8 rounded transition">
                    {{ __('Mission Statement') }}
                </a>
            </div>
        </div>
    </div>

    <!-- Featured Article (Grid) -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="flex justify-between items-end mb-8">
            <div>
                <h2 class="text-3xl font-serif font-bold text-gray-900">{{ __('Latest Insights') }}</h2>
                <p class="mt-2 text-gray-600">Curated articles from our editors and scholars.</p>
            </div>
            <!-- Link to an archive page (we can build later) -->
            <a href="{{ route('posts.index') }}" class="text-brand-green font-semibold hover:text-green-800"
                class="text-brand-green font-semibold hover:text-green-800">{{ __('View all posts') }} &rarr;</a>
        </div>

        <div class="grid gap-10 md:grid-cols-3">
            @if (isset($posts) && $posts->count() > 0)
                @foreach ($posts as $post)
                    <!-- LOGIC: Determine Image URL -->
                    @php
                        if (!$post->image_path) {
                            $imgSrc = asset('images/placeholder-agri.jpg');
                        } elseif (Str::startsWith($post->image_path, 'http')) {
                            // It's an external URL (like from Seeding/Unsplash)
    $imgSrc = $post->image_path;
} else {
    // It's a local file uploaded via our Editor
                            $imgSrc = asset('storage/' . $post->image_path);
                        }
                    @endphp

                    <!-- Dynamic Card -->
                    <div
                        class="flex flex-col overflow-hidden rounded-lg shadow-lg bg-white hover:shadow-xl transition duration-300">
                        <div class="flex-shrink-0 h-48 w-full bg-gray-100">
                            <img class="h-full w-full object-cover" src="{{ $imgSrc }}"
                                alt="{{ $post->title }}">
                        </div>

                        <div class="flex-1 p-6 flex flex-col justify-between">
                            <div class="flex-1">
                                <!-- Dynamic Tag (Show first tag or fallback to 'News') -->
                                <p class="text-sm font-medium text-brand-gold uppercase tracking-wider">
                                    {{ $post->tags->first()->name ?? __('News') }}
                                </p>

                                <!-- Link to Read Story (We will create this route next) -->
                                <a href="{{ route('posts.show', ['username' => Str::slug($post->author->name), 'slug' => $post->slug]) }}"
                                    class="block mt-2">
                                    <p class="text-xl font-serif font-semibold text-gray-900 line-clamp-2">
                                        {{ $post->title }}
                                    </p>
                                    <p class="mt-3 text-base text-gray-500 line-clamp-3">
                                        {{ $post->excerpt ?? Str::limit(strip_tags($post->body), 100) }}
                                    </p>
                                </a>
                            </div>

                            <div class="mt-6 flex items-center">
                                <div class="flex-shrink-0">
                                    <!-- Author Avatar (Initials) -->
                                    <span
                                        class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 font-bold uppercase">
                                        {{ substr($post->author->name, 0, 1) }}
                                    </span>
                                </div>
                                <div class="ms-3">
                                    <p class="text-sm font-medium text-gray-900">
                                        {{ $post->author->name }}
                                    </p>
                                    <div class="flex space-x-1 text-sm text-gray-500">
                                        <time datetime="{{ $post->created_at }}">
                                            {{ $post->created_at->format('M d, Y') }}
                                        </time>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-span-3 text-center py-10">
                    <p class="text-gray-500">No articles published yet.</p>
                </div>
            @endif
        </div>
    </div>

</x-public-layout>
