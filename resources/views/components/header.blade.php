<nav class="sticky top-0 z-50 w-full bg-white/95 backdrop-blur-sm border-b border-gray-100 transition-all duration-300"
    id="main-nav">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">

            <!-- 1. LOGO (Left) -->
            <div class="flex-shrink-0 flex items-center">
                <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                    <div class="w-8 h-10 overflow-hidden transition-transform duration-300 group-hover:scale-105">
                        <img class="w-full h-full object-contain" src="{{ asset('images/leaf-logo.png') }}"
                            alt="Logo" />
                    </div>
                    <span class="font-serif font-bold text-2xl text-gray-900 tracking-tight">
                        Plants<span class="text-brand-green">Health</span>
                    </span>
                </a>
            </div>

            <!-- 2. CENTER NAVIGATION (Desktop Only) -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="{{ route('home') }}"
                    class=" font-medium transition-colors duration-200 {{ request()->routeIs('home') ? 'text-brand-gold font-bold' : 'text-gray-600 hover:text-brand-green' }}">
                    {{ __('Home') }}
                </a>
                <a href="{{ route('pages.about') }}"
                    class=" font-medium transition-colors duration-200  {{ request()->routeIs('pages.about') ? 'text-brand-gold font-bold' : 'text-gray-600 hover:text-brand-green' }}">
                    {{ __('About') }}
                </a>
                <a href="{{ route('pages.editorial') }}"
                    class="font-medium transition-colors duration-200  {{ request()->routeIs('pages.editorial') ? 'text-brand-gold font-bold' : 'text-gray-600 hover:text-brand-green' }}">
                    {{ __('Editorial Board') }}
                </a>
            </div>

            <!-- 3. RIGHT ACTIONS (Desktop Only) -->
            <div class="hidden md:flex items-center gap-4">

                <!-- Language Dropdown -->
                <div class="relative" id="lang-dropdown-container">
                    <button onclick="toggleDropdown('lang-dropdown')"
                        class="flex items-center gap-1 text-sm font-semibold text-gray-500 hover:text-gray-800 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                        <span>{{ strtoupper(app()->getLocale()) }}</span>
                        <svg class="w-3 h-3 ml-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </button>
                    <!-- Lang Menu -->
                    <div id="lang-dropdown"
                        class="absolute right-0 mt-3 w-32 bg-white rounded-lg shadow-xl py-2 hidden border border-gray-100 transform origin-top-right transition-all">
                        <a href="{{ route('switchLang', 'en') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-50 hover:text-brand-green">English</a>
                        <a href="{{ route('switchLang', 'ur') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-50 hover:text-brand-green text-right">اردو</a>
                    </div>
                </div>

                <div class="h-6 w-px bg-gray-200"></div> <!-- Vertical Divider -->

                @auth
                    <!-- LOGGED IN: Avatar Dropdown -->
                    <div class="relative" id="user-dropdown-container">
                        <button onclick="toggleDropdown('user-dropdown')"
                            class="flex items-center gap-2 focus:outline-none">
                            <span class="text-sm font-medium text-gray-700 hidden lg:block">{{ Auth::user()->name }}</span>
                            <div
                                class="h-9 w-9 rounded-full overflow-hidden border border-gray-200 ring-2 ring-transparent hover:ring-brand-green transition">
                                @if (Auth::user()->avatar)
                                    <img src="{{ Str::startsWith(Auth::user()->avatar, 'http') ? Auth::user()->avatar : asset('storage/' . Auth::user()->avatar) }}"
                                        class="h-full w-full object-cover">
                                @else
                                    <div
                                        class="h-full w-full bg-brand-green flex items-center justify-center text-white font-bold">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </div>
                                @endif
                            </div>
                        </button>

                        <!-- User Menu -->
                        <div id="user-dropdown"
                            class="absolute right-0 mt-3 w-56 bg-white rounded-lg shadow-xl py-2 hidden border border-gray-100 z-50">
                            <div class="px-4 py-3 border-b border-gray-100">
                                <p class="text-sm font-semibold text-gray-900 truncate">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                            </div>

                            @if (Auth::user()->role === 'admin')
                                <a href="{{ route('admin.dashboard') }}"
                                    class="block px-4 py-2 text-sm text-brand-green font-bold hover:bg-green-50">Admin
                                    Portal</a>
                            @else
                                <a href="{{ route('dashboard') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Dashboard</a>
                            @endif

                            <a href="{{ route('posts.create') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Write a Story</a>
                            <a href="{{ route('stats.index') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Stats</a>
                            <a href="{{ route('profile.edit') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Settings</a>

                            <div class="border-t border-gray-100 my-1"></div>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                    {{ __('Logout') }}
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <!-- GUEST: Links -->
                    <a href="{{ route('login') }}"
                        class="text-sm font-medium  hover:text-brand-green transition {{ request()->routeIs('login') ? 'text-brand-gold font-bold' : 'text-gray-600 hover:text-brand-green' }}">
                        {{ __('Log in') }}
                    </a>
                    <a href="{{ route('register') }}"
                        class=" hover:bg-green-800 text-white px-5 py-2.5 rounded-full 
                        text-sm font-bold shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition duration-200
                        {{ request()->routeIs('register') ? 'bg-brand-gold' : 'bg-brand-green' }}
                        ">
                        {{ __('Submit Manuscript') }}
                    </a>
                @endauth
            </div>

            <!-- 4. MOBILE MENU BUTTON -->
            <div class="flex items-center md:hidden gap-4">
                <!-- Mobile Lang Icon -->
                <a href="{{ route('switchLang', app()->getLocale() == 'en' ? 'ur' : 'en') }}"
                    class="text-gray-500 font-bold text-sm">
                    {{ strtoupper(app()->getLocale()) }}
                </a>

                <button type="button" onclick="toggleMobileMenu()"
                    class="text-gray-500 hover:text-gray-900 focus:outline-none p-2">
                    <svg id="menu-icon" class="h-7 w-7" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg id="close-icon" class="h-7 w-7 hidden" stroke="currentColor" fill="none"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- 5. MOBILE MENU DRAWER -->
    <div id="mobile-menu" class="hidden md:hidden bg-white border-t border-gray-100 shadow-inner absolute w-full">
        <div class="px-4 pt-4 pb-6 space-y-2">

            <a href="{{ route('home') }}"
                class="block px-3 py-3 rounded-md text-base font-medium {{ request()->routeIs('home') ? 'bg-green-50 text-brand-green font-bold' : 'text-gray-700 hover:bg-gray-50' }}">
                {{ __('Home') }}
            </a>
            <a href="{{ route('pages.about') }}"
                class="block px-3 py-3 rounded-md text-base font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900 {{ request()->routeIs('pages.about') ? 'bg-green-50 text-brand-green font-bold' : 'text-gray-700 hover:bg-gray-50' }}">
                {{ __('About the Journal') }}
            </a>
            <a href="{{ route('pages.editorial') }}"
                class="block px-3 py-3 rounded-md text-base font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900 {{ request()->routeIs('pages.editorial') ? 'bg-green-50 text-brand-green font-bold' : 'text-gray-700 hover:bg-gray-50' }}">
                {{ __('Editorial Board') }}
            </a>

            <div class="border-t border-gray-100 my-4"></div>

            @auth
                <!-- Mobile User Info -->
                <div class="flex items-center px-3 mb-4">
                    <div class="flex-shrink-0">
                        <div
                            class="h-10 w-10 rounded-full bg-brand-green flex items-center justify-center text-white font-bold text-lg">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                    </div>
                    <div class="ml-3">
                        <div class="text-base font-medium text-gray-800">{{ Auth::user()->name }}</div>
                        <div class="text-sm font-medium text-gray-500">{{ Auth::user()->email }}</div>
                    </div>
                </div>

                <a href="{{ route('posts.create') }}"
                    class="block w-full text-center bg-gray-900 text-white px-4 py-3 rounded-lg font-bold shadow-md">
                    Write a Story
                </a>

                <div class="mt-4 space-y-1">
                    <a href="{{ route('dashboard') }}"
                        class="block px-3 py-2 text-base font-medium text-gray-600 hover:text-gray-900">Dashboard</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="block w-full text-left px-3 py-2 text-base font-medium text-red-600 hover:bg-red-50 rounded-md">
                            {{ __('Logout') }}
                        </button>
                    </form>
                </div>
            @else
                <a href="{{ route('login') }}"
                    class="block w-full text-center border border-gray-300 text-gray-700 px-4 py-3 rounded-lg font-bold mb-3 hover:bg-gray-50">
                    {{ __('Log in') }}
                </a>
                <a href="{{ route('register') }}"
                    class="block w-full text-center bg-brand-green text-white px-4 py-3 rounded-lg font-bold shadow-md hover:bg-green-800">
                    {{ __('Submit Manuscript') }}
                </a>
            @endauth
        </div>
    </div>
