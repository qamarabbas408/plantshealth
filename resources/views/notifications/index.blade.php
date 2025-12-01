<x-public-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header Area -->
            <div class="flex justify-between items-end mb-6">
                <div>
                    <h1 class="text-3xl font-serif font-bold text-gray-900">Notifications</h1>
                    <p class="text-gray-600 mt-1">Stay updated with your article status.</p>
                </div>

                <!-- Mark All Read Button -->
                @if (Auth::user()->unreadNotifications()->count() > 0)
                    <form action="{{ route('notifications.readAll') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="text-sm font-semibold text-gray-600 hover:text-brand-green bg-white border px-4 py-2 rounded-lg shadow-sm hover:shadow transition">
                            ✓ Mark all as read
                        </button>
                    </form>
                @endif
            </div>

            <!-- Full List -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden divide-y">
                @forelse($notifications as $notification)
                    <div id="notif-row-{{ $notification->id }}"
                        class="p-6 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 hover:bg-gray-50 transition {{ $notification->read_at ? 'opacity-60 bg-gray-50' : 'bg-white border-l-4 border-brand-green' }}">

                        <div class="flex items-start gap-4">
                            <!-- Icon -->
                            @if (isset($notification->data['status']) && $notification->data['status'] === 'published')
                                <span class="text-green-500 bg-green-100 p-3 rounded-full mt-1">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </span>
                            @else
                                <span class="text-red-500 bg-red-100 p-3 rounded-full mt-1">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </span>
                            @endif

                            <div>
                                <p class="text-gray-900 font-medium">
                                    {{ $notification->data['message'] ?? 'System Notification' }}
                                </p>
                                <div class="text-sm text-gray-500 mt-1 flex items-center gap-2">
                                    <span>{{ $notification->created_at->format('M d, Y • h:i A') }}</span>
                                    <span>&middot;</span>
                                    <span>{{ $notification->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Action -->
                        <div class="flex items-center gap-4">
                            @php
                                // 1. Try to find the post safely
                                $post = \App\Models\Post::find($notification->data['post_id'] ?? null);
                            @endphp

                            <!-- 2. Only show button if Post exists AND is published -->
                            @if ($post && isset($notification->data['status']) && $notification->data['status'] === 'published')
                                <a href="{{ route('posts.show', ['username' => Str::slug($post->author->name ?? 'author'), 'slug' => $post->slug]) }}"
                                    class="text-sm font-bold text-brand-green border border-brand-green px-3 py-1 rounded hover:bg-brand-green hover:text-white transition">
                                    View Article
                                </a>
                            @elseif(isset($notification->data['status']) && $notification->data['status'] === 'published')
                                <!-- Optional: Show text if post was deleted -->
                                <span class="text-xs text-gray-400 italic">Article unavailable</span>
                            @endif

                            @if (!$notification->read_at)
                                <!-- Change <a> to <button> and add onclick -->
                                <button
                                    onclick="markNotificationRead('{{ $notification->id }}', '{{ route('notifications.read', $notification->id) }}', this)"
                                    class="text-gray-400 hover:text-blue-600 transition" title="Mark as read">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </button>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="p-12 text-center">
                        <div class="text-gray-300 mb-4">
                            <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900">No notifications</h3>
                        <p class="text-gray-500">We'll let you know when your articles are reviewed.</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $notifications->links() }}
            </div>
        </div>
    </div>
</x-public-layout>
<script>
    function markNotificationRead(id, url, button) {
        // 1. Send Request to Server
        fetch(url, {
                method: 'GET', // Or POST depending on your route definition
                headers: {
                    'X-Requested-With': 'XMLHttpRequest', // Tells Laravel this is AJAX
                    'Content-Type': 'application/json',
                }
            })
            .then(response => {
                if (response.ok) {
                    // 2. UI Updates on Success

                    // A. Find the row container using the ID you already set
                    const row = document.getElementById('notif-row-' + id);

                    // B. Apply "Read" styling (Opacity 60%, Gray BG)
                    row.classList.remove('bg-white', 'border-l-4', 'border-brand-green');
                    row.classList.add('opacity-60', 'bg-gray-50');

                    // C. Remove the Checkmark button nicely
                    button.remove();

                    // Optional: You could allow the user to stay on the page 
                    // without the history stack getting messy!
                }
            })
            .catch(error => console.error('Error:', error));
    }
</script>
