<x-public-layout>
    <div class="bg-gray-50 min-h-screen py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Page Header -->
            <div class="text-center mb-12">
                <h1 class="text-4xl font-serif font-bold text-gray-900">All Articles</h1>
                <p class="mt-4 text-gray-600 max-w-2xl mx-auto">
                    Explore the latest research, innovations, and stories from the world of modern agriculture.
                </p>
            </div>

            <!-- Tag Filter List -->
            <div class="mb-10 px-4">
                <div class="flex flex-wrap justify-center items-center gap-3">

                    <!-- 1. 'All' Button -->
                    <a href="{{ route('posts.index') }}"
                        class="px-5 py-2 rounded-full text-sm font-bold border transition duration-200 
           {{ !request('tag')
               ? 'bg-brand-gold border-brand-gold text-white shadow-md'
               : 'bg-white border-gray-200 text-gray-600 hover:border-brand-green hover:text-brand-green' }}">
                        All
                    </a>

                    <!-- 2. Top 10 Popular Tags -->
                    @foreach ($tags->take(10) as $tag)
                        <a href="{{ route('posts.index', ['tag' => $tag->name]) }}"
                            class="px-5 py-2 rounded-full text-sm font-bold border transition duration-200 whitespace-nowrap
               {{ request('tag') == $tag->name
                   ? 'bg-brand-gold border-brand-gold text-white shadow-md'
                   : 'bg-white border-gray-200 text-gray-600 hover:border-brand-green hover:text-brand-green' }}">
                            {{ $tag->name }}
                        </a>
                    @endforeach

                    <!-- 3. 'More' Dropdown (Only shows if there are more than 10 tags) -->
                    @if ($tags->count() > 10)
                        <div class="relative group">
                            <button
                                class="px-5 py-2 rounded-full text-sm font-bold border bg-white border-gray-200 text-gray-600 hover:border-brand-green hover:text-brand-green flex items-center gap-1">
                                More Topics
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            <!-- Dropdown Menu -->
                            <div
                                class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-xl z-20 hidden group-hover:block border border-gray-100 max-h-64 overflow-y-auto">
                                @foreach ($tags->skip(10) as $tag)
                                    <a href="{{ route('posts.index', ['tag' => $tag->name]) }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-50 hover:text-brand-green 
                           {{ request('tag') == $tag->name ? 'bg-green-50 text-brand-green font-bold' : '' }}">
                                        {{ $tag->name }} <span
                                            class="text-xs text-gray-400 ml-1">({{ $tag->posts_count }})</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                </div>
            </div>
            <!-- The Grid -->
            <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3 mb-12">
                @foreach ($posts as $post)
                    <!-- Image Logic -->
                    @php
                        $imgSrc = asset('images/placeholder-agri.jpg');
                        if ($post->image_path) {
                            if (str_starts_with($post->image_path, 'http')) {
                                $imgSrc = $post->image_path;
                            } else {
                                $imgSrc = asset('storage/' . $post->image_path);
                            }
                        }
                    @endphp

                    <!-- Card -->
                    <div
                        class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition flex flex-col h-full">

                        <!-- Image -->
                        <div class="h-48 overflow-hidden">
                            <a
                                href="{{ route('posts.show', ['username' => Str::slug($post->author->name), 'slug' => $post->slug]) }}">
                                <img src="{{ $imgSrc }}" alt="{{ $post->title }}"
                                    class="w-full h-full object-cover transform hover:scale-105 transition duration-500">
                            </a>
                        </div>

                        <!-- Content -->
                        <div class="p-6 flex-1 flex flex-col">

                            <!-- Tags & Date -->
                            <div class="flex items-center justify-between text-xs text-gray-500 mb-3">
                                <span class="uppercase tracking-wider font-semibold text-brand-gold">
                                    {{ $post->tags->first()->name ?? 'Article' }}
                                </span>
                                <span>{{ $post->created_at->format('M d, Y') }}</span>
                            </div>

                            <!-- Title -->
                            <a href="{{ route('posts.show', ['username' => Str::slug($post->author->name), 'slug' => $post->slug]) }}"
                                class="block mb-3">
                                <h3
                                    class="text-xl font-bold text-gray-900 font-serif leading-tight hover:text-brand-green transition">
                                    {{ $post->title }}
                                </h3>
                            </a>

                            <!-- Excerpt (Description) -->
                            <p class="text-gray-600 text-sm mb-4 line-clamp-3 flex-1">
                                {{ $post->excerpt ?? Str::limit(strip_tags($post->body), 120) }}
                            </p>

                            <!-- CTA: Read More -->
                            <div class="mt-auto pt-4 border-t border-gray-100">
                                <a href="{{ route('posts.show', ['username' => Str::slug($post->author->name), 'slug' => $post->slug]) }}"
                                    class="inline-flex items-center text-brand-green font-semibold text-sm hover:underline">
                                    Read More
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination Links -->
            <div class="mt-8 ">
                {{ $posts->links() }}
            </div>

        </div>
    </div>
</x-public-layout>
