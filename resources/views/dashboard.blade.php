<!-- resources/views/dashboard.blade.php -->

@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container mx-auto p-4 w-full">
    <h1 class="text-2xl font-bold mb-4">Admin Dashboard</h1>

   <!-- Search Input -->
<div class="relative mb-4">
    <input type="text" id="search" placeholder="Search Person..." 
        class="border border-gray-300 p-2 w-80 rounded shadow-sm focus:ring focus:ring-blue-200">
    <!-- Search Results Dropdown -->
    <div id="search-results" 
        class="absolute left-0 w-80 bg-white border border-gray-300 mt-1 rounded shadow-lg hidden z-50">
        <!-- Results will be dynamically populated -->
    </div>
</div>

<div class="flex items-center space-x-4 mb-6">
    <!-- Generate Report Form -->
    <form action="{{ route('generateReport') }}" method="GET" class="flex items-center space-x-2">
        <h2 class="text-l font-semibold mb-0">Generate Report:</h2>
        <select name="barangayId" class="border p-2 rounded shadow-sm">
            <option value="">All Barangay</option>
            @foreach($barangays as $barangay)
                <option value="{{ $barangay->id }}">{{ $barangay->name }}</option>
            @endforeach
        </select>
        <button type="submit" class="bg-blue-700 text-white px-4 py-2 rounded shadow hover:bg-blue-800 transition">
            Generate Report
        </button>
    </form>

    <!-- Add Barangay Form -->
    <form action="{{ route('storeBarangay') }}" method="POST" class="flex items-center space-x-2">
        @csrf
        <h2 class="text-l font-semibold mb-0">Add Barangay:</h2>
        <input type="text" name="name" placeholder="Barangay Name" required
            class="border p-2 rounded shadow-sm " style="text-transform: capitalize;">
        <button type="submit" class="bg-blue-700 text-white px-4 py-2 rounded shadow hover:bg-blue-800 transition">
            Add Barangay
        </button>
    </form>
</div>
 <!-- Add Leader Form -->
 <form action="{{ route('addLeader') }}" method="POST" class="flex items-center space-x-2">
    @csrf
    <h2 class="text-l font-semibold mb-0">Add Leader:</h2>
    <select name="barangayId" required class="border p-2 rounded shadow-sm">
        <option value="" disabled selected>Select Barangay</option>
        @foreach($barangays as $barangay)
            <option value="{{ $barangay->id }}">{{ $barangay->name }}</option>
        @endforeach
    </select>
    <input type="text" name="leaderName" id="leaderName" placeholder="Leader Name" required 
        class="border p-2 rounded shadow-sm" style="text-transform: capitalize;">
    <button type="submit" class="bg-blue-700 text-white px-4 py-2 rounded shadow hover:bg-blue-800 transition">
        Add Leader
    </button>
</form>
<!-- Messages -->
@if (session('success'))
    <div id="success-message" class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4 mt-4">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div id="error-message" class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-4 mt-4">
        {{ session('error') }}
    </div>
@endif

<!-- JavaScript for Auto-Hiding Messages -->
<script>
    // Wait for the DOM to load
    document.addEventListener('DOMContentLoaded', function () {
        // Select the messages
        const successMessage = document.getElementById('success-message');
        const errorMessage = document.getElementById('error-message');

        // Set a timeout to hide success message after 5 seconds
        if (successMessage) {
            setTimeout(() => {
                successMessage.style.display = 'none';
            }, 5000);
        }

        // Set a timeout to hide error message after 5 seconds
        if (errorMessage) {
            setTimeout(() => {
                errorMessage.style.display = 'none';
            }, 4000);
        }
    });
</script>


    <!-- List of Barangays -->
    <div class="mb-6">
        <h2 class="text-xl font-semibold mb-2">Barangays</h2>
        @foreach($barangays as $barangay)
            <div class="flex items-center justify-between bg-white border p-4 mb-2 rounded shadow hover:bg-gray-100 transition">
                <span class="text-lg font-semibold">{{ $barangay->name }}</span>
                <div class="flex space-x-2">
                    <a href="{{ route('showPeople', ['barangayId' => $barangay->id]) }}" class="bg-blue-700 text-white px-4 py-2 rounded shadow hover:bg-blue-800 transition">Show People</a>
                    <a href="{{ route('showAddPersonForm', ['barangayId' => $barangay->id]) }}" class="bg-blue-700 text-white px-4 py-2 rounded shadow hover:bg-blue-800 transition">Add Person</a>
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- Modal -->
<div id="person-details-modal" class="fixed inset-0 hidden bg-gray-800 bg-opacity-50 flex items-center justify-center">
    <div class="bg-white rounded shadow-lg w-96 p-6 relative">
        <button onclick="closeModal()" class="absolute top-2 right-2 text-red-500 font-bold">&times;</button>
        <h2 id="person-modal-name" class="text-xl font-bold mb-4"></h2>
        <div id="person-modal-details" class="text-sm">
            <!-- Details will be populated dynamically -->
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
    $('#search').on('input', function() {
        var searchQuery = $(this).val().trim(); // Trim whitespace

        if (searchQuery.length === 0) {
            $('#search-results').empty().addClass('hidden'); // Hide results if no input
            return;
        }

        $.ajax({
            url: '{{ route("searchPeople") }}',
            method: 'GET',
            data: { search: searchQuery },
            success: function(data) {
                var results = '';
                if (data.length === 0) {
                    results += '<p class="p-2 text-gray-500">No results found</p>';
                } else {
                    data.forEach(function(person) {
                        results += `
                            <div class="p-2 hover:bg-blue-100 cursor-pointer" 
                                onclick="showPersonModal(${person.id})">
                                <span class="block text-black font-medium">${person.first_name} 
                                    ${person.middle_name ? person.middle_name + ' ' : ''}${person.last_name}
                                </span>
                            </div>`;
                    });
                }
                $('#search-results').html(results).removeClass('hidden');
            },
            error: function() {
                $('#search-results').html('<p class="p-2 text-red-500">An error occurred while fetching results.</p>');
            }
        });
    });

    // Hide search results if clicked outside
    $(document).on('click', function(event) {
        if (!$(event.target).closest('#search, #search-results').length) {
            $('#search-results').addClass('hidden');
        }
    });
});


    // Function to fetch and display person details in the modal
    function showPersonModal(personId) {
        fetch(`/people/${personId}/details`)
            .then(response => response.json())
            .then(person => {
                // Populate modal content
                document.getElementById('person-modal-name').textContent = 
                    `${person.first_name} ${person.middle_name ? person.middle_name + ' ' : ''}${person.last_name}`;
                
                document.getElementById('person-modal-details').innerHTML = `
                    <p><strong>Age:</strong> ${person.age}</p>
                    <p><strong>Birthdate:</strong> ${person.birthdate}</p>
                    <p><strong>Purok No.:</strong> ${person.purok_no}</p>
                    <p><strong>Organization:</strong> ${person.organization}</p>
                `;

                // Show modal
                document.getElementById('person-details-modal').classList.remove('hidden');
            })
            .catch(error => console.error('Error fetching person details:', error));
    }

    // Function to close the modal
    function closeModal() {
        document.getElementById('person-details-modal').classList.add('hidden');
    }

            // Capitalize the first letter of names
            function capitalizeFirstLetter(event) {
            const input = event.target;
            input.value = input.value
                .toLowerCase()
                .replace(/^\w|\s\w/g, (char) => char.toUpperCase());
        }

        document.getElementById('leaderName').addEventListener('input', capitalizeFirstLetter);
</script>
@endsection
