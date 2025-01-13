<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\LeaderController;

Route::get('/', function () {
    return view('welcome');
});

// Authentication routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Logout route for authenticated users
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/'); // Redirect to welcome page after logout
})->name('logout')->middleware('auth');

// Admin dashboard routes (grouped under 'auth' middleware)
Route::middleware('auth')->group(function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])
        ->name('admin.dashboard');

    Route::post('/admin/store-barangay', [AdminDashboardController::class, 'storeBarangay'])
        ->name('storeBarangay');

    // Show the form to add a person
    Route::get('/add-person/{barangayId}', [PersonController::class, 'showAddPersonForm'])
        ->name('showAddPersonForm');
 // New DELETE route for deleting a person
 Route::delete('/person/{id}', [PersonController::class, 'deletePerson'])->name('person.delete');
Route::delete('/person/{id}', [PersonController::class, 'deletePerson'])->name('person.delete');

    // Handle the form submission for adding a person
    Route::post('/add-person/{barangayId}', [PersonController::class, 'addPerson'])
        ->name('addPerson');
        
    // Show people in a barangay
    Route::get('/barangay/{barangayId}/people', [PersonController::class, 'showPeople'])
        ->name('showPeople');

    Route::get('/search-people', [PersonController::class, 'searchPeople'])->name('searchPeople');
    Route::get('/people/{id}/edit', [PersonController::class, 'editForm'])->name('editPerson');
    Route::post('/people/{id}/edit', [PersonController::class, 'edit'])->name('editPerson.submit');
    Route::get('/people/{id}/details', [PersonController::class, 'getDetails']);
    Route::post('/barangay/{barangayId}/person/store', [PersonController::class, 'storePerson'])->name('storePerson');
 



// Add a route for viewing barangay people with sorting
    Route::get('/generate-report', [ReportController::class, 'generateReport'])->name('generateReport');

    // New route for the Reports page
    Route::get('/reports', [ReportController::class, 'showReports'])->name('reports');

    Route::post('/add-leader', [LeaderController::class, 'store'])->name('addLeader');

    Route::get('/barangay/{barangayId}/add-person', [LeaderController::class, 'showAddPersonForm'])->name('addPersonForm');

    Route::get('/reports/people/filter', [PersonController::class, 'filterPeople'])->name('filterPeople');

});
