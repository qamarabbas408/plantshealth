<nav class="bg-white border-b border-gray-200 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center gap-2">
                    <div class="w-8 h-12 rounded-te-lg rounded-bs-lg overflow-hidden">
                        <!-- Ensure you have this image or use a placeholder -->
                        <img class="w-full h-full object-cover" src="{{ asset('images/logo-leaves.png') }}" alt="Logo"/>
                    </div>
                    <span class="font-serif font-bold text-2xl text-gray-900 tracking-tight">Plants<span class="text-brand-green">Health</span></span>
                </div>
                <!-- Desktop Nav -->
                <div class="hidden sm:ms-10 sm:flex sm:space-x-8">
                    <a href="/" class="border-brand-gold text-gray-900 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                        {{ __('Home') }}
                    </a>
                    <a href="#" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                        {{ __('About the Journal') }}
                    </a>
                    <a href="#" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                        {{ __('Editorial Board') }}
                    </a>
                </div>
            </div>
            
            <div class="flex items-center gap-4">
               

                  <!-- AUTHENTICATION LOGIC START -->
    @if (Route::has('login'))
        <div class="flex items-center gap-4">
            @auth
                <!-- 1. Check Role to show correct Dashboard link -->
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="text-sm font-bold text-brand-green border border-brand-green px-3 py-1 rounded hover:bg-brand-green hover:text-white transition">
                        Admin Portal
                    </a>
                @else
                    <a href="{{ route('dashboard') }}" class="text-sm text-gray-700 hover:text-brand-green">
                        Dashboard
                    </a>
                @endif

                <!-- 2. Logout Button (Always visible if logged in) -->
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-sm font-semibold text-red-600 hover:text-red-800">
                        {{ __('Logout') }}
                    </button>
                </form>

            @else
                <!-- Guest View -->
                <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-600 hover:text-brand-green">{{ __('Log in') }}</a>
                <a href="{{ route('register') }}" class="bg-brand-green hover:bg-green-800 text-white px-4 py-2 rounded-md text-sm font-medium transition">{{ __('Submit Manuscript') }}</a>
            @endauth
        </div>
    @endif
    <!-- AUTHENTICATION LOGIC END -->

     <!-- Language Switcher -->
                <div class="relative group">
                    <button class="flex items-center gap-1 text-sm font-medium text-gray-500 hover:text-brand-green">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        {{ strtoupper(app()->getLocale()) }}
                    </button>
                    <!-- Dropdown -->
                    <div class="absolute right-0 rtl:right-auto rtl:left-0 mt-2 w-32 bg-white rounded-md shadow-lg py-1 hidden group-hover:block border border-gray-100">
                        <a href="{{ route('switchLang', 'en') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 text-start">English (EN)</a>
                        <a href="{{ route('switchLang', 'es') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 text-start">Español (ES)</a>
                        <a href="{{ route('switchLang', 'fr') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 text-start">Français (FR)</a>
                        <a href="{{ route('switchLang', 'ur') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 text-start">اردو (UR)</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>