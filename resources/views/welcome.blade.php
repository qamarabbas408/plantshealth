<!DOCTYPE html>
{{-- <html lang="{{ str_replace('_', '-', app()->getLocale()) }}"> --}}
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}" 
      dir="{{ app()->getLocale() == 'ur' ? 'rtl' : 'ltr' }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>PlantsHealth | Innovations in Agriculture</title>
        <!-- Fonts -->
        <!-- Google Fonts: Noto Nastaliq Urdu -->
<link href="https://fonts.googleapis.com/css2?family=Noto+Nastaliq+Urdu:wght@400;700&display=swap" rel="stylesheet">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=playfair-display:400,700|inter:400,600,700&display=swap" rel="stylesheet" />
        <!-- Tailwind (Via CDN for quick UI prototyping without building) -->
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        fontFamily: {
                            sans: ['Inter', 'sans-serif'],
                            serif: ['Playfair Display', 'serif'],
                        },
                        colors: {
                            brand: {
                                green: '#064e3b', // Emerald 900
                                gold: '#d97706',  // Amber 600
                            }
                        }
                    }
                }
            }
        </script>

        <style>
    /* Custom Class for Urdu Font */
    .font-urdu {
        font-family: 'Noto Nastaliq Urdu', serif;
        line-height: 2; /* Urdu needs more height */
    }
</style>
    </head>
<body class="antialiased bg-gray-50 text-gray-800 {{ app()->getLocale() == 'ur' ? 'font-urdu' : 'font-sans' }}">

      <!-- Navigation -->
<nav class="bg-white border-b border-gray-200 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center gap-2">
                    <div class="w-8 h-8 bg-brand-green rounded-te-lg rounded-bs-lg"></div>
                    <span class="font-serif font-bold text-2xl text-gray-900 tracking-tight">Plants<span class="text-brand-green">Health</span></span>
                </div>
                <!-- Desktop Nav -->
                <div class="hidden sm:ms-10 sm:flex sm:space-x-8">
                    <a href="#" class="border-brand-gold text-gray-900 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
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
                
                <!-- Language Switcher -->
                <div class="relative group">
                    <button class="flex items-center gap-1 text-sm font-medium text-gray-500 hover:text-brand-green">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        {{ strtoupper(app()->getLocale()) }}
                    </button>
                    <!-- Dropdown -->
                    <div class="absolute right-0 mt-2 w-32 bg-white rounded-md shadow-lg py-1 hidden group-hover:block border border-gray-100">
                        <a href="{{ route('switchLang', 'en') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">English (EN)</a>
                        <a href="{{ route('switchLang', 'es') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Español (ES)</a>
                        <a href="{{ route('switchLang', 'fr') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Français (FR)</a>
                        <a href="{{ route('switchLang', 'ur') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Urdu (UR)</a>

                    </div>
                </div>

                @if (Route::has('login'))
                    <div class="space-x-4">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-sm text-gray-700 hover:text-brand-green">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-600 hover:text-brand-green">{{ __('Log in') }}</a>
                            <a href="{{ route('register') }}" class="bg-brand-green hover:bg-green-800 text-white px-4 py-2 rounded-md text-sm font-medium transition">{{ __('Submit Manuscript') }}</a>
                        @endauth
                    </div>
                @endif
            </div>
        </div>
    </div>
