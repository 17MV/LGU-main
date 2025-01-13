<!-- resources/views/reports/people.blade.php -->

@extends('layouts.app')

@section('title', 'People Report')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">People Report</h1>

    <!-- Print Button -->
    <div class="mb-4">
        <button onclick="printTable()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Print Report
        </button>
    </div>

    <div id="printableTable">
        <table class="min-w-full border border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border px-4 py-2">First Name</th>
                    <th class="border px-4 py-2">Middle Name</th>
                    <th class="border px-4 py-2">Last Name</th>
                    <th class="border px-4 py-2">Purok No</th>
                    <th class="border px-4 py-2">Organization</th>
                    <th class="border px-4 py-2">Barangay</th>
                </tr>
            </thead>
            <tbody>
                @foreach($people as $person)
                    <tr class="hover:bg-gray-100">
                        <td class="border px-4 py-2">{{ $person->first_name }}</td>
                        <td class="border px-4 py-2">{{ $person->middle_name }}</td>
                        <td class="border px-4 py-2">{{ $person->last_name }}</td>
                        <td class="border px-4 py-2">{{ $person->purok_no }}</td>
                        <td class="border px-4 py-2">{{ $person->organization }}</td>
                        <td class="border px-4 py-2">{{ $person->barangay->name }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- JavaScript for Printing -->
<script>
    function printTable() {
        // Get the table HTML
        const printContents = document.getElementById('printableTable').innerHTML;
        const originalContents = document.body.innerHTML;

        // Replace the body content with table content
        document.body.innerHTML = printContents;

        // Trigger the print dialog
        window.print();

        // Restore original content
        document.body.innerHTML = originalContents;
        location.reload(); // Reload the page to reset any removed JavaScript events
    }
</script>
@endsection
