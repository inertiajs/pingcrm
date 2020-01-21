<?php

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

Route::middleware('auth')->group(function() {

    // Dashboard (invokable)
    Route::get('/', DashboardController::class)->name('dashboard');

    // Reports (invokable)
    Route::get('reports', ReportsController::class)->name('reports');

    // Users (resource, restorable)
    Route::resource('users', UsersController::class)
        ->names(['index' => 'users'])
    ;
    Route::put('users/{user}/restore', 'UsersController@restore')
        ->name('users.restore')
    ;

    // Organizations (resource, restorable)
    Route::resource('organizations', OrganizationsController::class)
        ->names(['index' => 'organizations'])
    ;
    Route::put('organizations/{organization}/restore', 'OrganizationsController@restore')
        ->name('organizations.restore')
    ;

    // Contacts (resource, restorable)
    Route::resource('contacts', ContactsController::class)
        ->names(['index' => 'contacts'])
    ;
    Route::put('contacts/{contact}/restore', 'ContactsController@restore')
        ->name('contacts.restore')
    ;
});

// Images (invokable)
Route::get('/img/{path}', ImagesController::class)
    ->where('path', '.*')
;
