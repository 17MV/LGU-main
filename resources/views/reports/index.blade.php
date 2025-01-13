<!-- resources/views/reports/index.blade.php -->

@extends('layouts.app')

@section('title', 'Reports')

@section('content')
<div class="container mx-auto mt-6">
    <h1 class="text-2xl font-semibold mb-4">Barangay Reports</h1>

    @if($barangays->isEmpty())
        <p>No barangays found.</p>
    @else
        <div class="space-y-6">
            @foreach($barangays as $barangay)
                <div class="bg-white p-4 rounded shadow">
                    <h2 class="text-xl font-semibold">{{ $barangay->name }}</h2>
                    <ul class="mt-2 space-y-2">
                        @forelse($barangay->people as $person)
                            <li>{{ $person->first_name }} {{ $person->middle_name }} {{ $person->last_name }}</li>
                        @empty
                            <p>No people listed for this barangay.</p>
                        @endforelse
                    </ul>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
