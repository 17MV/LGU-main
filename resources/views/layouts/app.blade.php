<!-- resources/views/layouts/app.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.0/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
    <style>
        /* Ensure sidebar stays fixed while content scrolls */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 16.6667%; /* Same as w-1/6 in Tailwind */
            height: 100%;
            background-color: #1e3a8a; /* Tailwind's blue-900 */
            color: white;
            padding: 1rem;
            z-index: 10; /* Ensure it's above other content */
        }

        /* Adjust main content to prevent overlapping with fixed sidebar */
        .main-content {
            margin-left: 16.6667%; /* Same as sidebar width */
            padding: 1.5rem;
            width: 83.3333%; /* Remaining width for the main content */
            overflow-y: auto; /* Ensure scrolling on content */
            height: 100vh; /* Full viewport height */
        }

        /* Modal styles
        #logout-modal {
            display: none;
        } */
    </style>
</head>
<body class="bg-gray-100">

    <div class="flex">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="mb-6 text-center">
                <img src="https://cmci.dti.gov.ph/img/seals/lgu/San%20Miguel%20(BL).png" alt="Admin Logo" class="w-24 h-24 mx-auto mb-4 rounded-full">
                <h2 class="text-2xl font-bold">Admin Menu</h2>
            </div>
            <ul class="space-y-2">
                <li><a href="{{ route('admin.dashboard') }}" class="block px-2 py-1 hover:bg-blue-700 rounded">Dashboard</a></li>
                <li><a href="{{ route('reports') }}" class="block px-2 py-1 hover:bg-blue-700 rounded">Reports</a></li>
                <!-- <li><a href="{{ route('showAddPersonForm', 1) }}" class="block px-2 py-1 hover:bg-blue-700 rounded">Add Person</a></li> -->
                <!-- Additional links can be added here -->
            </ul>

            <!-- Log Out Button -->
            <button onclick="openLogoutModal()" class="mt-4 block w-full px-2 py-2 text-left text-white">
                Log Out
            </button>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            @yield('content')
        </div>
    </div>

    <!-- Logout Confirmation Modal -->
    <div id="logout-modal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 hidden">
        <div class="bg-white rounded-lg shadow-lg p-6 w-1/3">
            <h2 class="text-xl font-semibold mb-4">Are you sure you want to log out?</h2>
            <div class="flex justify-end space-x-4">
                <button onclick="closeLogoutModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">Cancel</button>
                <button onclick="confirmLogout()" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">Yes</button>
            </div>
        </div>
    </div>

    <!-- JavaScript for modal functionality -->
    <script>
        function openLogoutModal() {
            document.getElementById('logout-modal').classList.remove('hidden');
        }

        function closeLogoutModal() {
            document.getElementById('logout-modal').classList.add('hidden');
        }

        function confirmLogout() {
            document.getElementById('logout-form').submit();
        }
    </script>

    <!-- Hidden form for logout request -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
</body>
</html>
