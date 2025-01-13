@extends('layouts.app')

@section('title', 'People in ' . $barangay->name)

@section('content')
<div class="container mx-auto mt-6">
    <h1 class="text-2xl font-semibold mb-4">People in {{ $barangay->name }}</h1>

    <!-- Add Person Button -->
    <div class="mb-4">
        <a href="{{ route('addPerson', $barangay->id) }}" class="bg-blue-700 text-white px-6 py-2 rounded">
            Add Person
        </a>
    </div>
    <div class="mb-4">
        <a href="{{ route('addPerson', $barangay->id) }}" class="bg-blue-700 text-white px-6 py-2 rounded">
            Add Leader
        </a>
    </div>
    @if($people->isEmpty())
        <p>No people found in this barangay.</p>
    @else
        <ul>
            @foreach($people as $person)
            <div class="flex items-center justify-between bg-white border p-4 mb-2 rounded shadow hover:bg-gray-100 transition">
                <li onclick='showPersonDetails({{ $person->id }})' class="cursor-pointer">
                    {{ $person->first_name }} {{ $person->middle_name }} {{ $person->last_name }}
                </li>
                <div class="flex gap-2">
                    <!-- Edit Button -->
                    <a href="{{ route('editPerson', $person->id) }}" class="bg-blue-700 text-white px-3 py-1 rounded">Edit</a>

                    <!-- Delete Button -->
                    <button onclick="showDeleteModal({{ $person->id }}, '{{ $person->first_name }} {{ $person->last_name }}')" class="bg-red-600 text-white px-3 py-1 rounded">
                        Delete
                    </button>
                </div>
            </div>
            @endforeach
        </ul>
    @endif
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 hidden">
    <div class="bg-white p-6 rounded shadow-lg w-96">
        <h2 class="text-lg font-bold mb-4">Confirm Deletion</h2>
        <p id="deleteMessage" class="text-gray-700">Are you sure you want to delete this person?</p>
        <div class="mt-4 flex justify-end gap-2">
            <button onclick="closeDeleteModal()" class="bg-gray-300 text-gray-800 px-6 py-2 rounded w-full sm:w-auto">
                Cancel
            </button>
            <form id="deleteForm" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 text-white px-6 py-2 rounded w-full sm:w-auto">
                    Delete
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Success Modal -->
<div id="successModal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 hidden">
    <div class="bg-white p-6 rounded shadow-lg w-96">
        <h2 class="text-lg font-bold mb-4">Data has been deleted successfully!</h2>
        <div class="mt-4 flex justify-end gap-2">
            <button onclick="closeSuccessModal()" class="bg-blue-600 text-white px-4 py-2 rounded w-full sm:w-auto">Close</button>
        </div>
    </div>
</div>

<!-- Include the person details overlay -->
@include('person-details')

@endsection

<!-- Scripts -->
<script>
function showPersonDetails(personId) {
    // Make an AJAX call to get the person details
    fetch(`/people/${personId}/details`)
        .then(response => response.json())
        .then(person => {
            // Populate the overlay with the person details
            document.getElementById('person-name').textContent = person.first_name + ' ' + (person.middle_name ? person.middle_name + ' ' : '') + person.last_name;

            let details = `Age: ${person.age}<br>
                           Birthdate: ${person.birthdate}<br>
                           Purok No: ${person.purok_no}<br>
                           Organization: ${person.organization}`;
            document.getElementById('person-details').innerHTML = details;

            // Show the overlay
            document.getElementById('person-details-overlay').classList.remove('hidden');
        })
        .catch(error => console.error('Error:', error));
}

function closeOverlay() {
    // Hide the overlay
    document.getElementById('person-details-overlay').classList.add('hidden');
}

function showDeleteModal(personId, personName) {
    // Update modal message
    document.getElementById('deleteMessage').textContent = `Are you sure you want to delete ${personName}?`;

    // Update form action dynamically
    const deleteForm = document.getElementById('deleteForm');
    deleteForm.action = `/person/${personId}`;  // Ensure this matches the route you defined in routes/web.php

    // Show the modal
    document.getElementById('deleteModal').classList.remove('hidden');
}

function closeDeleteModal() {
    // Hide the delete modal
    document.getElementById('deleteModal').classList.add('hidden');
}

// Success Modal Functions
function closeSuccessModal() {
    // Hide the success modal
    document.getElementById('successModal').classList.add('hidden');
}

// Handle the form submission to delete a person
document.getElementById('deleteForm')?.addEventListener('submit', function(e) {
    e.preventDefault();  // Prevent default form submission

    const form = this;

    // Perform AJAX request to delete the person
    fetch(form.action, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: new FormData(form)
    })
    .then(response => {
        if (response.ok) {
            // Close the delete modal and show the success modal
            closeDeleteModal();
            document.getElementById('successModal').classList.remove('hidden');
            
            // Optionally, reload the page after a short delay to reflect the change
            setTimeout(() => {
                window.location.reload();
            }, 2000);
        } else {
            alert('Error deleting person.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
});
</script>
