<?php

namespace App\Http\Controllers;

use App\Models\Barangay;
use App\Models\Leader;
use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PersonController extends Controller
{
    // Show the form to add a person to a barangay
    public function showAddPersonForm($barangayId)
    {
        $barangay = Barangay::findOrFail($barangayId);
        $leaders = $barangay->leaders; // Fetch the leaders for the barangay

        return view('add-person', compact('barangay', 'leaders'));
    }

    // Store a new person
    public function storePerson(Request $request, $barangayId)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'age' => 'required|integer',
            'birthdate' => 'required|date',
            'purok_no' => 'required|string|max:255',
            'organization' => 'required|string',
            'leader_id' => 'required|exists:leaders,id',
            'status' => 'required|string|in:Uswag (Straight),Mayor Ian (Parallel)',
        ]);

        Person::create([
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'age' => $request->age,
            'birthdate' => $request->birthdate,
            'purok_no' => $request->purok_no,
            'organization' => $request->organization,
            'leader_id' => $request->leader_id,
            'barangay_id' => $barangayId,
            'status' => $request->status, // Ensure this is included
        ]);
        

        return redirect()->route('showPeople', $barangayId)->with('success', 'Person added successfully.');
    }

    // Add a new person (old version, may be deprecated if storePerson is preferred)
    public function addPerson(Request $request, $barangayId)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'age' => 'required|integer|min:0',
            'birthdate' => 'required|date',
            'purok_no' => 'required|string|max:255',
            'organization' => 'required|string|in:Farmers,Women,Senior Citizen,4Ps,Others,N/A',
            'leader_id' => 'required|exists:leaders,id', // Ensure the leader exists
            'status' => 'required|string|in:Uswag (Straight),Mayor Ian (Parallel)',
        ]);

        $existingPerson = DB::table('people')
            ->where('first_name', $request->first_name)
            ->where('middle_name', $request->middle_name)
            ->where('last_name', $request->last_name)
            ->first();

        if ($existingPerson) {
            return redirect()->back()->withErrors(['full_name' => 'This person already exists in a barangay.']);
        }

        Person::create([
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'age' => $request->age,
            'birthdate' => $request->birthdate,
            'purok_no' => $request->purok_no,
            'organization' => $request->organization,
            'leader_id' => $request->leader_id,
            'barangay_id' => $barangayId,
            'status' => $request->status, // Ensure this is included
        ]);
        

        return redirect()->route('showPeople', $barangayId)->with('success', 'Person added successfully!');
    }

    // Search people by name
    public function searchPeople(Request $request)
    {
        $search = $request->input('search');

        $people = DB::table('people')
            ->where('first_name', 'like', $search . '%')
            ->orWhere('last_name', 'like', $search . '%')
            ->get();

        return response()->json($people);
    }


    public function showPeople($barangayId)
    {
        $barangay = Barangay::findOrFail($barangayId);
        $people = Person::where('barangay_id', $barangayId)->get();

        return view('show-people', compact('barangay', 'people'));
    }
    
    
    public function filterPeople(Request $request)
    {
        $leaderId = $request->query('leader_id');
        $purokNo = $request->query('purok_no');
        $organization = $request->query('organization');
        $status = $request->query('status');

        $query = Person::with(['barangay', 'leader']);

        if ($leaderId) {
            $query->where('leader_id', $leaderId);
        }

        if ($purokNo) {
            $query->where('purok_no', $purokNo);
        }

        if ($organization) {
            $query->where('organization', $organization);
        }

        if ($status) {
            $query->where('status', $status);
        }

        $people = $query->get();

        return response()->json($people);
    }
    

    // Get person details
    public function getDetails($id)
    {
        $person = Person::with('barangay', 'leader')->find($id);

        if (!$person) {
            return response()->json(['error' => 'Person not found'], 404);
        }

        return response()->json([
            'first_name' => $person->first_name,
            'middle_name' => $person->middle_name,
            'last_name' => $person->last_name,
            'age' => $person->age,
            'birthdate' => $person->birthdate,
            'purok_no' => $person->purok_no,
            'organization' => $person->organization,
            'leader_id' => $person->leader->name ?? 'N/A',
            'status' => $person->status,
        ]);
    }

    // Show the form to edit person details
    public function editForm($id)
{
    $person = Person::findOrFail($id);
    $barangay = Barangay::findOrFail($person->barangay_id);
    $leaders = $barangay->leaders; // Assuming Barangay has a relationship with Leaders

    return view('edit-person', compact('person', 'barangay', 'leaders'));
}

public function edit(Request $request, $id)
{
    $request->validate([
        'first_name' => 'required|string|max:255',
        'middle_name' => 'nullable|string|max:255',
        'last_name' => 'required|string|max:255',
        'age' => 'required|integer|min:0',
        'birthdate' => 'required|date',
        'purok_no' => 'required|string|max:255',
        'organization' => 'required|string|in:Farmers,Women,Senior Citizen,4Ps,Others,N/A',
        'leader_id' => 'required|exists:leaders,id', // Validate leader exists
        'status' => 'required|string|in:Uswag (Straight),Mayor Ian (Parallel)',
    ]);

    $person = Person::findOrFail($id);
    $person->update([
        'first_name' => $request->first_name,
        'middle_name' => $request->middle_name,
        'last_name' => $request->last_name,
        'age' => $request->age,
        'birthdate' => $request->birthdate,
        'purok_no' => $request->purok_no,
        'organization' => $request->organization,
        'leader_id' => $request->leader_id,
        'status' => $request->status,
    ]);

    return redirect()->route('showPeople', $person->barangay_id)->with('success', 'Person updated successfully!');
}

    // Delete a person
    public function deletePerson($id)
    {
        $person = Person::findOrFail($id);
        $barangayId = $person->barangay_id;
        $person->delete();

        if (request()->ajax()) {
            return response()->json(['success' => 'Person deleted successfully!']);
        }

        return redirect()->route('showPeople', $barangayId)->with('success', 'Person deleted successfully!');
    }
}
