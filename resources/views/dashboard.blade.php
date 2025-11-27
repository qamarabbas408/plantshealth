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
                        // If view is 'drafts', show only unpublished. Otherwise show published.
                        $stories = Auth::user()
                            ->posts()
                            ->where('is_published', $view != 'drafts')
                            ->latest()
                            ->paginate(5); // <--- Changed from get() to paginate(5)
                    @endphp

                    <!-- List of Stories -->
                    @forelse($stories as $post)
                        <div
                            class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 flex gap-4 hover:shadow-md transition">
                            <!-- Thumbnail -->
                            <div class="w-24 h-24 flex-shrink-0 bg-gray-200 rounded-md overflow-hidden">
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

                            <div class="flex-1">
                                <div class="flex justify-between items-start">
                                    <h3 class="font-bold text-lg text-gray-900 leading-tight">
                                        @if ($post->is_published)
                                            <!-- Published link (Read) -->
                                            <a href="{{ route('posts.show', ['username' => Str::slug($post->author->name), 'slug' => $post->slug]) }}"
                                                class="hover:underline">
                                                {{ $post->title }}
                                            </a>
                                        @else
                                            <!-- Draft link (Edit) - UPDATE THIS PART -->
                                            <a href="{{ route('posts.edit', $post->id) }}"
                                                class="hover:text-brand-green hover:underline">
                                                {{ $post->title }} <span
                                                    class="text-xs text-gray-400 ml-1">(Edit)</span>
                                            </a>
                                        @endif
                                    </h3>

                                    <!-- Status Badge -->
                                    @if (!$post->is_published)
                                        <span
                                            class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-600 border border-gray-200">
                                            Draft
                                        </span>
                                    @else
                                        <span
                                            class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                            Published
                                        </span>
                                    @endif
                                </div>

                                <p class="text-gray-500 text-sm mt-1 line-clamp-2">
                                    {{ $post->excerpt ?? 'No description.' }}
                                </p>
                                <p class="text-gray-400 text-xs mt-3">
                                    {{ $post->is_published ? 'Published on' : 'Created on' }}
                                    {{ $post->created_at->format('M d, Y') }}
                                </p>
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

                <!-- 3. RIGHT COLUMN: PROFILE SETTINGS -->
                <div class="lg:col-span-1">
                    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 sticky top-24">
                        <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Profile Settings
                        </h2>

                        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <!-- Avatar Preview -->
                            <div class="flex justify-center mb-6">
                                <div class="relative w-24 h-24">

                                    <!-- 1. The Image Tag (Always render it, but hide it if no avatar exists) -->
                                    <img id="avatar-preview"
                                        src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : '' }}"
                                        class="w-24 h-24 rounded-full object-cover border-2 border-gray-100 shadow {{ Auth::user()->avatar ? '' : 'hidden' }}">

                                    <!-- 2. The Initials Placeholder (Hide it if avatar exists) -->
                                    <div id="avatar-placeholder"
                                        class="w-24 h-24 rounded-full bg-brand-green flex items-center justify-center text-white text-2xl font-bold border-2 border-gray-100 shadow {{ Auth::user()->avatar ? 'hidden' : '' }}">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </div>

                                    <!-- Upload Icon Overlay -->
                                    <label for="avatar"
                                        class="absolute bottom-0 right-0 bg-white border border-gray-200 p-1.5 rounded-full cursor-pointer hover:bg-gray-50 shadow-sm">
                                        <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z">
                                            </path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                    </label>

                                    <!-- File Input with Event Listener -->
                                    <input type="file" name="avatar" id="avatar" class="hidden"
                                        onchange="previewAvatar(this)">
                                </div>
                            </div>

                            <!-- Name -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Display Name</label>
                                <input type="text" name="name" value="{{ Auth::user()->name }}"
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-brand-green focus:ring focus:ring-brand-green focus:ring-opacity-50 p-2 border">
                            </div>

                            <!-- Email -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                <input type="email" readonly name="email" value="{{ Auth::user()->email }}"
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-brand-green focus:ring focus:ring-brand-green focus:ring-opacity-50 p-2 border">
                            </div>

                            <!-- Bio -->
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Short Bio</label>
                                <textarea name="bio" rows="3"
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-brand-green focus:ring focus:ring-brand-green focus:ring-opacity-50 p-2 border"
                                    placeholder="Tell us about your research...">{{ Auth::user()->bio }}</textarea>
                            </div>

                            <button type="submit"
                                class="w-full bg-gray-900 text-white font-bold py-2 rounded-md hover:bg-gray-800 transition">
                                Save Changes
                            </button>
                        </form>
                    </div>
                </div>

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
</script>
