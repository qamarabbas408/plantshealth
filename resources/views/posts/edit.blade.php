<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Story</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Quill Bubble Theme -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.bubble.css" rel="stylesheet">
    <!-- Serif Font like Medium -->
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;1,300&display=swap"
        rel="stylesheet">

    <style>
        /* Typography Override */
        .font-serif {
            font-family: 'Merriweather', serif;
        }

        /* Quill Editor Styles */
        .ql-editor {
            font-family: 'Merriweather', serif;
            font-size: 1.25rem;
            /* 20px */
            line-height: 2;
            padding: 0;
            color: #292929;
            overflow-y: visible;
        }

        /* Placeholder color */
        .ql-editor.ql-blank::before {
            color: #b3b3b1;
            font-style: normal;
            left: 0;
        }

        /* Hide Scrollbar */
        body::-webkit-scrollbar {
            display: none;
        }

        /* Smooth movement for the sidebar */
        #sidebar-controls {
            transition: top 0.1s ease-out, opacity 0.2s ease;
        }
    </style>
</head>

<body class="bg-white text-gray-900 antialiased">

    <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data" id="storyForm">
        @csrf
        @method('PUT') <!-- Crucial for Update -->

        <!-- Populate Body content -->
        <input type="hidden" name="body" id="body-content" value="{{ $post->body }}">

        <!-- NEW: Hidden Status Input (Default to draft) -->
        <input type="hidden" name="status" id="status-input" value="draft">
        <!-- 1. HEADER -->
        <div class="max-w-screen-xl mx-auto px-4 py-4 flex justify-between items-center sticky top-0 bg-white z-50">
            <div class="flex items-center gap-3">
                <!-- Logo Code ... -->
                <span class="text-sm text-gray-500">Draft in {{ Auth::user()->name }}</span>
            </div>

            <!-- RIGHT SIDE ACTIONS -->
            <div class="flex items-center gap-2">

                <!-- 1. CANCEL BUTTON (New) -->
                <a href="{{ route('dashboard') }}"
                    class="text-gray-400 hover:text-gray-600 text-sm px-3 py-1.5 transition">
                    Cancel
                </a>

                <!-- 2. SAVE DRAFT BUTTON -->
                <button type="submit" onclick="setStatus('draft')"
                    class="text-gray-500 hover:text-gray-900 text-sm font-medium px-4 py-1.5 transition">
                    Save Draft
                </button>

                <!-- 3. PUBLISH BUTTON -->
                <button type="button" onclick="openModal()"
                    class="bg-green-600 hover:bg-green-700 text-white text-sm px-4 py-1.5 rounded-full transition">
                    Publish
                </button>
            </div>
        </div>

        <!-- 2. WRITING AREA -->
        <div class="max-w-[700px] mx-auto px-4 mt-16 relative">

            <!-- TITLE INPUT -->
            <input type="text" name="title" value="{{ $post->title }}" placeholder="Title" required autofocus
                class="w-full text-5xl font-serif font-bold placeholder-gray-300 text-gray-800 border-none outline-none focus:ring-0 p-0 mb-6 bg-transparent">

            <!-- EDITOR WRAPPER -->
            <div class="relative group">

                <!-- FLOATING TOOLBAR (Tracks Cursor) -->
                <!-- Invisible by default. JS moves it and shows it. -->
                <div id="sidebar-controls" class="absolute -left-14 z-20 flex items-center invisible opacity-0"
                    style="top: 0px;">

                    <!-- Toggle Button (+ / X) -->
                    <button type="button" id="toggleBtn" onclick="toggleMenu()"
                        class="rounded-full border border-gray-300 w-8 h-8 flex items-center justify-center text-gray-400 hover:border-gray-800 hover:text-gray-800 bg-white transition-transform duration-200">

                        <!-- Plus Icon -->
                        <svg id="icon-plus" width="20" height="20" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>

                        <!-- X Icon (Hidden) -->
                        <svg id="icon-close" class="hidden" width="20" height="20" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round"
                            stroke-linejoin="round">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </button>

                    <!-- The Menu Options (Slide out) -->
                    <div id="sidebar-menu" class="hidden flex items-center gap-3 ml-3 bg-white">

                        <!-- Image Button -->
                        <button type="button" onclick="document.getElementById('imageInsert').click()"
                            class="rounded-full border border-green-600 text-green-600 w-8 h-8 flex items-center justify-center hover:bg-green-50 transition"
                            title="Add Image">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                <polyline points="21 15 16 10 5 21"></polyline>
                            </svg>
                        </button>

                        <!-- Code Button -->
                        <button type="button" onclick="insertCode()"
                            class="rounded-full border border-green-600 text-green-600 w-8 h-8 flex items-center justify-center hover:bg-green-50 transition"
                            title="Add Code Block">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <polyline points="16 18 22 12 16 6"></polyline>
                                <polyline points="8 6 2 12 8 18"></polyline>
                            </svg>
                        </button>
                    </div>

                    <!-- Hidden File Input -->
                    <input type="file" id="imageInsert" class="hidden" onchange="insertImage(this)">
                </div>

                <!-- QUILL EDITOR CONTAINER -->
                <!-- Minimal height ensures click-below behavior -->
                <div id="editor" class="min-h-[500px] mb-32"></div>
            </div>
        </div>

        <!-- 3. PUBLISH MODAL -->
        <div id="publishModal" class="fixed inset-0 bg-white z-[60] hidden overflow-y-auto">
            <div class="max-w-screen-xl mx-auto px-4 py-4 flex justify-end">
                <button type="button" onclick="closeModal()"
                    class="text-3xl text-gray-400 hover:text-gray-800">&times;</button>
            </div>
            <div class="max-w-5xl mx-auto grid md:grid-cols-2 gap-12 mt-8 px-4 items-center">

                <!-- Preview Side -->
                <div>
                    <h3 class="font-bold mb-4 text-gray-700">Story Preview</h3>
                    <div class="bg-gray-50 p-6 rounded-md border border-gray-100">
                        <div class="relative bg-gray-200 h-56 w-full mb-4 flex items-center justify-center cursor-pointer overflow-hidden group"
                            onclick="document.getElementById('coverImage').click()">
                            @php
                                $imgSrc = '';
                                $isHidden = 'hidden';
                                if ($post->image_path) {
                                    $imgSrc = Str::startsWith($post->image_path, 'http')
                                        ? $post->image_path
                                        : asset('storage/' . $post->image_path);
                                    $isHidden = '';
                                }
                            @endphp
                            <img id="modalPreview" src="{{ $imgSrc }}"
                                class="absolute inset-0 w-full h-full object-cover {{ $isHidden }}">
                            <span id="modalText" class="text-gray-400 ... {{ $isHidden ? '' : 'hidden' }}">Add a
                                high-quality image...</span>
                        </div>
                        <input type="file" name="featured_image" id="coverImage" class="hidden"
                            onchange="previewCover(this)">

                        <h4 class="font-serif font-bold text-xl mb-2 text-gray-900" id="previewTitle">Untitled Story
                        </h4>
                        <p class="text-gray-500 text-sm font-serif truncate">Note: Description will appear here...</p>
                    </div>
                </div>

                <!-- Settings Side -->
                <div>
                    <p class="text-sm text-gray-500 mb-4">Publishing to: <strong>{{ Auth::user()->name }}</strong></p>
                    <p class="text-sm text-gray-600 mb-2">Add or change topics (up to 5):</p>
                    <input type="text" name="tags" value="{{ $post->tags->pluck('name')->implode(', ') }}"
                        placeholder="Agriculture, Innovation..."
                        class="w-full border-b border-gray-300 py-2 text-sm focus:outline-none focus:border-green-600 mb-8 bg-transparent">

                    <!-- NEW: Allow Comments Toggle (With State Check) -->
                    <div class="flex items-center mb-8">
                        <input type="checkbox" name="allow_comments" id="allow_comments" value="1"
                            {{ $post->comments_open ? 'checked' : '' }}
                            class="w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500 focus:ring-2">
                        <label for="allow_comments" class="ml-2 text-sm text-gray-600 cursor-pointer">
                            Allow readers to leave comments
                        </label>
                    </div>
                    <!-- Inside Modal -->
                    <button type="submit" onclick="setStatus('publish')"
                        class="bg-green-600 text-white font-bold py-2 px-8 rounded-full hover:bg-green-700 transition">
                        Publish now
                    </button>
                </div>
            </div>
        </div>
    </form>

    <!-- SCRIPTS -->
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script>
        // 1. Initialize Quill
        var quill = new Quill('#editor', {
            theme: 'bubble',
            placeholder: 'Tell your story...',
            modules: {
                toolbar: [
                    ['bold', 'italic', 'link'],
                    [{
                        'header': 1
                    }, {
                        'header': 2
                    }, 'blockquote'],
                ]
            }
        });

        // NEW: Load existing content
        quill.root.innerHTML = document.getElementById('body-content').value;

        // 2. Sidebar Tracking Logic
        const sidebar = document.getElementById('sidebar-controls');
        const sidebarMenu = document.getElementById('sidebar-menu');
        const toggleBtn = document.getElementById('toggleBtn');
        const iconPlus = document.getElementById('icon-plus');
        const iconClose = document.getElementById('icon-close');

        // Listen for cursor changes
        quill.on('editor-change', function(eventName, ...args) {
            if (eventName === 'selection-change') {
                const range = args[0];
                if (range) {
                    updateSidebarPosition(range.index);
                } else {
                    hideSidebar();
                }
            } else if (eventName === 'text-change') {
                const range = quill.getSelection();
                if (range) updateSidebarPosition(range.index);
            }
        });

        function updateSidebarPosition(index) {
            const [line, offset] = quill.getLine(index);
            // If line is empty (length is 1 for newline char)
            if (line && line.length() === 1) {
                const bounds = quill.getBounds(index);
                if (bounds) {
                    sidebar.style.top = (bounds.top) + 'px';
                    sidebar.classList.remove('invisible');
                    sidebar.classList.remove('opacity-0');
                }
            } else {
                hideSidebar();
            }
        }

        function hideSidebar() {
            sidebar.classList.add('invisible');
            sidebar.classList.add('opacity-0');
            resetMenu();
        }

        // 3. Menu Actions
        function toggleMenu() {
            if (sidebarMenu.classList.contains('hidden')) {
                // OPEN
                sidebarMenu.classList.remove('hidden');
                sidebarMenu.classList.add('flex');
                iconPlus.classList.add('hidden');
                iconClose.classList.remove('hidden');
                toggleBtn.classList.add('rotate-90');
            } else {
                resetMenu();
            }
        }

        function resetMenu() {
            sidebarMenu.classList.add('hidden');
            sidebarMenu.classList.remove('flex');
            iconPlus.classList.remove('hidden');
            iconClose.classList.add('hidden');
            toggleBtn.classList.remove('rotate-90');
        }

        // 4. Insert Image & Auto New Line
        function insertImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    const range = quill.getSelection(true);
                    // Insert Image
                    quill.insertEmbed(range.index, 'image', e.target.result);
                    // Force New Line
                    quill.insertText(range.index + 1, '\n');
                    quill.setSelection(range.index + 2);
                    resetMenu();
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        // 5. Insert Code & Auto New Line
        function insertCode() {
            const range = quill.getSelection(true);
            // Format current line as code
            quill.formatLine(range.index, 1, 'code-block', true);
            // New line
            quill.insertText(range.index + 1, '\n');
            // Remove code format for new line
            quill.formatLine(range.index + 1, 1, 'code-block', false);
            quill.setSelection(range.index + 1);
            resetMenu();
        }

        // 6. Modal & Form Logic
        document.getElementById('storyForm').onsubmit = function() {
            document.querySelector('input[name=body]').value = quill.root.innerHTML;
        };

        function openModal() {
            var title = document.querySelector('input[name=title]').value;
            document.getElementById('previewTitle').innerText = title || "Untitled Story";
            document.getElementById('publishModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('publishModal').classList.add('hidden');
        }

        function previewCover(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('modalPreview').src = e.target.result;
                    document.getElementById('modalPreview').classList.remove('hidden');
                    document.getElementById('modalText').classList.add('hidden');
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        function setStatus(status) {
            document.getElementById('status-input').value = status;
            // Note: The form will submit automatically because the buttons are type="submit" 
            // (except the one that opens the modal which is type="button")
        }
    </script>
</body>

</html>
