<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Leader; // Ensure the Leader model is imported

class LeaderController extends Controller
{
    // Store a new leader
    public function store(Request $request)
    {
        $request->validate([
            'barangayId' => 'required|exists:barangays,id',
            'leaderName' => 'required|string|max:255',
        ]);

        $leader = new Leader();
        $leader->barangay_id = $request->barangayId;
        $leader->name = $request->leaderName;
        $leader->save();

        return redirect()->back()->with('success', 'Leader added successfully.');
    }
    public function showAddPersonForm($barangayId)
{
    // Find the barangay by ID
    $barangay = Barangay::findOrFail($barangayId);

    // Fetch leaders for the specific barangay
    $leaders = Leader::where('barangay_id', $barangayId)->get();

    // Pass data to the view
    return view('add-person', compact('barangay', 'leaders'));
}

}
