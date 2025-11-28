<x-public-layout>
    <div class="py-12 bg-white min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <h1 class="text-4xl font-serif font-bold text-gray-900 mb-8">Your Stats</h1>

            <!-- 1. SUMMARY CARDS -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-12">
                <div class="p-6 bg-gray-50 rounded-lg border border-gray-100">
                    <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Stories</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalStories }}</p>
                </div>
                <div class="p-6 bg-gray-50 rounded-lg border border-gray-100">
                    <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Total Likes</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalLikes }}</p>
                </div>
                <div class="p-6 bg-gray-50 rounded-lg border border-gray-100">
                    <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Comments</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalComments }}</p>
                </div>
                <div class="p-6 bg-gray-50 rounded-lg border border-gray-100">
                    <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Bookmarks</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalBookmarks }}</p>
                </div>
            </div>

            <!-- 2. DETAILED CHART (Table) -->
            <h2 class="text-xl font-bold text-gray-900 mb-6 pb-4 border-b">Story Performance</h2>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-xs font-semibold text-gray-500 border-b border-gray-200">
                            <th class="py-4 pr-4 uppercase tracking-wider">Title</th>
                            <th class="py-4 px-4 text-center uppercase tracking-wider w-24">Likes</th>
                            <th class="py-4 px-4 text-center uppercase tracking-wider w-24">Comments</th>
                            <th class="py-4 px-4 text-center uppercase tracking-wider w-24">Saves</th>
                            <th class="py-4 px-4 text-right uppercase tracking-wider w-32">Date</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        @foreach($posts as $post)
                        <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                            <td class="py-4 pr-4">
                                <a href="{{ route('posts.show', ['username' => Str::slug($post->author->name), 'slug' => $post->slug]) }}" class="font-bold text-gray-900 hover:text-brand-green text-lg font-serif">
                                    {{ $post->title }}
                                </a>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="px-2 py-0.5 rounded text-xs font-medium {{ $post->is_published ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600' }}">
                                        {{ $post->is_published ? 'Published' : 'Draft' }}
                                    </span>
                                    <a href="{{ route('posts.edit', $post->id) }}" class="text-gray-400 hover:text-gray-600 text-xs underline">Edit</a>
                                </div>
                            </td>
                            <td class="py-4 px-4 text-center text-gray-600">{{ $post->likes_count }}</td>
                            <td class="py-4 px-4 text-center text-gray-600">{{ $post->comments_count }}</td>
                            <td class="py-4 px-4 text-center text-gray-600">{{ $post->bookmarks_count }}</td>
                            <td class="py-4 px-4 text-right text-gray-500 whitespace-nowrap">
                                {{ $post->created_at->format('M d, Y') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
                @if($posts->isEmpty())
                    <div class="py-12 text-center text-gray-500">
                        You haven't written any stories yet.
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-public-layout>