<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" 
      dir="{{ app()->getLocale() == 'ur' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PlantsHealth | Innovations in Agriculture</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=playfair-display:400,700|inter:400,600,700&display=swap" rel="stylesheet" />
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
        .font-urdu { font-family: 'Noto Nastaliq Urdu', serif; line-height: 2; }
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

</body>
</html>