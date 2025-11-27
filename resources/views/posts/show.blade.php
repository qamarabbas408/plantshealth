<x-public-layout>
    <!-- Add Merriweather Font for Reading -->
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;1,300&display=swap"
        rel="stylesheet">
    <style>
        .custom-font-serif {
            font-family: 'Merriweather', serif;
        }

        /* Typography for the content body */
        .prose p {
            margin-bottom: 1.5em;
            line-height: 2;
            font-size: 1.25rem;
            color: #292929;
        }

        .prose h1 {
            font-size: 2rem;
            font-weight: bold;
            margin-top: 2em;
            margin-bottom: 0.5em;
        }

        .prose h2 {
            font-size: 1.75rem;
            font-weight: bold;
            margin-top: 1.5em;
            margin-bottom: 0.5em;
        }

        .prose blockquote {
            border-left: 4px solid #064e3b;
            padding-left: 1rem;
            font-style: italic;
            color: #555;
        }

        .prose img {
            margin: 2rem auto;
            border-radius: 4px;
            max-width: 100%;
        }

        .prose pre {
            background: #f3f4f6;
            padding: 1rem;
            border-radius: 0.5rem;
            overflow-x: auto;
            font-size: 0.9rem;
        }
    </style>

    <article class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

        <!-- 1. Header Info -->
        <div class="mb-8">
            <h1 class="text-4xl md:text-5xl custom-font-serif font-bold text-gray-900 mb-6 leading-tight">
                {{ $post->title }}
            </h1>

            <div class="flex items-center justify-between border-b pb-8">
                <div class="flex items-center">
                    <div
                        class="h-12 w-12 rounded-full bg-brand-green flex items-center justify-center text-white font-bold text-lg uppercase">
                        {{ substr($post->author->name, 0, 1) }}
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-bold text-gray-900">{{ $post->author->name }}</p>
                        <div class="flex items-center text-sm text-gray-500 gap-2">
                            <span>{{ $post->created_at->format('M d, Y') }}</span>
                            <span>&middot;</span>
                            <span>{{ $post->read_time }} min read</span>

                        </div>
                    </div>
                </div>

                <!-- Social Share (Static for now) -->
                <div class="flex gap-4 text-gray-400">
                    <button class="hover:text-gray-600"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z" />
                        </svg></button>
                    <button class="hover:text-gray-600"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" />
                        </svg></button>
                    <!-- Comment Trigger -->
                    <button onclick="toggleComments()"
                        class="flex items-center gap-1 text-gray-400 hover:text-gray-600 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                            </path>
                        </svg>
                        <span class="text-sm font-medium">{{ $post->comments->count() }}</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- 2. Featured Image (If exists) -->
        @if ($post->image_path)
            <div class="mb-10">
                <img src="{{ Str::startsWith($post->image_path, 'http') ? $post->image_path : asset('storage/' . $post->image_path) }}"
                    class="w-full object-cover rounded-lg shadow-sm" alt="{{ $post->title }}">
            </div>
        @endif

        <!-- 3. The Article Content -->
        <div class="prose custom-font-serif max-w-none">
            {!! $post->body !!}
        </div>

        <!-- 4. Tags Footer -->
        <div class="mt-12 pt-8 border-t border-gray-100">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Topics</p>

            <div class="flex flex-wrap gap-2">
                @foreach ($post->tags as $tag)
                    <a href="{{ route('posts.index', ['tag' => $tag->name]) }}"
                        class="bg-gray-50 text-gray-600 px-4 py-2 rounded-full text-sm font-medium border border-gray-200 hover:bg-brand-green hover:text-white hover:border-brand-green transition duration-200">
                        {{ $tag->name }}
                    </a>
                @endforeach
            </div>
        </div>

    </article>
    <!-- CONFIRMATION MODAL -->
    <div id="close-discussion-modal" class="fixed inset-0 z-[60] hidden">
        <!-- Overlay -->
        <div class="absolute inset-0 bg-white bg-opacity-90 backdrop-blur-sm"></div>

        <!-- Modal Content -->
        <div
            class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white rounded-lg shadow-2xl p-8 max-w-sm w-full border border-gray-100 text-center">
            <h3 class="text-2xl font-bold text-gray-900 mb-2">
                {{ $post->comments_open ? 'Close Discussion' : 'Reopen Discussion' }}
            </h3>
            <p class="text-gray-600 mb-8 text-sm leading-relaxed">
                @if ($post->comments_open)
                    Closing a discussion prevents responses from being added. Existing responses will remain on your
                    story.
                @else
                    Reopening will allow readers to add new responses to your story.
                @endif
            </p>

            <div class="flex justify-center gap-4">
                <button onclick="document.getElementById('close-discussion-modal').classList.add('hidden')"
                    class="px-6 py-2 rounded-full text-gray-600 hover:text-black font-medium transition">
                    Cancel
                </button>

                <form action="{{ route('posts.toggleComments', $post->id) }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="px-6 py-2 rounded-full bg-red-600 text-white font-bold hover:bg-red-700 transition">
                        {{ $post->comments_open ? 'Close discussion' : 'Reopen' }}
                    </button>
                </form>
            </div>
        </div>
    </div>

