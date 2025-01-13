<?php

namespace App\Http\Controllers;

use App\Models\Barangay;
use App\Models\Person;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $barangays = Barangay::all();
        return view('dashboard', compact('barangays'));
    }

    public function storeBarangay(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:barangays,name'
        ]);

        Barangay::create($request->only('name'));
        return redirect()->back()->with('success', 'Barangay added successfully!');
    }

    public function addPerson(Request $request, $barangayId)
    {
        $request->validate([
            'full_name' => 'required',
        ]);

        // Check if a person with the same name already exists in the selected barangay
        $existingPerson = Person::where('barangay_id', $barangayId)
                                ->where('full_name', $request->full_name)
                                ->first();

        if ($existingPerson) {
            return redirect()->back()->withErrors(['full_name' => 'A person with this name already exists in this barangay.']);
        }

        Person::create([
            'barangay_id' => $barangayId,
            'full_name' => $request->full_name,
        ]);

        return redirect()->back()->with('success', 'Person added successfully!');
    }
}
