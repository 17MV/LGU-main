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


    public function generateReport(Request $request)
    {
        $barangayId = $request->input('barangayId');
        $leaderId = $request->input('leader_id');
        $purokNo = $request->input('purok_no');
        $organization = $request->input('organization');
        $status = $request->input('status');
    
        // Fetch all leaders ordered alphabetically
        $leaders = \App\Models\Leader::orderBy('name', 'asc')->get();
    
        // Fetch unique puroks and organizations
        $puroks = Person::distinct()->pluck('purok_no');
        $organizations = Person::distinct()->pluck('organization');
    
        // Prepare query for people
        $query = Person::query()
            ->join('leaders', 'people.leader_id', '=', 'leaders.id') // Join leaders for sorting
            ->with(['barangay', 'leader']) // Include relationships for eager loading
            ->select('people.*'); // Select all columns from people
    
        // Apply filters
        if ($barangayId) {
            $query->where('people.barangay_id', $barangayId); // Specify table name for barangay_id
        }
    
        if ($leaderId) {
            $query->where('people.leader_id', $leaderId); // Specify table name for leader_id
        }
    
        if ($purokNo) {
            $query->where('people.purok_no', $purokNo); // Specify table name for purok_no
        }
    
        if ($organization) {
            $query->where('people.organization', $organization); // Specify table name for organization
        }
    
        if ($status) {
            $query->where('people.status', $status); // Specify table name for status
        }
    
        // Apply consistent sorting
        $query->orderBy('leaders.name', 'asc') // Sort by leader name alphabetically
              ->orderBy('people.last_name', 'asc'); // Sort by person's last name alphabetically
    
        // Execute the query
        $people = $query->get();
    
        // Pass data to the view
        return view('reports.people', compact('people', 'leaders', 'puroks', 'organizations'));
    }
    
    
    

}
