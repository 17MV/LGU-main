<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Leader; // Ensure the Leader model is imported
use App\Models\Barangay; // Import Barangay model

class LeaderController extends Controller
{
    // Store a new leader
    public function store(Request $request)
    {
        $request->validate([
            'barangayId' => 'required|exists:barangays,id',
            'leaderName' => 'required|string|max:255',
        ]);

        // Check if the leader already exists for the selected barangay
        $existingLeader = Leader::where('barangay_id', $request->barangayId)
            ->where('name', $request->leaderName)
            ->first();

        if ($existingLeader) {
            return redirect()->back()->with('error', 'This leader already exists for the selected barangay.');
        }

        // Create a new leader
        $leader = new Leader();
        $leader->barangay_id = $request->barangayId;
        $leader->name = $request->leaderName;
        $leader->save();

        return redirect()->back()->with('success', 'Leader added successfully.');
    }

    // Show add person form
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
