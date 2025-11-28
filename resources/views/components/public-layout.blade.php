<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ur' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PlantsHealth | Innovations in Agriculture</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=playfair-display:400,700|inter:400,600,700&display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Noto+Nastaliq+Urdu:wght@400;700&display=swap" rel="stylesheet">

    <!-- Tailwind (CDN for Prototyping) -->
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
                            green: '#064e3b',
                            gold: '#d97706',
                        }
                    }
                }
            }
        }
    </script>

    <style>
        .font-urdu {
            font-family: 'Noto Nastaliq Urdu', serif;
            line-height: 2;
        }
    </style>
</head>

<body class="antialiased bg-gray-50 text-gray-800 {{ app()->getLocale() == 'ur' ? 'font-urdu' : 'font-sans' }}">

    <!-- 1. Include Header -->
    <x-header />

    <!-- 2. Main Content Slot (This is where the page content goes) -->
    <main>
        {{ $slot }}
    </main>

    <!-- 3. Include Footer -->
    <x-footer />

    <!-- SCROLL TO TOP BUTTON -->
    <button id="scrollToTopBtn" onclick="scrollToTop()"
        class="fixed bottom-8 right-8 z-50 bg-brand-green text-white p-3 rounded-full shadow-lg transition-all duration-300 opacity-0 invisible hover:bg-green-800 hover:-translate-y-1 focus:outline-none"
        title="Go to top">
        <!-- Arrow Up Icon -->
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
        </svg>
    </button>

    <script>
        // 1. Get the button
        const scrollBtn = document.getElementById("scrollToTopBtn");

        // 2. Listen for scroll events
        window.onscroll = function() {
            // If user scrolls down 300px, show button
            if (document.body.scrollTop > 300 || document.documentElement.scrollTop > 300) {
                scrollBtn.classList.remove("opacity-0", "invisible");
                scrollBtn.classList.add("opacity-100", "visible");
            } else {
                // Otherwise hide it
                scrollBtn.classList.add("opacity-0", "invisible");
                scrollBtn.classList.remove("opacity-100", "visible");
            }
        };

        // 3. Smooth scroll to top function
        function scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: "smooth"
            });
        }
    </script>
</body>

</html>
</body>

</html>
