<x-public-layout>
    <!-- Admin Control Bar (Sticky Top) -->
    <div class="bg-gray-900 text-white sticky top-0 z-40 shadow-lg border-b border-gray-800">
        <div class="max-w-7xl mx-auto px-4 py-4 flex flex-col sm:flex-row justify-between items-center gap-4">
            <div>
                <span class="bg-yellow-500 text-black text-xs font-bold px-2 py-1 rounded uppercase tracking-wide">Review Mode</span>
                <span class="ml-2 text-gray-300 text-sm">Reviewing submission by <strong>{{ $post->author->name }}</strong></span>
            </div>
            
            <div class="flex gap-3">
                <!-- Reject Button -->
                <form action="{{ route('admin.posts.reject', $post->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to reject this?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-bold rounded transition">
                        Reject
                    </button>
                </form>

                <!-- Approve Button -->
                <form action="{{ route('admin.posts.approve', $post->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="px-6 py-2 bg-green-600 hover:bg-green-500 text-white text-sm font-bold rounded shadow transition flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Approve & Publish
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Article Content (Reused styles) -->
    <div class="max-w-3xl mx-auto px-4 py-12">
        <!-- Title -->
        <h1 class="text-4xl md:text-5xl font-serif font-bold text-gray-900 mb-6 leading-tight">
            {{ $post->title }}
        </h1>

        <!-- Image -->
        @if($post->image_path)
            <img src="{{ Str::startsWith($post->image_path, 'http') ? $post->image_path : asset('storage/'.$post->image_path) }}" 
                 class="w-full object-cover rounded-lg shadow-sm mb-10">
        @endif

        <!-- Body -->
        <div class="prose font-serif max-w-none text-xl leading-relaxed text-gray-800">
            {!! $post->body !!}
        </div>
    </div>
</x-public-layout>