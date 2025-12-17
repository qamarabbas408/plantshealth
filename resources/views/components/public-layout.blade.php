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

    <!-- NProgress (The Loader Bar) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.css" />

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

    <!-- Google Analytics (GA4) -->
    @if (config('services.google.analytics_id'))
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ config('services.google.analytics_id') }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());

            // Config sends the Page View automatically
            gtag('config', '{{ config('services.google.analytics_id') }}');
        </script>
    @endif

    <style>
        .font-urdu {
            font-family: 'Noto Nastaliq Urdu', serif;
            line-height: 2;
        }


        /* NProgress Color Customization */
        #nprogress .bar {
            background: #d97706 !important;
            /* Brand Gold */
            height: 3px !important;
            /* Make it slightly thicker */
        }

        /* The glowing spinner (optional, usually hidden for top bars) */
        #nprogress .peg {
            box-shadow: 0 0 10px #d97706, 0 0 5px #d97706;
        }

        /* Hide the spinner circle on the right if you only want the bar */
        #nprogress .spinner {
            display: none;
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
    <x-toast />
    <!-- SCROLL TO TOP BUTTON -->
    <button id="scrollToTopBtn" onclick="scrollToTop()"
        class="fixed bottom-8 right-8 z-50 bg-brand-green text-white p-3 rounded-full shadow-lg transition-all duration-300 opacity-0 invisible hover:bg-green-800 hover:-translate-y-1 focus:outline-none"
        title="Go to top">
        <!-- Arrow Up Icon -->
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
        </svg>
    </button>
    <!-- GLOBAL DELETE MODAL -->
    <div id="delete-modal" class="fixed inset-0 z-[60] hidden">
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-gray-900 bg-opacity-50 backdrop-blur-sm transition-opacity"
            onclick="closeDeleteModal()"></div>

        <!-- Modal Content -->
        <div
            class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white rounded-xl shadow-2xl p-8 max-w-sm w-full border border-gray-100 text-center">

            <!-- Warning Icon -->
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>

            <!-- Title (Dynamic) -->
            <h3 id="modal-title" class="text-xl font-bold text-gray-900 mb-2">Delete Item?</h3>

            <!-- Description (Dynamic) -->
            <p id="modal-desc" class="text-gray-500 mb-8 text-sm leading-relaxed">
                Are you sure you want to delete this? This action cannot be undone.
            </p>

            <div class="flex justify-center gap-3">
                <!-- Cancel Button -->
                <button type="button" onclick="closeDeleteModal()"
                    class="px-5 py-2.5 rounded-full text-gray-700 bg-gray-100 hover:bg-gray-200 font-medium transition text-sm">
                    Cancel
                </button>

                <!-- Delete Form (Action updated via JS) -->
                <form id="delete-form" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="px-5 py-2.5 rounded-full bg-red-600 text-white font-bold hover:bg-red-700 transition text-sm shadow-lg shadow-red-200">
                        Yes, Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
    <script>
        function openDeleteModal(actionUrl, title = 'Delete Item?', desc = 'Are you sure? This cannot be undone.') {
            // 1. Update the Form Action URL
            document.getElementById('delete-form').action = actionUrl;

            // 2. Update the Text
            document.getElementById('modal-title').innerText = title;
            document.getElementById('modal-desc').innerText = desc;

            // 3. Show the Modal
            document.getElementById('delete-modal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('delete-modal').classList.add('hidden');
        }

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

    <script>
        // 1. Configure NProgress
        NProgress.configure({
            showSpinner: false,
            speed: 500
        });

        // 2. Trigger on Page Load (Finish the animation)
        // This runs when the new page is fully ready
        window.addEventListener('load', function() {
            NProgress.done();
        });

        // 3. Trigger on Link Click (Start the animation)
        // This gives the illusion of speed before the browser actually switches pages
        document.addEventListener('click', function(e) {
            var target = e.target.closest('a');

            // If clicked on a valid link
            if (target && target.getAttribute('href') &&
                !target.getAttribute('href').startsWith('#') &&
                !target.getAttribute('target')) {

                NProgress.start();
            }
        });

        // 4. Handle Back/Forward Browser Buttons
        // This ensures the bar stops if the user hits the back button
        window.addEventListener('pageshow', function(event) {
            if (event.persisted) {
                NProgress.done();
            }
        });
    </script>

    <!-- Backend Event Tracking -->
    @if (session('success') && config('services.google.analytics_id'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                if (typeof gtag === 'function') {
                    gtag('event', 'action_success', {
                        'message': '{{ session('success') }}'
                    });
                }
            });
        </script>
    @endif


</body>

</html>
