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


            <!-- GRID START -->

            <div class=" mx-auto">

                <!-- 2. LEFT COLUMN: MY STORIES -->
                <div class="space-y-6">
                    <!-- NOTIFICATIONS SECTION -->
                    <!-- 1. NOTIFICATIONS SECTION (Mini View) -->
                    <div class="mb-8">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                                    </path>
                                </svg>
                                Latest Notifications

                                <!-- Unread Counter Badge -->
                                <!-- We use an ID to target this with JS -->
                                <span id="notif-count-badge"
                                    class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full {{ Auth::user()->unreadNotifications()->count() > 0 ? '' : 'hidden' }}">
                                    {{ Auth::user()->unreadNotifications()->count() }} New
                                </span>
                            </h2>

                            <!-- Link to Full Page -->
                            <a href="{{ route('notifications.index') }}"
                                class="text-sm font-semibold text-brand-green hover:underline">
                                View All History &rarr;
                            </a>
                        </div>

                        <div class="bg-white rounded-lg shadow-sm border border-gray-100 divide-y">
                            <!-- Fetch only the latest 3 notifications -->
                            @forelse(Auth::user()->notifications()->take(3)->get() as $notification)
                                <div
                                    class="p-4 flex justify-between items-center {{ $notification->read_at ? 'bg-gray-50 opacity-75' : 'bg-white border-l-4 border-brand-green' }}">

                                    <div class="flex items-center gap-3">
                                        <!-- Icon based on Status -->
                                        @if (isset($notification->data['status']) && $notification->data['status'] === 'published')
                                            <span class="text-green-500 bg-green-100 p-2 rounded-full flex-shrink-0">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                            </span>
                                        @else
                                            <span class="text-red-500 bg-red-100 p-2 rounded-full flex-shrink-0">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </span>
                                        @endif

                                        <div>
                                            <p class="text-sm text-gray-800 font-medium line-clamp-1">
                                                {{ $notification->data['message'] ?? 'Notification' }}
                                            </p>
                                            <span class="text-xs text-gray-500">
                                                {{ $notification->created_at->diffForHumans() }}
                                            </span>
                                        </div>
                                    </div>

                                    @if (!$notification->read_at)
                                        <a href="{{ route('notifications.read', $notification->id) }}"
                                            class="text-xs text-blue-600 hover:underline whitespace-nowrap ml-2">
                                            Mark read
                                        </a>
                                    @endif
                                </div>
                            @empty
                                <div class="p-6 text-center text-gray-400 text-sm">
                                    You have no notifications yet.
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                            Your Stories
                        </h2>
                        <!-- TABS -->

                        <div class="flex bg-gray-200 p-1 rounded-lg">

                            <!-- 1. Published Tab (Default) -->
                            <a href="{{ route('dashboard', ['view' => 'published']) }}"
                                class="px-4 py-1.5 rounded-md text-sm font-bold transition {{ !request('view') || request('view') == 'published' ? 'bg-white shadow text-gray-900' : 'text-gray-500 hover:text-gray-900' }}">
                                Published
                            </a>

                            <!-- 2. Pending Tab (New) -->
                            <a href="{{ route('dashboard', ['view' => 'pending']) }}"
                                class="px-4 py-1.5 rounded-md text-sm font-bold transition {{ request('view') == 'pending' ? 'bg-white shadow text-gray-900' : 'text-gray-500 hover:text-gray-900' }}">
                                Pending
                            </a>

                            <!-- 3. Drafts Tab -->
                            <a href="{{ route('dashboard', ['view' => 'drafts']) }}"
                                class="px-4 py-1.5 rounded-md text-sm font-bold transition {{ request('view') == 'drafts' ? 'bg-white shadow text-gray-900' : 'text-gray-500 hover:text-gray-900' }}">
                                Drafts
                            </a>
                        </div>
                    </div>

                    <!-- LOGIC TO FETCH DATA -->
                    @php
                        $view = request('view', 'published'); // Default to 'published' if no param exists
                        $query = Auth::user()
                            ->posts()
                            ->withCount(['likes', 'comments', 'bookmarks']);

                        // LOGIC SWITCH
                        if ($view === 'pending') {
                            // Show articles waiting for Admin
                            $query->where('status', 'pending');
                        } elseif ($view === 'drafts') {
                            // Show Drafts AND Rejected items (since rejected usually need editing)
                            $query->whereIn('status', ['draft', 'rejected']);
                        } else {
                            // Default: Show Published
                            $query->where('status', 'published');
                        }

                        $stories = $query->latest()->paginate(5);
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
                                            <!-- Only link to the article if it is PUBLISHED -->
                                            @if ($post->status === 'published')
                                                <a href="{{ route('posts.show', ['username' => Str::slug($post->author->name), 'slug' => $post->slug]) }}"
                                                    class="hover:underline">{{ $post->title }}</a>
                                            @else
                                                <span class="text-gray-800">{{ $post->title }}</span>
                                            @endif
                                        </h3>

                                        <!-- Actions -->
                                        <div class="flex items-center gap-2">
                                            <!-- Dynamic Status Badge -->
                                            @php
                                                $statusColors = [
                                                    'published' => 'bg-green-100 text-green-800',
                                                    'pending' => 'bg-yellow-100 text-yellow-800', // Waiting for Admin
                                                    'draft' => 'bg-gray-100 text-gray-600',
                                                    'rejected' => 'bg-red-100 text-red-800',
                                                ];
                                                $colorClass =
                                                    $statusColors[$post->status] ?? 'bg-gray-100 text-gray-600';
                                            @endphp

                                            <span
                                                class="px-2 py-1 text-xs font-semibold rounded-full uppercase {{ $colorClass }}">
                                                {{ $post->status }}
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
                                            @if ($post->status !== 'published' && $post->status != 'pending')
                                                <a href="{{ route('posts.edit', $post->id) }}"
                                                    class="text-gray-400 hover:text-brand-green transition p-1"
                                                    title="Edit Story">
                                                    <!-- Pencil Icon -->
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                        </path>
                                                    </svg>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                    <p class="text-sm text-gray-500 mt-1 line-clamp-2">{{ $post->excerpt }}</p>
                                </div>

                                <!-- Analytics Bar -->
                                <div
                                    class="flex items-center gap-4 mt-3 pt-3 border-t border-gray-50 text-xs text-gray-400">
                                    <span class="flex items-center gap-1" title="Likes">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                            </path>
                                        </svg>
                                        {{ $post->likes_count ?? 0 }}
                                    </span>
                                    <span class="flex items-center gap-1" title="Comments">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24">
                                            <path fill-rule="evenodd"
                                                d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        {{ $post->comments_count ?? 0 }}
                                    </span>
                                    <span class="ml-auto">{{ $post->created_at->format('M d, Y') }}</span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="bg-white p-12 rounded-lg shadow-sm border border-gray-100 text-center">
                            <!-- Empty State UI -->
                            <p class="text-gray-500 mb-4">No stories found in this section.</p>
                            <a href="{{ route('posts.create') }}"
                                class="text-brand-green font-semibold hover:underline">Start writing</a>
                        </div>
                    @endforelse

                    <!-- NEW: Pagination Links -->
                    <div class="mt-6">
                        {{ $stories->appends(['view' => $view])->links() }}
                    </div>
                </div> <!-- End of Left Column -->

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
    function updateNotificationCount() {
        fetch("{{ route('notifications.count') }}")
            .then(response => response.json())
            .then(data => {
                const badge = document.getElementById('notif-count-badge');
                console.log("Data =====", data)
                if (data.count > 0) {
                    // Update number and show badge
                    badge.innerText = data.count + ' New';
                    badge.classList.remove('hidden');
                } else {
                    // Hide badge if count is 0
                    badge.classList.add('hidden');
                }
            })
            .catch(error => console.error('Error fetching notifications:', error));
    }

    // "pageshow" fires when the page is loaded, even from the Back/Forward cache
    window.addEventListener('pageshow', (event) => {
        console.log("Event Fired")
        updateNotificationCount();
    });
</script>
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
