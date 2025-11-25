<x-public-layout>
    
    <!-- Hero Section -->
    <div class="relative bg-brand-green overflow-hidden">
        <div class="absolute inset-0 opacity-20" style="background-image: url('https://images.unsplash.com/photo-1625246333195-5512a96d8a48?q=80&w=2070&auto=format&fit=crop'); background-size: cover; background-position: center;"></div>
        <div class="relative max-w-7xl mx-auto py-24 px-4 sm:py-32 sm:px-6 lg:px-8 flex flex-col items-center text-center">
            <h1 class="text-4xl font-serif font-bold tracking-tight text-white sm:text-5xl md:text-6xl">
                {!! __('Modern Agriculture is <span class="text-amber-400 italic">Gold</span>') !!}
            </h1>
            <p class="mt-6 max-w-2xl text-xl text-green-100">
                {{ __('Mission Statement') }}
            </p>
            <div class="mt-10 flex gap-4">
                <a href="#" class="bg-amber-500 hover:bg-amber-600 text-white font-bold py-3 px-8 rounded shadow-lg transition">{{ __('Read Latest Issue') }}</a>
                <a href="#" class="bg-transparent border border-white text-white hover:bg-white hover:text-brand-green font-bold py-3 px-8 rounded transition">Mission Statement</a>
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
            <a href="#" class="text-brand-green font-semibold hover:text-green-800">{{ __('View all posts') }} &rarr;</a>
        </div>

        <div class="grid gap-10 md:grid-cols-3">
            @if(isset($posts))
                @foreach($posts as $post)
                <!-- Dynamic Card -->
                <div class="flex flex-col overflow-hidden rounded-lg shadow-lg bg-white hover:shadow-xl transition duration-300">
                    <div class="flex-shrink-0">
                        <img class="h-48 w-full object-cover" src="{{ $post->image_path ?? 'https://via.placeholder.com/400x300' }}" alt="">
                    </div>
                    <div class="flex-1 p-6 flex flex-col justify-between">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-brand-gold">
                                {{ __('News') }}
                            </p>
                            <a href="#" class="block mt-2">
                                <p class="text-xl font-serif font-semibold text-gray-900">
                                    {{ $post->title }}
                                </p>
                                <p class="mt-3 text-base text-gray-500">
                                    {{ Str::limit($post->excerpt, 100) }}
                                </p>
                            </a>
                        </div>
                        <div class="mt-6 flex items-center">
                            <div class="flex-shrink-0">
                                <span class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 font-bold uppercase">
                                    {{ substr($post->author->name, 0, 2) }}
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
            @endif
        </div>
    </div>

</x-public-layout>