<nav class="bg-white border-b border-gray-200 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">

            <!-- LEFT SIDE: Logo & Desktop Nav -->
            <div class="flex">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center gap-2">
                    <a href="{{ route('home') }}" class="flex items-center gap-2">
                        <div class="w-12 h-12 overflow-hidden">
                            <img class="w-full h-full object-contain" src="{{ asset('images/leaf-logo.png') }}"
                                alt="Logo" />
                        </div>
                        <span class="font-serif font-bold text-xl md:text-2xl text-gray-900 tracking-tight">Plants<span
                                class="text-brand-green">Health</span></span>
                    </a>
                </div>

                <!-- Desktop Navigation Links (Hidden on Mobile) -->
                <div class="hidden sm:ms-10 sm:flex sm:space-x-8">

                    <!-- Home Link -->
                    <a href="{{ route('home') }}"
                        class="{{ request()->routeIs('home') ? 'border-brand-gold text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition duration-150 ease-in-out">
                        {{ __('Home') }}
                    </a>

                    <!-- About (Example: checks if route is 'about') -->
                    <a href="#"
                        class="{{ request()->routeIs('about') ? 'border-brand-gold text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition duration-150 ease-in-out">
                        {{ __('About the Journal') }}
                    </a>

                    <!-- Editorial Board (Example: checks if route is 'editorial') -->
                    <a href="#"
                        class="{{ request()->routeIs('editorial') ? 'border-brand-gold text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition duration-150 ease-in-out">
                        {{ __('Editorial Board') }}
                    </a>
                </div>
            </div>

            <!-- RIGHT SIDE: Desktop Settings (Hidden on Mobile) -->
            <div class="hidden sm:flex items-center gap-4 ">

                <!-- Language Switcher (Desktop) -->
                <div class="relative group">
                    <button
                        class="flex items-center gap-1 text-sm font-medium text-gray-500 hover:text-brand-green py-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                        {{ strtoupper(app()->getLocale()) }}
                    </button>
                    <!-- Dropdown -->
                    <div
                        class="absolute right-0 top-full mt-0 w-32 bg-white rounded-md shadow-lg py-1 hidden group-hover:block border border-gray-100 z-50">
                        <a href="{{ route('switchLang', 'en') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 text-start">English</a>
                        <a href="{{ route('switchLang', 'ur') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 text-start">اردو</a>
                    </div>
                </div>

                <!-- Auth Buttons (Desktop) -->
                @if (Route::has('login'))
                    <div class="flex items-center gap-4">
                        @auth
                            @if (Auth::user()->role === 'admin')
                                <a href="{{ route('admin.dashboard') }}"
                                    class="text-sm font-bold text-brand-green border border-brand-green px-3 py-1 rounded hover:bg-brand-green hover:text-white transition">
                                    Admin
                                </a>
                            @else
                                <a href="{{ route('dashboard') }}"
                                    class="{{ request()->routeIs('dashboard') ? 'border-brand-gold text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition duration-150 ease-in-out">
                                    Dashboard
                                </a>
                            @endif

                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="text-sm font-semibold text-red-600 hover:text-red-800">
                                    {{ __('Logout') }}
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}"
                                class="{{ request()->routeIs('login') ? 'border-brand-gold text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition duration-150 ease-in-out">{{ __('Log in') }}</a>
                            <a href="{{ route('register') }}"
                                class="bg-brand-green hover:bg-green-800 text-white px-4 py-2 rounded-md text-sm font-medium transition whitespace-nowrap">{{ __('Submit') }}</a>
                        @endauth
                    </div>
                @endif
            </div>

            <!-- MOBILE MENU BUTTON (Hamburger) -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button type="button" onclick="toggleMobileMenu()"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <!-- Menu Icon -->
                    <svg id="menu-icon" class="h-6 w-6 block" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <!-- Close Icon (Hidden by default) -->
                    <svg id="close-icon" class="h-6 w-6 hidden" stroke="currentColor" fill="none"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- MOBILE MENU (Slide Down) -->
    <div id="mobile-menu" class="hidden sm:hidden bg-white border-t border-gray-200">
        <div class="pt-2 pb-3 space-y-1">
            <a href="{{ route('home') }}"
                class="block pl-3 pr-4 py-2 border-l-4 border-brand-green text-base font-medium text-brand-green bg-green-50 focus:outline-none focus:text-brand-green focus:bg-green-50 transition duration-150 ease-in-out">
                {{ __('Home') }}
            </a>
            <a href="#"
                class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300 transition duration-150 ease-in-out">
                {{ __('About the Journal') }}
            </a>
            <a href="#"
                class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300 transition duration-150 ease-in-out">
                {{ __('Editorial Board') }}
            </a>
        </div>

        <!-- Mobile User Options -->
        <div class="pt-4 pb-4 border-t border-gray-200">
            @auth
                <div class="flex items-center px-4">
                    <div class="flex-shrink-0">
                        <div
                            class="h-10 w-10 rounded-full bg-brand-green flex items-center justify-center text-white font-bold">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                    </div>
                    <div class="ml-3">
                        <div class="text-base font-medium text-gray-800">{{ Auth::user()->name }}</div>
                        <div class="text-sm font-medium text-gray-500">{{ Auth::user()->email }}</div>
                    </div>
                </div>

                <div class="mt-3 space-y-1">
                    @if (Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}"
                            class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">
                            Admin Portal
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}"
                            class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">
                            Dashboard
                        </a>
                    @endif

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="block w-full text-left px-4 py-2 text-base font-medium text-red-600 hover:bg-gray-100">
                            {{ __('Logout') }}
                        </button>
                    </form>
                </div>
            @else
                <div class="mt-3 space-y-1">
                    <a href="{{ route('login') }}"
                        class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">
                        {{ __('Log in') }}
                    </a>
                    <a href="{{ route('register') }}"
                        class="block px-4 py-2 text-base font-medium text-brand-green hover:bg-gray-100">
                        {{ __('Submit Manuscript') }}
                    </a>
                </div>
            @endauth

            <!-- Mobile Language Switcher -->
            <div class="mt-4 border-t border-gray-200 pt-4">
                <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Language</p>
                <div class="grid grid-cols-2 gap-2 px-4">
                    <a href="{{ route('switchLang', 'en') }}"
                        class="text-center py-2 border rounded hover:bg-gray-50 {{ app()->getLocale() == 'en' ? 'border-brand-green text-brand-green' : 'text-gray-600' }}">English</a>
                    <a href="{{ route('switchLang', 'ur') }}"
                        class="text-center py-2 border rounded hover:bg-gray-50 {{ app()->getLocale() == 'ur' ? 'border-brand-green text-brand-green' : 'text-gray-600' }}">اردو</a>
                </div>
            </div>
        </div>
    </div>
</nav>

<!-- JavaScript to toggle Menu -->
<script>
    function toggleMobileMenu() {
        const menu = document.getElementById('mobile-menu');
        const iconMenu = document.getElementById('menu-icon');
        const iconClose = document.getElementById('close-icon');

        if (menu.classList.contains('hidden')) {
            // Open
            menu.classList.remove('hidden');
            iconMenu.classList.add('hidden');
            iconClose.classList.remove('hidden');
        } else {
            // Close
            menu.classList.add('hidden');
            iconMenu.classList.remove('hidden');
            iconClose.classList.add('hidden');
        }
    }
</script>
