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

        // If a specific barangay is selected, filter by it; otherwise, get all people
        $people = Person::query();

        if ($barangayId) {
            // Get people from the selected barangay
            $people->where('barangay_id', $barangayId);
        }

        // Order by last_name in alphabetical order (A-Z)
        $people = $people->orderBy('last_name')->get();

        // Return a view to display or generate a report
        return view('reports.people', compact('people'));
    }
}