</nav>

        <!-- Hero Section -->
        <div class="relative bg-brand-green overflow-hidden">
            <div class="absolute inset-0 opacity-20" style="background-image: url('https://images.unsplash.com/photo-1625246333195-5512a96d8a48?q=80&w=2070&auto=format&fit=crop'); background-size: cover; background-position: center;"></div>
            <div class="relative max-w-7xl mx-auto py-24 px-4 sm:py-32 sm:px-6 lg:px-8 flex flex-col items-center text-center">
                <h1 class="text-4xl font-serif font-bold tracking-tight text-white sm:text-5xl md:text-6xl">
                    Modern Agriculture is <span class="text-amber-400 italic">Gold</span>
                </h1>
                <p class="mt-6 max-w-2xl text-xl text-green-100">
                    Bridging the gap between agricultural engineering, informatics, and molecular studies. A Gold Open Access journal for the next generation of farming.
                </p>
                <div class="mt-10 flex gap-4">
                    <a href="#" class="bg-amber-500 hover:bg-amber-600 text-white font-bold py-3 px-8 rounded shadow-lg transition">Read Latest Issue</a>
                    <a href="#" class="bg-transparent border border-white text-white hover:bg-white hover:text-brand-green font-bold py-3 px-8 rounded transition">Mission Statement</a>
                </div>
            </div>
        </div>

        <!-- Featured Article (Grid) -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="flex justify-between items-end mb-8">
                <div>
                    <h2 class="text-3xl font-serif font-bold text-gray-900">Latest Insights</h2>
                    <p class="mt-2 text-gray-600">Curated articles from our editors and scholars.</p>
                </div>
                <a href="#" class="text-brand-green font-semibold hover:text-green-800">View all posts &rarr;</a>
            </div>

            <div class="grid gap-10 md:grid-cols-3">
                
                <!-- Card 1 -->
                <div class="flex flex-col overflow-hidden rounded-lg shadow-lg bg-white hover:shadow-xl transition duration-300">
                    <div class="flex-shrink-0">
                        <img class="h-48 w-full object-cover" src="https://images.unsplash.com/photo-1586771107445-d3ca888129ff?q=80&w=2072&auto=format&fit=crop" alt="">
                    </div>
                    <div class="flex-1 p-6 flex flex-col justify-between">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-brand-gold">Agro-Informatics</p>
                            <a href="#" class="block mt-2">
                                <p class="text-xl font-serif font-semibold text-gray-900">AI Drones in Soil Analysis</p>
                                <p class="mt-3 text-base text-gray-500">How machine learning is reshaping the way we understand soil nutrient density in real-time...</p>
                            </a>
                        </div>
                        <div class="mt-6 flex items-center">
                            <div class="flex-shrink-0">
                                <span class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 font-bold">JD</span>
                            </div>
                            <div class="ms-3">
                                <p class="text-sm font-medium text-gray-900">John Doe</p>
                                <div class="flex space-x-1 text-sm text-gray-500">
                                    <time datetime="2020-03-16">Mar 16, 2025</time>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="flex flex-col overflow-hidden rounded-lg shadow-lg bg-white hover:shadow-xl transition duration-300">
                    <div class="flex-shrink-0">
                        <img class="h-48 w-full object-cover" src="https://images.unsplash.com/photo-1530836369250-ef72a3f5cda8?q=80&w=2070&auto=format&fit=crop" alt="">
                    </div>
                    <div class="flex-1 p-6 flex flex-col justify-between">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-brand-gold">Sustainable Tech</p>
                            <a href="#" class="block mt-2">
                                <p class="text-xl font-serif font-semibold text-gray-900">Hydroponics at Scale</p>
                                <p class="mt-3 text-base text-gray-500">Exploring the energy efficiency of vertical farming solutions in urban environments.</p>
                            </a>
                        </div>
                        <div class="mt-6 flex items-center">
                            <div class="flex-shrink-0">
                                <span class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 font-bold">AS</span>
                            </div>
                            <div class="ms-3">
                                <p class="text-sm font-medium text-gray-900">Alice Smith</p>
                                <div class="flex space-x-1 text-sm text-gray-500">
                                    <time datetime="2020-03-16">Mar 12, 2025</time>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                 <!-- Card 3 -->
                 <div class="flex flex-col overflow-hidden rounded-lg shadow-lg bg-white hover:shadow-xl transition duration-300">
                    <div class="flex-shrink-0">
                        <img class="h-48 w-full object-cover" src="https://images.unsplash.com/photo-1574943320219-553eb213f72d?q=80&w=1979&auto=format&fit=crop" alt="">
                    </div>
                    <div class="flex-1 p-6 flex flex-col justify-between">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-brand-gold">Molecular Studies</p>
                            <a href="#" class="block mt-2">
                                <p class="text-xl font-serif font-semibold text-gray-900">CRISPR in Wheat Production</p>
                                <p class="mt-3 text-base text-gray-500">A deep dive into the ethical and practical applications of gene editing in staple crops.</p>
                            </a>
                        </div>
                        <div class="mt-6 flex items-center">
                            <div class="flex-shrink-0">
                                <span class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 font-bold">MK</span>
                            </div>
                            <div class="ms-3">
                                <p class="text-sm font-medium text-gray-900">Dr. M. Khan</p>
                                <div class="flex space-x-1 text-sm text-gray-500">
                                    <time datetime="2020-03-16">Feb 28, 2025</time>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Footer -->
        <footer class="bg-gray-900 text-white">
            <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <span class="font-serif font-bold text-2xl text-white tracking-tight">Plants<span class="text-brand-green">Health</span></span>
                    <p class="mt-4 text-gray-400 text-sm">
                        Aiming to obtain the first impact factor in 2026. Publishing high-quality peer-reviewed articles on innovations in agricultural science.
                    </p>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-gray-400 tracking-wider uppercase">Resources</h3>
                    <ul class="mt-4 space-y-4">
                        <li><a href="#" class="text-base text-gray-300 hover:text-white">For Authors</a></li>
                        <li><a href="#" class="text-base text-gray-300 hover:text-white">For Editors</a></li>
                        <li><a href="#" class="text-base text-gray-300 hover:text-white">Open Access Policy</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-gray-400 tracking-wider uppercase">Stay Updated</h3>
                    <p class="mt-4 text-gray-300 text-sm">Subscribe to our newsletter for the latest agricultural innovations.</p>
                    <form class="mt-4 flex">
                        <input type="email" class="w-full px-3 py-2 rounded-l-md text-gray-900 outline-none" placeholder="Enter your email">
                        <button class="bg-brand-green px-4 py-2 rounded-r-md hover:bg-green-800 transition">Subscribe</button>
                    </form>
                </div>
            </div>
        </footer>
    </body>
</html>