</x-public-layout>


<!-- 1. DARK OVERLAY -->
<div id="comment-overlay" onclick="toggleComments()"
    class="fixed inset-0 bg-black bg-opacity-30 z-40 hidden transition-opacity duration-300">
</div>

<!-- 2. SIDEBAR DRAWER -->
<div id="comment-sidebar"
    class="fixed top-0 right-0 h-full w-full sm:w-[400px] bg-white shadow-2xl z-50 transform translate-x-full transition-transform duration-300 ease-in-out flex flex-col">

    <!-- Header -->
    <!-- Header -->
    <div class="p-6 border-b flex justify-between items-center bg-white relative">
        <h3 class="font-bold text-xl text-gray-900 font-serif">Responses
            <!-- Only show count if discussion is OPEN -->
            @if ($post->comments_open)
                ({{ $post->comments->count() }})
            @endif
        </h3>

        <div class="flex items-center gap-2">

            <!-- AUTHOR SETTINGS MENU -->
            @if (Auth::id() === $post->user_id)
                <div class="relative">
                    <button onclick="toggleSettingsMenu()"
                        class="text-gray-500 hover:text-black p-2 rounded-full hover:bg-gray-100 transition">
                        <!-- Three Dots Icon -->
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z">
                            </path>
                        </svg>
                    </button>

                    <!-- Dropdown -->
                    <div id="settings-menu"
                        class="hidden absolute right-0 mt-2 w-56 bg-white rounded-md shadow-xl border border-gray-100 z-50 overflow-hidden">
                        <button onclick="openCloseModal()"
                            class="w-full text-left px-4 py-3 text-sm text-red-600 hover:bg-gray-50 transition flex items-center gap-2">
                            @if ($post->comments_open)
                                Close discussion
                            @else
                                Reopen discussion
                            @endif
                        </button>
                    </div>
                </div>
            @endif

            <!-- Close Sidebar X -->
            <button onclick="toggleComments()" class="text-gray-500 hover:text-gray-800">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>
    </div>

    <!-- Scrollable Content -->
    <div class="flex-1 overflow-y-auto p-6 bg-gray-50">

        <!-- Login Prompt / Write Comment -->
        @if ($post->comments_open)
            @auth
                <div class="bg-white p-4 rounded-lg shadow-sm mb-8 border border-gray-200">

                    <!-- User Info -->
                    <div class="flex items-center gap-2 mb-3">
                        <div
                            class="h-8 w-8 rounded-full bg-brand-green flex items-center justify-center text-white text-xs font-bold">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <span class="text-sm font-bold text-gray-700">{{ Auth::user()->name }}</span>
                    </div>

                    <form action="{{ route('comments.store', $post->id) }}" method="POST" id="commentForm"
                        onsubmit="syncCommentBody()">
                        @csrf
                        <!-- Hidden Input to store the actual HTML/Text -->
                        <input type="hidden" name="body" id="real-comment-body">

                        <!-- CONTAINER -->
                        <div class="relative">

                            <!-- 1. COLLAPSED STATE (The Placeholder Overlay) -->
                            <!-- We overlay this on top. When clicked, we hide it and focus the editor. -->
                            <div id="comment-placeholder" onclick="expandComment()"
                                class="absolute inset-0 bg-white cursor-text text-gray-400 text-sm pt-2 pl-1 transition-opacity duration-200">
                                What are your thoughts?
                            </div>

                            <!-- 2. EXPANDED STATE (The Editor) -->
                            <div class="bg-gray-50 rounded-md overflow-hidden transition-all duration-300"
                                id="editor-wrapper">

                                <!-- Content Editable Div (Mimics Textarea but allows Bold/Italic) -->
                                <div id="comment-editor" contenteditable="true"
                                    class="w-full min-h-[60px] p-3 text-sm text-gray-800 outline-none placeholder-gray-400 bg-gray-50"
                                    oninput="checkInputState()" onfocus="expandComment()"></div>
                            </div>
                        </div>

                        <!-- 3. ACTION BAR (Hidden by default) -->
                        <div id="comment-actions"
                            class="hidden mt-3 flex items-center justify-between transition-all duration-300 opacity-0 transform translate-y-[-10px]">

                            <!-- Formatting Tools -->
                            <div class="flex items-center gap-4 text-gray-500">
                                <button type="button" onmousedown="formatText('bold'); return false;"
                                    class="font-serif font-bold text-lg hover:text-black" title="Bold">B</button>
                                <button type="button" onmousedown="formatText('italic'); return false;"
                                    class="font-serif italic text-lg hover:text-black" title="Italic">i</button>
                            </div>

                            <!-- Buttons -->
                            <div class="flex items-center gap-3">
                                <button type="button" onclick="cancelComment()"
                                    class="text-sm text-gray-500 hover:text-gray-900 font-medium">
                                    Cancel
                                </button>

                                <button type="submit" id="submit-btn" disabled
                                    class="bg-green-600 text-white text-sm px-4 py-1.5 rounded-full opacity-50 cursor-not-allowed transition duration-200">
                                    Respond
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            @else
                <div class="bg-blue-50 p-4 rounded-lg border border-blue-100 mb-8 text-center">
                    <p class="text-sm text-blue-800 mb-2">Join the conversation.</p>
                    <a href="{{ route('login') }}"
                        class="inline-block text-sm font-bold text-white bg-blue-600 px-4 py-2 rounded-full hover:bg-blue-700">
                        Log in to respond
                    </a>
                </div>
            @endauth
        @else
            <!-- CLOSED STATE MESSAGE -->
            <div class="bg-gray-100 p-6 rounded-lg text-center mb-8 border border-gray-200">
                <p class="font-serif font-bold text-gray-700">Discussion is closed</p>
                <p class="text-sm text-gray-500 mt-1">Comments have been turned off for this story.</p>
            </div>
        @endif

        <!-- Comments List -->
        <div class="space-y-6">
            @forelse($post->comments as $comment)
                <div class="border-b border-gray-200 pb-6 last:border-0">
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center gap-2">
                            <!-- User Avatar logic -->
                            @php
                                $avatarSrc = null;
                                if ($comment->user->avatar) {
                                    $avatarSrc = Str::startsWith($comment->user->avatar, 'http')
                                        ? $comment->user->avatar
                                        : asset('storage/' . $comment->user->avatar);
                                }
                            @endphp

                            @if ($avatarSrc)
                                <img src="{{ $avatarSrc }}" class="w-8 h-8 rounded-full object-cover">
                            @else
                                <div
                                    class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 text-xs font-bold">
                                    {{ substr($comment->user->name, 0, 1) }}
                                </div>
                            @endif

                            <div>
                                <p class="text-sm font-bold text-gray-900">{{ $comment->user->name }}</p>
                                <p class="text-xs text-gray-400">{{ $comment->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-800 text-sm leading-relaxed font-serif">
                        {!! $comment->body !!}
                    </p>
                </div>
            @empty
                <!-- Only show "Be the first" if the discussion is actually OPEN -->
                @if ($post->comments_open)
                    <div class="text-center py-10">
                        <p class="text-gray-400 italic text-sm">No responses yet. Be the first!</p>
                    </div>
                @endif
            @endforelse
        </div>
    </div>
</div>

<!-- 3. JS to Toggle Sidebar -->
<script>
    // VARIABLES
    const placeholder = document.getElementById('comment-placeholder');
    const editor = document.getElementById('comment-editor');
    const actions = document.getElementById('comment-actions');
    const submitBtn = document.getElementById('submit-btn');
    const wrapper = document.getElementById('editor-wrapper');

    // 1. EXPAND: Show tools, hide placeholder
    function expandComment() {
        placeholder.classList.add('hidden'); // Hide "What are your thoughts?"
        editor.focus();

        // Show Actions with animation
        actions.classList.remove('hidden');
        // Small delay to allow 'hidden' to remove before animating opacity
        setTimeout(() => {
            actions.classList.remove('opacity-0', 'translate-y-[-10px]');
        }, 10);

        // Change background to white for focus state
        wrapper.classList.remove('bg-gray-50');
        wrapper.classList.add('bg-white', 'shadow-sm', 'border', 'border-gray-200');
        editor.classList.remove('bg-gray-50');
        editor.classList.add('bg-white');
    }

    // 2. COLLAPSE: Reset everything
    function cancelComment() {
        // Clear text
        editor.innerHTML = '';

        // Show placeholder
        placeholder.classList.remove('hidden');

        // Hide Actions
        actions.classList.add('opacity-0', 'translate-y-[-10px]');
        setTimeout(() => {
            actions.classList.add('hidden');
        }, 300);

        // Reset Styles
        wrapper.classList.add('bg-gray-50');
        wrapper.classList.remove('bg-white', 'shadow-sm', 'border', 'border-gray-200');
        editor.classList.add('bg-gray-50');
        editor.classList.remove('bg-white');
    }

    // 3. FORMATTING: Bold / Italic
    function formatText(command) {
        document.execCommand(command, false, null);
        editor.focus(); // Keep focus inside box
    }

    // 4. CHECK INPUT: Enable/Disable Submit Button
    function checkInputState() {
        const content = editor.innerText.trim();
        if (content.length > 0) {
            submitBtn.disabled = false;
            submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            submitBtn.classList.add('hover:bg-green-700');
        } else {
            submitBtn.disabled = true;
            submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
            submitBtn.classList.remove('hover:bg-green-700');
        }
    }

    // 5. SYNC ON SUBMIT
    function syncCommentBody() {
        // Copy the HTML from the div to the hidden input so Laravel can read it
        document.getElementById('real-comment-body').value = editor.innerHTML;
    }

    function toggleComments() {
        const sidebar = document.getElementById('comment-sidebar');
        const overlay = document.getElementById('comment-overlay');
        const body = document.body;

        if (sidebar.classList.contains('translate-x-full')) {
            // OPEN
            sidebar.classList.remove('translate-x-full');
            overlay.classList.remove('hidden');
            body.classList.add('overflow-hidden'); // Prevent background scrolling
        } else {
            // CLOSE
            sidebar.classList.add('translate-x-full');
            overlay.classList.add('hidden');
            body.classList.remove('overflow-hidden');
        }
    }

    function toggleSettingsMenu() {
        const menu = document.getElementById('settings-menu');
        menu.classList.toggle('hidden');
    }

    function openCloseModal() {
        // Hide dropdown
        document.getElementById('settings-menu').classList.add('hidden');
        // Show Modal
        document.getElementById('close-discussion-modal').classList.remove('hidden');
    }

    // Auto-open if there are errors (like empty comment submission)
    @if ($errors->any())
        toggleComments();
    @endif
</script>
