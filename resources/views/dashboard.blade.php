<x-public-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- 1. HEADER & ACTIONS -->
            <div class="flex flex-col md:flex-row justify-between items-center mb-10 gap-4">
                <div>
                    <h1 class="text-3xl font-serif font-bold text-gray-900">Your Dashboard</h1>
                    <p class="text-gray-600">Manage your stories and personal details.</p>
                </div>
                <a href="{{ route('posts.create') }}"
                    class="flex items-center gap-2 bg-brand-green text-white px-6 py-3 rounded-full hover:bg-green-800 transition shadow-lg">
                    <!-- Pen Icon -->
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <path d="M12 20h9"></path>
                        <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                    </svg>
                    <span class="font-bold">Write a Story</span>
                </a>
            </div>

            <!-- Success Message -->
            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- 2. LEFT COLUMN: MY STORIES -->
                <div class="lg:col-span-2 space-y-6">

                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                            <svg class="w-5 h-5 text-brand-gold" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z">
                                </path>
                            </svg>
                            Your Stories
                        </h2>

                        <!-- TABS -->
                        <div class="flex bg-gray-200 p-1 rounded-lg">
                            <a href="{{ route('dashboard', ['view' => 'published']) }}"
                                class="px-4 py-1.5 rounded-md text-sm font-bold transition {{ request('view') != 'drafts' ? 'bg-white shadow text-gray-900' : 'text-gray-500 hover:text-gray-900' }}">
                                Published
                            </a>
                            <a href="{{ route('dashboard', ['view' => 'drafts']) }}"
                                class="px-4 py-1.5 rounded-md text-sm font-bold transition {{ request('view') == 'drafts' ? 'bg-white shadow text-gray-900' : 'text-gray-500 hover:text-gray-900' }}">
                                Drafts
                            </a>
                        </div>
                    </div>

                    <!-- LOGIC TO FETCH DATA -->
                    @php
                        $view = request('view');
                        $stories = Auth::user()
                            ->posts()
                            ->where('is_published', $view != 'drafts')
                            ->withCount(['likes', 'comments', 'bookmarks']) // Count analytics
                            ->latest()
                            ->paginate(5);
                    @endphp

                    <!-- List of Stories -->
                    @forelse($stories as $post)
                        <div
                            class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 flex gap-4 hover:shadow-md transition">
                            <!-- Thumbnail -->
                            <div class="w-24 h-24 flex-shrink-0 bg-gray-200 rounded-md overflow-hidden relative">
                                @if ($post->image_path)
                                    @php
                                        $imgSrc = Str::startsWith($post->image_path, 'http')
                                            ? $post->image_path
                                            : asset('storage/' . $post->image_path);
                                    @endphp
                                    <img src="{{ $imgSrc }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400 text-xs">No
                                        Image</div>
                                @endif
                            </div>

                            <div class="flex flex-col justify-between flex-1">
                                <div>
                                    <div class="flex justify-between items-start">
                                        <h3 class="font-bold text-lg text-gray-900 leading-tight">
                                            @if ($post->is_published)
                                                <a href="{{ route('posts.show', ['username' => Str::slug($post->author->name), 'slug' => $post->slug]) }}"
                                                    class="hover:underline">{{ $post->title }}</a>
                                            @else
                                                <span class="text-gray-800">{{ $post->title }}</span>
                                            @endif
                                        </h3>

                                        <!-- Actions -->
                                        <div class="flex items-center gap-2">
                                            <!-- Status -->
                                            <span
                                                class="px-2 py-1 text-xs font-semibold rounded-full {{ $post->is_published ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600 border border-gray-200' }}">
                                                {{ $post->is_published ? 'Published' : 'Draft' }}
                                            </span>

                                            <!-- Delete Trigger -->
                                            <button type="button"
                                                onclick="openDeleteModal('{{ route('posts.destroy', $post->id) }}')"
                                                class="text-gray-400 hover:text-red-600 transition p-1"
                                                title="Delete Story">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                    </path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    <p class="text-sm text-gray-500 mt-1 line-clamp-2">{{ $post->excerpt }}</p>
                                </div>

                                <!-- Analytics Bar -->
                                <div
                                    class="flex items-center gap-4 mt-3 pt-3 border-t border-gray-50 text-xs text-gray-400">
                                    <span class="flex items-center gap-1" title="Likes"><svg class="w-3 h-3"
                                            fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                            </path>
                                        </svg> {{ $post->likes_count }}</span>
                                    <span class="flex items-center gap-1" title="Comments"><svg class="w-3 h-3"
                                            fill="currentColor" viewBox="0 0 24 24">
                                            <path fill-rule="evenodd"
                                                d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z"
                                                clip-rule="evenodd"></path>
                                        </svg> {{ $post->comments_count }}</span>
                                    <span class="ml-auto">{{ $post->created_at->format('M d, Y') }}</span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="bg-white p-12 rounded-lg shadow-sm border border-gray-100 text-center">
                            <div class="text-gray-300 mb-4">
                                <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                    </path>
                                </svg>
                            </div>
                            <p class="text-gray-500 mb-4">No
                                {{ request('view') == 'drafts' ? 'drafts' : 'published stories' }} found.</p>
                            <a href="{{ route('posts.create') }}"
                                class="text-brand-green font-semibold hover:underline">Start writing</a>
                        </div>
                    @endforelse

                    <!-- NEW: Pagination Links -->
                    <div class="mt-6">
                        {{ $stories->appends(['view' => $view])->links() }}
                    </div>
                </div> <!-- End of Left Column -->

                <!-- Profile Card in Dashboard -->
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 text-center">
                    <div class="flex justify-center mb-4">
                        @if (Auth::user()->avatar)
                            <img src="{{ asset('storage/' . Auth::user()->avatar) }}"
                                class="w-20 h-20 rounded-full object-cover">
                        @else
                            <div
                                class="w-20 h-20 rounded-full bg-brand-green flex items-center justify-center text-white text-xl font-bold">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                        @endif
                    </div>
                    <h3 class="font-bold text-lg">{{ Auth::user()->name }}</h3>
                    <p class="text-sm text-gray-500 mb-4">{{ Auth::user()->affiliation ?? 'No affiliation set' }}</p>

                    <a href="{{ route('profile.edit') }}"
                        class="block w-full border border-gray-300 text-gray-700 font-semibold py-2 rounded hover:bg-gray-50">
                        Edit Profile
                    </a>
                </div>

            </div>
        </div>
    </div>
    <!-- DELETE CONFIRMATION MODAL -->
    <div id="delete-modal" class="fixed inset-0 z-[60] hidden">

        <!-- Backdrop (Dark Overlay) -->
        <div class="absolute inset-0 bg-gray-900 bg-opacity-50 backdrop-blur-sm transition-opacity"
            onclick="closeDeleteModal()"></div>

        <!-- Modal Content -->
        <div
            class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white rounded-xl shadow-2xl p-8 max-w-sm w-full border border-gray-100 text-center">

            <!-- Warning Icon -->
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>

            <h3 class="text-xl font-bold text-gray-900 mb-2">Delete Story?</h3>

            <p class="text-gray-500 mb-8 text-sm leading-relaxed">
                Are you sure you want to delete this? All comments and data associated with this story will be
                permanently removed.
            </p>

            <div class="flex justify-center gap-3">
                <!-- Cancel Button -->
                <button type="button" onclick="closeDeleteModal()"
                    class="px-5 py-2.5 rounded-full text-gray-700 bg-gray-100 hover:bg-gray-200 font-medium transition text-sm">
                    Cancel
                </button>

                <!-- Delete Form (Action updated via JS) -->
                <form id="delete-form" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="px-5 py-2.5 rounded-full bg-red-600 text-white font-bold hover:bg-red-700 transition text-sm shadow-lg shadow-red-200">
                        Yes, Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-public-layout>
<script>
    function previewAvatar(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                var img = document.getElementById('avatar-preview');
                var placeholder = document.getElementById('avatar-placeholder');

                // Set the image source to the selected file
                img.src = e.target.result;

                // Show the image, hide the placeholder
                img.classList.remove('hidden');
                placeholder.classList.add('hidden');
            }

            // Read the file
            reader.readAsDataURL(input.files[0]);
        }


    }

    const deleteModal = document.getElementById('delete-modal');
    const deleteForm = document.getElementById('delete-form');

    function openDeleteModal(url) {
        // 1. Update the form action with the specific post URL
        deleteForm.action = url;

        // 2. Show the modal
        deleteModal.classList.remove('hidden');
    }

    function closeDeleteModal() {
        deleteModal.classList.add('hidden');
    }

    // Optional: Close on Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === "Escape") {
            closeDeleteModal();
        }
    });
</script>
