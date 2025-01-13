<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel - Log In</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.0/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="relative h-screen">

    <!-- Background Image with Low Opacity -->
    <div class="absolute inset-0 bg-cover bg-center opacity-70" style="background-image: url('https://i.ytimg.com/vi/MgaO1qAGYTU/maxresdefault.jpg'); z-index: -1;"></div>

    <!-- Centered Log In Button -->
    <div class="flex items-center justify-center h-full">
        @if (Route::has('login'))
            <a href="{{ route('login') }}"
               class="bg-blue-900 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Log In
            </a>
        @endif
    </div>
    
</body>
</html>
