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

    <!-- Filters -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
        <!-- Leader Filter -->
        <select id="leaderFilter" class="border border-gray-300 p-2 rounded">
            <option value="" selected>All Leaders</option>
            @foreach ($leaders as $leader)
                <option value="{{ $leader->id }}">{{ $leader->name }}</option>
            @endforeach
        </select>

        <!-- Purok Filter -->
        <select id="purokFilter" class="border border-gray-300 p-2 rounded">
            <option value="" selected>All Puroks</option>
            @foreach ($puroks as $purok)
                <option value="{{ $purok }}">{{ $purok }}</option>
            @endforeach
        </select>

        <!-- Organization Filter -->
        <select id="organizationFilter" class="border border-gray-300 p-2 rounded">
            <option value="" selected>All Organizations</option>
            @foreach ($organizations as $organization)
                <option value="{{ $organization }}">{{ $organization }}</option>
            @endforeach
        </select>

        <!-- Status Filter -->
        <select id="statusFilter" class="border border-gray-300 p-2 rounded">
            <option value="" selected>All Statuses</option>
            <option value="Uswag (Straight)">Uswag (Straight)</option>
            <option value="Mayor Ian (Parallel)">Mayor Ian (Parallel)</option>
        </select>
    </div>

    <!-- Table -->
    <div id="printableTable">
        <table class="min-w-full border border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border px-4 py-2">No.</th>
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
                        <td class="border px-4 py-2">{{ $loop->iteration }}</td>
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

<!-- JavaScript -->
<script>
    // Function to apply filters
    function applyFilters() {
        const leaderId = document.getElementById('leaderFilter').value;
        const purokNo = document.getElementById('purokFilter').value;
        const organization = document.getElementById('organizationFilter').value;
        const status = document.getElementById('statusFilter').value;

        fetch(`/reports/people/filter?leader_id=${leaderId}&purok_no=${purokNo}&organization=${organization}&status=${status}`)
            .then(response => response.json())
            .then(data => {
                const peopleTable = document.getElementById('peopleTable');
                peopleTable.innerHTML = '';

                data.forEach((person, index) => {
                    peopleTable.innerHTML += `
                        <tr class="hover:bg-gray-100">
                            <td class="border px-4 py-2">${index + 1}</td>
                            <td class="border px-4 py-2">${person.first_name}</td>
                            <td class="border px-4 py-2">${person.middle_name ?? ''}</td>
                            <td class="border px-4 py-2">${person.last_name}</td>
                            <td class="border px-4 py-2">${person.barangay?.name ?? ''}</td>
                            <td class="border px-4 py-2">${person.purok_no}</td>
                            <td class="border px-4 py-2">${person.leader?.name ?? 'N/A'}</td>
                            <td class="border px-4 py-2">${person.organization}</td>
                            <td class="border px-4 py-2">${person.status}</td>
                        </tr>
                    `;
                });
            })
            .catch(error => console.error('Error fetching data:', error));
    }

    // Attach event listeners to filters
    document.getElementById('leaderFilter').addEventListener('change', applyFilters);
    document.getElementById('purokFilter').addEventListener('change', applyFilters);
    document.getElementById('organizationFilter').addEventListener('change', applyFilters);
    document.getElementById('statusFilter').addEventListener('change', applyFilters);

    // Function to print the table
    function printTable() {
        const printContents = document.getElementById('printableTable').outerHTML;
        const originalContents = document.body.innerHTML;

        document.body.innerHTML = `
            <html>
                <head>
                    <title>Print Report</title>
                    <style>
                        table {
                            width: 100%;
                            border-collapse: collapse;
                        }
                        th, td {
                            border: 1px solid black;
                            padding: 2px;
                            text-align: left;
                        }
                        th {
                            background-color: #f2f2f2;
                        }
                    </style>
                </head>
                <body>
                    ${printContents}
                </body>
            </html>
        `;

        window.print();
        document.body.innerHTML = originalContents;
        location.reload();
    }
</script>
@endsection
