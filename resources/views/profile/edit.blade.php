<x-public-layout>
    <div class="bg-gray-50 min-h-screen py-12">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="flex items-center gap-4 mb-8">
                <a href="{{ route('dashboard') }}" class="text-gray-400 hover:text-gray-600 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <h1 class="text-3xl font-serif font-bold text-gray-900">Account Settings</h1>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">

                <!-- 1. LEFT SIDEBAR (Navigation) -->
                <div class="md:col-span-1">
                    <nav class="space-y-1 sticky top-24">
                        <a href="#"
                            class="bg-white text-brand-green border-l-4 border-brand-green font-semibold px-5 py-4 flex items-center shadow-sm rounded-r-md">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Edit Profile
                        </a>
                        <a href="{{ route('password.edit') }}"
                            class="text-gray-600 hover:bg-white hover:text-gray-900 px-5 py-4 flex items-center transition rounded-md">
                            <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                </path>
                            </svg>
                            Password & Security
                        </a>
                        <a href="#"
                            class="text-gray-600 hover:bg-white hover:text-gray-900 px-5 py-4 flex items-center transition rounded-md">
                            <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                                </path>
                            </svg>
                            Notifications
                        </a>
                    </nav>
                </div>

                <!-- 2. MAIN FORM AREA -->
                <div class="md:col-span-3">
                    <div class="bg-white shadow-md rounded-xl overflow-hidden border border-gray-100">

                        <!-- Form Header -->
                        <div class="px-8 py-6 border-b border-gray-100 bg-white flex justify-between items-center">
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">Public Profile</h3>
                                <p class="text-sm text-gray-500 mt-1">Update your academic information and bio.</p>
                            </div>
                            @if (session('success'))
                                <span
                                    class="flex items-center gap-2 text-sm text-green-700 bg-green-50 border border-green-200 px-4 py-2 rounded-full">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    {{ session('success') }}
                                </span>
                            @endif
                        </div>

                        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data"
                            class="p-8">
                            @csrf

                            <!-- SECTION: IDENTITY -->
                            <div>
                                <h4 class="text-sm uppercase tracking-wider text-gray-500 font-bold mb-6">Identity &
                                    Photo</h4>

                                <div class="flex flex-col sm:flex-row gap-8">
                                    <!-- Avatar Logic (Keep existing HTML for avatar as it's complex) -->
                                    <div class="relative group w-32 flex-shrink-0">
                                        <div
                                            class="w-32 h-32 rounded-full overflow-hidden border-4 border-white shadow-lg ring-1 ring-gray-100">
                                            <img id="avatar-preview"
                                                src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : '' }}"
                                                class="w-full h-full object-cover {{ Auth::user()->avatar ? '' : 'hidden' }}">
                                            <div id="avatar-placeholder"
                                                class="w-full h-full bg-gradient-to-br from-brand-green to-green-800 flex items-center justify-center text-white text-4xl font-serif font-bold {{ Auth::user()->avatar ? 'hidden' : '' }}">
                                                {{ substr(Auth::user()->name, 0, 1) }}
                                            </div>
                                        </div>
                                        <label
                                            class="absolute bottom-0 right-0 bg-white p-2 rounded-full shadow-md cursor-pointer hover:bg-gray-50 border border-gray-200 transition transform hover:scale-105">
                                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z">
                                                </path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                            <input type="file" name="avatar" class="hidden"
                                                onchange="previewAvatar(this)">
                                        </label>
                                    </div>

                                    <div class="flex-1 grid grid-cols-1 md:grid-cols-3 gap-6">
                                        <!-- Select Box (We can componentize this later) -->
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                                            <select name="academic_title"
                                                class="w-full rounded-md border-gray-300 shadow-sm py-2.5 px-4 text-gray-900 focus:border-brand-gold focus:ring-1 focus:ring-brand-gold transition duration-200 ease-in-out">
                                                <option value="">Select...</option>
                                                @foreach (['Dr.', 'Prof.', 'Mr.', 'Ms.', 'Mx.'] as $title)
                                                    <option value="{{ $title }}"
                                                        {{ Auth::user()->academic_title == $title ? 'selected' : '' }}>
                                                        {{ $title }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- REUSING COMPONENT HERE -->
                                        <div class="md:col-span-2">
                                            <x-text-input label="Full Name" name="name" :value="Auth::user()->name" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="border-t border-gray-100 my-8"></div>

                            <!-- SECTION: ACADEMIC DETAILS -->
                            <div>
                                <h4 class="text-sm uppercase tracking-wider text-gray-500 font-bold mb-6">Academic
                                    Information</h4>

                                <div class="grid grid-cols-1 gap-2">
                                    <!-- REUSING COMPONENT -->
                                    <x-text-input label="Institution / Affiliation" name="affiliation"
                                        placeholder="e.g. University of Agriculture, Faisalabad" :value="Auth::user()->affiliation" />

                                    <!-- REUSING COMPONENT (Read Only) -->
                                    <x-text-input label="Email Address" name="email" :value="Auth::user()->email"
                                        :readonly="true" />

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-2">
                                        <x-text-input label="ORCID iD" name="orcid_id"
                                            placeholder="0000-0000-0000-0000" :value="Auth::user()->orcid_id" />

                                        <x-text-input label="Google Scholar URL" name="url_google_scholar"
                                            placeholder="https://scholar.google.com/..." :value="Auth::user()->url_google_scholar" />
                                    </div>

                                    <!-- Textarea (Standard HTML for now) -->
                                    <div class="mt-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Research
                                            Biography</label>
                                        <textarea name="bio" rows="4"
                                            class="w-full rounded-md border-gray-300 shadow-sm py-2.5 px-4 text-gray-900 placeholder-gray-400 focus:border-brand-gold focus:ring-1 focus:ring-brand-gold transition duration-200 ease-in-out"
                                            placeholder="Briefly describe your research interests...">{{ Auth::user()->bio }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- BUTTONS -->
                            <div class="pt-6 border-t border-gray-100 mt-8 flex items-center justify-end gap-3">
                                <a href="{{ route('dashboard') }}"
                                    class="px-6 py-2.5 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition">
                                    Cancel
                                </a>
                                <button type="submit"
                                    class="px-8 py-2.5 border border-transparent shadow-md text-sm font-bold rounded-lg text-white bg-brand-green hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-green transition transform hover:-translate-y-0.5">
                                    Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function previewAvatar(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var img = document.getElementById('avatar-preview');
                    var placeholder = document.getElementById('avatar-placeholder');
                    img.src = e.target.result;
                    img.classList.remove('hidden');
                    placeholder.classList.add('hidden');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</x-public-layout>
