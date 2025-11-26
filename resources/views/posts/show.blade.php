<x-public-layout>
    <!-- Add Merriweather Font for Reading -->
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;1,300&display=swap" rel="stylesheet">
    <style>
        .custom-font-serif { font-family: 'Merriweather', serif; }
        /* Typography for the content body */
        .prose p { margin-bottom: 1.5em; line-height: 2; font-size: 1.25rem; color: #292929; }
        .prose h1 { font-size: 2rem; font-weight: bold; margin-top: 2em; margin-bottom: 0.5em; }
        .prose h2 { font-size: 1.75rem; font-weight: bold; margin-top: 1.5em; margin-bottom: 0.5em; }
        .prose blockquote { border-left: 4px solid #064e3b; padding-left: 1rem; font-style: italic; color: #555; }
        .prose img { margin: 2rem auto; border-radius: 4px; max-width: 100%; }
        .prose pre { background: #f3f4f6; padding: 1rem; border-radius: 0.5rem; overflow-x: auto; font-size: 0.9rem; }
    </style>

    <article class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        
        <!-- 1. Header Info -->
        <div class="mb-8">
            <h1 class="text-4xl md:text-5xl custom-font-serif font-bold text-gray-900 mb-6 leading-tight">
                {{ $post->title }}
            </h1>

            <div class="flex items-center justify-between border-b pb-8">
                <div class="flex items-center">
                    <div class="h-12 w-12 rounded-full bg-brand-green flex items-center justify-center text-white font-bold text-lg uppercase">
                        {{ substr($post->author->name, 0, 1) }}
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-bold text-gray-900">{{ $post->author->name }}</p>
                        <div class="flex items-center text-sm text-gray-500 gap-2">
                            <span>{{ $post->created_at->format('M d, Y') }}</span>
                            <span>&middot;</span>
                            <span>{{ ceil(str_word_count(strip_tags($post->body)) / 200) }} min read</span>
                        </div>
                    </div>
                </div>
                
                <!-- Social Share (Static for now) -->
                <div class="flex gap-4 text-gray-400">
                    <button class="hover:text-gray-600"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg></button>
                    <button class="hover:text-gray-600"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg></button>
                </div>
            </div>
        </div>

        <!-- 2. Featured Image (If exists) -->
        @if($post->image_path)
            <div class="mb-10">
                <img src="{{ Str::startsWith($post->image_path, 'http') ? $post->image_path : asset('storage/'.$post->image_path) }}" 
                     class="w-full object-cover rounded-lg shadow-sm"
                     alt="{{ $post->title }}">
            </div>
        @endif

        <!-- 3. The Article Content -->
        <div class="prose custom-font-serif max-w-none">
            {!! $post->body !!}
        </div>

        <!-- 4. Tags Footer -->
        <div class="mt-12 pt-8 border-t">
            <div class="flex flex-wrap gap-2">
                @foreach($post->tags as $tag)
                    <span class="bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-sm hover:bg-gray-200 transition cursor-pointer">
                        {{ $tag->name }}
                    </span>
                @endforeach
            </div>
        </div>

    </article>
</x-public-layout>