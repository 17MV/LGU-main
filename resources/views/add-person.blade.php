<!-- resources/views/add-person.blade.php -->

@extends('layouts.app')

@section('title', 'Add Person')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Add Person to Barangay</h1>

<!-- Add Person Form -->
<form action="{{ route('addPerson', $barangay->id) }}" method="POST" class="mt-2">
    @csrf

    <!-- First Name Field -->
    <label for="first_name" class="block text-sm font-bold mb-1">First Name</label>
    <input type="text" name="first_name" id="first_name" placeholder="First Name" required class="border border-black p-2 mb-2 rounded w-full">

    <!-- Middle Name Field -->
    <label for="middle_name" class="block text-sm font-bold mb-1">Middle Name</label>
    <input type="text" name="middle_name" id="middle_name" placeholder="Middle Name" class="border border-black p-2 mb-2 rounded w-full">

    <!-- Last Name Field -->
    <label for="last_name" class="block text-sm font-bold mb-1">Last Name</label>
    <input type="text" name="last_name" id="last_name" placeholder="Last Name" required class="border border-black p-2 mb-2 rounded w-full">

    <!-- Age Field -->
    <label for="age" class="block text-sm font-bold mb-1">Age</label>
    <input type="number" name="age" id="age" placeholder="Age" required class="border border-black p-2 mb-2 rounded w-full">

    <!-- Birthdate Field -->
    <label for="birthdate" class="block text-sm font-bold mb-1">Birthdate</label>
    <input type="date" name="birthdate" id="birthdate" placeholder="Birthdate" required class="border border-black p-2 mb-2 rounded w-full">

    <!-- Purok No. Field -->
    <label for="purok_no" class="block text-sm font-bold mb-1">Purok No.</label>
    <input type="text" name="purok_no" id="purok_no" placeholder="Purok No." required class="border border-black p-2 mb-2 rounded w-full">

    <!-- Organization Field -->
    <label for="organization" class="block text-sm font-bold mb-1">Organization</label>
    <select name="organization" id="organization" required class="border border-black p-2 mb-2 rounded w-full">
        <option value="" disabled selected>Select Organization</option>
        <option value="Farmers">Farmers</option>
        <option value="Women">Women</option>
        <option value="Senior Citizen">Senior Citizen</option>
        <option value="4Ps">4Ps</option>
        <option value="Others">Others</option>
        <option value="N/A">N/A</option>
    </select>

    <!-- Leader Field -->
    <label for="leader_id" class="block text-sm font-bold mb-1">Leader</label>
    <select name="leader_id" id="leader_id" required class="border border-black p-2 mb-2 rounded w-full">
    <option value="" disabled selected>Select Leader</option>
    @foreach ($leaders as $leader)
        <option value="{{ $leader->id }}">{{ $leader->name }}</option>
    @endforeach

    @if ($leaders->isEmpty())
        <option value="" disabled>No leaders available</option>
    @endif
</select>


<!-- Status Field -->
<label for="status" class="block text-sm font-bold mb-1">Status</label>
<select name="status" id="status" required class="border border-gray-300 p-2 mb-2 rounded w-full">
    <option value="" disabled selected>Select Status</option>
    <option value="Uswag (Straight)">Uswag (Straight)</option>
    <option value="Mayor Ian (Parallel)">Mayor Ian (Parallel)</option>
</select>



    <!-- Submit Button (Centered) -->
    <div class="flex justify-center mt-3">
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Add Person</button>
    </div>

    <!-- Validation Errors -->
    @error('first_name')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
    @enderror
    @error('last_name')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
    @enderror
</form>

<!-- Overlay for Warning -->
@if ($errors->has('full_name'))
    <div id="warning-overlay" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg text-center">
            <h2 class="text-2xl font-bold mb-4 text-red-600">Warning</h2>
            <p class="mb-4 text-gray-700">{{ $errors->first('full_name') }}</p>
            <button onclick="closeOverlay()" class="bg-red-500 text-white px-4 py-2 rounded">Close</button>
        </div>
    </div>
@endif

<script>
        // Show overlay if there is a full name error
        @if ($errors->has('full_name'))
            document.getElementById('warning-overlay').style.display = 'flex';
        @endif

        // Close overlay function
        function closeOverlay() {
            document.getElementById('warning-overlay').style.display = 'none';
        }

        // Capitalize the first letter of names
        function capitalizeFirstLetter(event) {
            const input = event.target;
            input.value = input.value
                .toLowerCase()
                .replace(/^\w|\s\w/g, (char) => char.toUpperCase());
        }

        document.getElementById('first_name').addEventListener('input', capitalizeFirstLetter);
        document.getElementById('middle_name').addEventListener('input', capitalizeFirstLetter);
        document.getElementById('last_name').addEventListener('input', capitalizeFirstLetter);
    </script>
@endsection
