<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-screen flex items-center justify-center relative">
    
    <!-- Background Image with Opacity -->
    <div class="absolute inset-0 bg-cover bg-center opacity-70" style="background-image: url('https://i.ytimg.com/vi/MgaO1qAGYTU/maxresdefault.jpg'); z-index: -1;"></div>
    
    <!-- Login Form Container -->
    <div class="w-full max-w-md bg-blue-700 rounded-lg shadow-lg z-10">
        <form action="{{ route('login') }}" method="POST" class="px-8 py-6">
            @csrf
            <h2 class="text-2xl font-bold mb-6 text-center text-white">Login</h2>
            
            <!-- Email Field -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-bold mb-2 text-white">Email:</label>
                <input type="email" name="email" id="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Enter your email" required>
                @error('email')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Password Field -->
            <div class="mb-6">
                <label for="password" class="block text-sm font-bold mb-2 text-white">Password:</label>
                <input type="password" name="password" id="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Enter your password" required>
                @error('password')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Submit Button -->
            <div class="flex items-center justify-center">
                <button type="submit" class="bg-blue-400 hover:bg-blue-900 text-black font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Log In</button>
            </div>
        </form>
    </div>
</body>
</html>
