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

    <!-- Leader Filter -->
    <select name="leader_id" id="leaderFilter" required class="border border-gray-300 p-2 mb-4 rounded">
        <option value="" selected>All Leaders</option>
        @foreach ($leaders as $leader)
            <option value="{{ $leader->id }}">{{ $leader->name }}</option>
        @endforeach
    </select>

    <div id="printableTable">
        <table class="min-w-full border border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border px-4 py-2">First Name</th>
                    <th class="border px-4 py-2">Middle Name</th>
                    <th class="border px-4 py-2">Last Name</th>
                    <th class="border px-4 py-2">Barangay</th>
                    <th class="border px-4 py-2">Purok No</th>
                    <th class="border px-4 py-2">Leader</th>
                    <th class="border px-4 py-2">Organization</th>
                    <th class="border px-4 py-2">Status</th>
                </tr>
            </thead>
            <tbody id="peopleTable">
                @foreach($people as $person)
                    <tr class="hover:bg-gray-100">
                        <td class="border px-4 py-2">{{ $person->first_name }}</td>
                        <td class="border px-4 py-2">{{ $person->middle_name }}</td>
                        <td class="border px-4 py-2">{{ $person->last_name }}</td>
                        <td class="border px-4 py-2">{{ $person->barangay->name }}</td>
                        <td class="border px-4 py-2">{{ $person->purok_no }}</td>
                        <td class="border px-4 py-2">{{ $person->leader->name ?? 'N/A' }}</td>
                        <td class="border px-4 py-2">{{ $person->organization }}</td>
                        <td class="border px-4 py-2">{{ $person->status }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- JavaScript for Filtering and Printing -->
<script>
    document.getElementById('leaderFilter').addEventListener('change', function() {
        const leaderId = this.value;

        // Fetch filtered results
        fetch(`/reports/people/filter?leader_id=${leaderId}`)
            .then(response => response.json())
            .then(data => {
                const peopleTable = document.getElementById('peopleTable');
                peopleTable.innerHTML = '';

                // Populate table with filtered results
                data.forEach(person => {
                    peopleTable.innerHTML += `
                        <tr class="hover:bg-gray-100">
                            <td class="border px-4 py-2">${person.first_name}</td>
                            <td class="border px-4 py-2">${person.middle_name ?? ''}</td>
                            <td class="border px-4 py-2">${person.last_name}</td>
                            <td class="border px-4 py-2">${person.barangay.name ?? ''}</td>
                            <td class="border px-4 py-2">${person.purok_no}</td>
                            <td class="border px-4 py-2">${person.leader.name ?? 'N/A'}</td>
                            <td class="border px-4 py-2">${person.organization}</td>
                            <td class="border px-4 py-2">${person.status}</td>
                        </tr>
                    `;
                });
            })
            .catch(error => console.error('Error fetching data:', error));
    });

    function printTable() {
        const printContents = document.getElementById('printableTable').innerHTML;
        const originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
        location.reload();
    }
</script>
@endsection
