<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ImagesController;
use App\Http\Controllers\Maintenance\IssueController;
use App\Http\Controllers\Maintenance\PlannedController;
use App\Http\Controllers\OrganizationsController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\UsersController;
use App\Models\Arrondissement;
use App\Models\Commune;
use App\Models\Department;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Auth

Route::get('login', [AuthenticatedSessionController::class, 'create'])
    ->name('login')
    ->middleware('guest');

Route::post('login', [AuthenticatedSessionController::class, 'store'])
    ->name('login.store')
    ->middleware('guest');

Route::delete('logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');

// Dashboard

Route::get('/', [DashboardController::class, 'index'])
    ->name('dashboard')
    ->middleware('auth');

Route::get('/resultats/{area:lib_area}', [DashboardController::class, 'queryResult'])
    ->name('search')
    ->middleware('auth');


Route::get('departments/{department}/communes', function(Department $department) {
    $data = $department->communes()->get(['id', 'lib_com']);
    return response()->json($data);
});

Route::get('communes/{commune}/arrondissements', function(Commune $commune) {
    $data = $commune->arrondissements()->get(['id', 'lib_arr']);
    return response()->json($data);;
});

Route::get('arrondissements/{arrondissement}/areas', function(Arrondissement $arrondissement) {
    $data = $arrondissement->areas()->get(['id', 'lib_area']);
    return response()->json($data);
});
    
Route::middleware('auth')->group(function() {
    Route::resource('agences', OrganizationsController::class)->parameters([
        'agences' => 'organization'
    ]); // Agences
    Route::resource('pannes', IssueController::class)->parameters([
        'pannes' => 'issue'
    ]); // Pannes
    Route::resource('maintenances', PlannedController::class)->parameters([
        'maintenances' => 'issue'
    ]); // Maintainance
    Route::resources([
        'users'=> UsersController::class, // Users
        'contacts'=> ContactsController::class, // Contacts
    ]);

    Route::put('agences/{organization}/restore', [OrganizationsController::class, 'restore'])
        ->name('agences.restore');
    Route::put('contacts/{contact}/restore', [ContactsController::class, 'restore'])
        ->name('contacts.restore');
    Route::put('users/{user}/restore', [UsersController::class, 'restore'])
        ->name('users.restore');
    
    // Reports
    Route::get('reports', [ReportsController::class, 'index'])
        ->name('reports');
});


// Images
Route::get('/img/{path}', [ImagesController::class, 'show'])
    ->where('path', '.*')
    ->name('image');
