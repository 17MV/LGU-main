<?php

namespace App\Http\Controllers;

use App\Models\Barangay;
use App\Models\Person;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display the list of barangays and their people.
     *
     * @return \Illuminate\View\View
     */
    public function showReports()
    {
        // Fetch all barangays with their related people data
        $barangays = Barangay::with('people')->get();

        // Pass the data to the view
        return view('reports.index', compact('barangays'));
    }

    /**
     * Generate a detailed report for a specific barangay or all barangays.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function generateReport(Request $request)
    {
        $barangayId = $request->input('barangayId');
        $leaderId = $request->input('leader_id');
    
        // Fetch all leaders and order them alphabetically
        $leaders = \App\Models\Leader::orderBy('name')->get();
    
        // Query for people
        $peopleQuery = Person::query();
    
        if ($barangayId) {
            // Filter by barangay if selected
            $peopleQuery->where('barangay_id', $barangayId);
        }
    
        if ($leaderId) {
            // Filter by leader if selected
            $peopleQuery->where('leader_id', $leaderId);
        }
    
        // Order by leader name and then by person's last name
        $people = $peopleQuery
            ->join('leaders', 'people.leader_id', '=', 'leaders.id')
            ->orderBy('leaders.name') // Order by leader name
            ->orderBy('people.last_name') // Then by person's last name
            ->select('people.*') // Select all columns from people
            ->get();
    
        // Pass data to the view
        return view('reports.people', compact('people', 'leaders'));
    }
    

}
