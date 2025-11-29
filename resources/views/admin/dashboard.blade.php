<x-public-layout>
    <div class="bg-gray-100 min-h-screen py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- HEADER -->
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-3xl font-serif font-bold text-gray-900">Editor's Control Panel</h1>
                    <p class="text-gray-600 text-sm mt-1">Overview of journal performance and moderation queue.</p>
                </div>
                <div class="bg-white px-4 py-2 rounded-lg shadow-sm text-sm text-gray-500 border border-gray-200">
                    Date: <span class="font-bold text-gray-800">{{ now()->format('M d, Y') }}</span>
                </div>
            </div>

            <!-- 1. STATS CARDS -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
                
                <!-- Card 1: Total Users -->
                <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-brand-green flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Scholars</p>
                        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $totalUsers ?? 0 }}</p>
                    </div>
                    <div class="p-3 bg-green-50 rounded-full text-brand-green">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                </div>

                <!-- Card 2: Published Articles -->
                <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-brand-gold flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Published</p>
                        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $publishedPosts ?? 0 }}</p>
                    </div>
                    <div class="p-3 bg-yellow-50 rounded-full text-brand-gold">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                    </div>
                </div>

                <!-- Card 3: Pending Review (Critical) -->
                <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-red-500 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Pending Review</p>
                        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $draftPosts ?? 0 }}</p>
                    </div>
                    <div class="p-3 bg-red-50 rounded-full text-red-500 animate-pulse">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>

                <!-- Card 4: Total Submissions -->
                <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-blue-500 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Stories</p>
                        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $totalPosts ?? 0 }}</p>
                    </div>
                    <div class="p-3 bg-blue-50 rounded-full text-blue-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                </div>
            </div>

            <!-- SUCCESS MESSAGE -->
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-r shadow-sm" role="alert">
                    <p class="font-bold">Success</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <!-- 2. DATA TABLES LAYOUT -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- LEFT: Submission Queue -->
                <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                        <h3 class="font-bold text-gray-800 flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-red-500"></span>
                            Submission Queue
                        </h3>
                        <span class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Action Required</span>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b">
                                <tr>
                                    <th class="px-6 py-3 font-medium">Article Details</th>
                                    <th class="px-6 py-3 font-medium">Author</th>
                                    <th class="px-6 py-3 font-medium">Submitted</th>
                                    <th class="px-6 py-3 font-medium text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($pendingReviews as $post)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4">
                                        <p class="font-bold text-gray-900 line-clamp-1">{{ Str::limit($post->title, 40) }}</p>
                                        <span class="text-xs text-gray-500">{{ $post->tags->first()->name ?? 'General' }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="h-6 w-6 rounded-full bg-gray-200 flex items-center justify-center text-xs font-bold text-gray-600 mr-2">
                                                {{ substr($post->author->name, 0, 1) }}
                                            </div>
                                            {{ $post->author->name }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-gray-500 whitespace-nowrap">
                                        {{ $post->created_at->diffForHumans() }}
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <!-- Review Button -->
                                        <a href="{{ route('admin.posts.review', $post->id) }}" 
                                           class="inline-flex items-center px-3 py-1.5 bg-brand-green text-white text-xs font-bold rounded hover:bg-green-700 transition shadow-sm">
                                            Review
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center">
                                        <div class="text-gray-400 mb-2">
                                            <svg class="w-10 h-10 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        </div>
                                        <p class="text-gray-500 font-medium">All caught up! No pending submissions.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- RIGHT: New Users -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden h-fit">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                        <h3 class="font-bold text-gray-800">New Scholars</h3>
                    </div>
                    <ul class="divide-y divide-gray-100">
                        @foreach($recentUsers as $user)
                        <li class="flex items-center px-6 py-4 hover:bg-gray-50 transition">
                            <div class="flex-shrink-0 relative">
                                @if($user->avatar)
                                    <img class="h-10 w-10 rounded-full object-cover border border-gray-200" src="{{ asset('storage/'.$user->avatar) }}" alt="">
                                @else
                                    <div class="h-10 w-10 rounded-full bg-brand-gold flex items-center justify-center text-white font-bold border border-yellow-200">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                @endif
                                <!-- Online indicator (fake for now) -->
                                <span class="absolute bottom-0 right-0 block h-2.5 w-2.5 rounded-full ring-2 ring-white bg-green-400"></span>
                            </div>
                            <div class="ml-4 flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ $user->name }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ $user->email }}</p>
                            </div>
                            <div class="text-xs text-gray-400 whitespace-nowrap">
                                {{ $user->created_at->format('M d') }}
                            </div>
                        </li>
                        @endforeach
                    </ul>
                    <div class="px-6 py-3 bg-gray-50 border-t border-gray-100 text-center">
                        <a href="#" class="text-xs font-bold text-gray-500 hover:text-brand-green uppercase tracking-wide">View All Users</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-public-layout>