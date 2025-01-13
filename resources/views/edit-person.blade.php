@extends('layouts.app')

@section('title', 'Edit Person')

@section('content')
<div class="container mx-auto mt-6">
    <h1 class="text-2xl font-semibold mb-4">Edit Person</h1>

    <form action="{{ route('editPerson', $person->id) }}" method="POST">
        @csrf
        @method('POST') <!-- Use PATCH if you're updating existing data -->

        <div class="mb-4">
            <label for="first_name" class="block">First Name</label>
            <input type="text" id="first_name" name="first_name" value="{{ old('first_name', $person->first_name) }}" required class="border border-black rounded w-full py-2 px-3" />
            @error('first_name')
                <div class="text-red-500">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="middle_name" class="block">Middle Name</label>
            <input type="text" id="middle_name" name="middle_name" value="{{ old('middle_name', $person->middle_name) }}" class="border border-black rounded w-full py-2 px-3" />
        </div>

        <div class="mb-4">
            <label for="last_name" class="block">Last Name</label>
            <input type="text" id="last_name" name="last_name" value="{{ old('last_name', $person->last_name) }}" required class="border border-black rounded w-full py-2 px-3" />
            @error('last_name')
                <div class="text-red-500">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="age" class="block">Age</label>
            <input type="number" id="age" name="age" value="{{ old('age', $person->age) }}" required class="border border-black rounded w-full py-2 px-3" />
            @error('age')
                <div class="text-red-500">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="birthdate" class="block">Birthdate</label>
            <input type="date" id="birthdate" name="birthdate" value="{{ old('birthdate', $person->birthdate) }}" required class="border border-black rounded w-full py-2 px-3" />
            @error('birthdate')
                <div class="text-red-500">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="purok_no" class="block">Purok No</label>
            <input type="text" id="purok_no" name="purok_no" value="{{ old('purok_no', $person->purok_no) }}" required class="border border-black rounded w-full py-2 px-3" />
            @error('purok_no')
                <div class="text-red-500">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="organization" class="block">Organization</label>
            <select id="organization" name="organization" required class="border border-black rounded w-full py-2 px-3">
                <option value="Farmers" {{ $person->organization == 'Farmers' ? 'selected' : '' }}>Farmers</option>
                <option value="Women" {{ $person->organization == 'Women' ? 'selected' : '' }}>Women</option>
                <option value="Senior Citizen" {{ $person->organization == 'Senior Citizen' ? 'selected' : '' }}>Senior Citizen</option>
                <option value="4Ps" {{ $person->organization == '4Ps' ? 'selected' : '' }}>4Ps</option>
                <option value="Others" {{ $person->organization == 'Others' ? 'selected' : '' }}>Others</option>
                <option value="N/A" {{ $person->organization == 'N/A' ? 'selected' : '' }}>N/A</option>
            </select>
            @error('organization')
                <div class="text-red-500">{{ $message }}</div>
            @enderror
        </div>

        <div class="flex justify-center mt-3">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update Person</button>
        </div>
    </form>
</div>
@endsection