</nav>

<!-- Scripts for Interaction -->
<script>
    // 1. Toggle Mobile Menu
    function toggleMobileMenu() {
        const menu = document.getElementById('mobile-menu');
        const iconMenu = document.getElementById('menu-icon');
        const iconClose = document.getElementById('close-icon');

        menu.classList.toggle('hidden');
        iconMenu.classList.toggle('hidden');
        iconClose.classList.toggle('hidden');
    }

    // 2. Toggle Dropdowns (Lang & User)
    function toggleDropdown(id) {
        // Close others first
        const allDropdowns = ['lang-dropdown', 'user-dropdown'];
        allDropdowns.forEach(dd => {
            if (dd !== id) document.getElementById(dd)?.classList.add('hidden');
        });

        const el = document.getElementById(id);
        if (el) el.classList.toggle('hidden');
    }

    // 3. Close Dropdowns when clicking outside
    document.addEventListener('click', function(event) {
        const langContainer = document.getElementById('lang-dropdown-container');
        const userContainer = document.getElementById('user-dropdown-container');

        if (langContainer && !langContainer.contains(event.target)) {
            document.getElementById('lang-dropdown').classList.add('hidden');
        }
        if (userContainer && !userContainer.contains(event.target)) {
            document.getElementById('user-dropdown').classList.add('hidden');
        }
    });
</script>
