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

// Auth
Route::get('login')->name('login')->uses('Auth\LoginController@showLoginForm');
Route::post('login')->name('login.attempt')->uses('Auth\LoginController@login');
Route::post('logout')->name('logout')->uses('Auth\LoginController@logout');

// Dashboard
Route::get('/')->name('dashboard')->uses('DashboardController');

Route::group(['middleware' => ['auth']],function(){
    // Users
    Route::get('users')->name('users')->uses('UsersController@index')->middleware('remember');
    Route::get('users/create')->name('users.create')->uses('UsersController@create');
    Route::post('users')->name('users.store')->uses('UsersController@store');
    Route::get('users/{user}/edit')->name('users.edit')->uses('UsersController@edit');
    Route::put('users/{user}')->name('users.update')->uses('UsersController@update');
    Route::delete('users/{user}')->name('users.destroy')->uses('UsersController@destroy');
    Route::put('users/{user}/restore')->name('users.restore')->uses('UsersController@restore');

    // Organizations
    Route::get('organizations')->name('organizations')->uses('OrganizationsController@index')->middleware('remember');
    Route::get('organizations/create')->name('organizations.create')->uses('OrganizationsController@create');
    Route::post('organizations')->name('organizations.store')->uses('OrganizationsController@store');
    Route::get('organizations/{organization}/edit')->name('organizations.edit')->uses('OrganizationsController@edit');
    Route::put('organizations/{organization}')->name('organizations.update')->uses('OrganizationsController@update');
    Route::delete('organizations/{organization}')->name('organizations.destroy')->uses('OrganizationsController@destroy');
    Route::put('organizations/{organization}/restore')->name('organizations.restore')->uses('OrganizationsController@restore');

    // Contacts
    Route::get('contacts')->name('contacts')->uses('ContactsController@index')->middleware('remember');
    Route::get('contacts/create')->name('contacts.create')->uses('ContactsController@create');
    Route::post('contacts')->name('contacts.store')->uses('ContactsController@store');
    Route::get('contacts/{contact}/edit')->name('contacts.edit')->uses('ContactsController@edit');
    Route::put('contacts/{contact}')->name('contacts.update')->uses('ContactsController@update');
    Route::delete('contacts/{contact}')->name('contacts.destroy')->uses('ContactsController@destroy');
    Route::put('contacts/{contact}/restore')->name('contacts.restore')->uses('ContactsController@restore');
});


// Reports
Route::get('reports')->name('reports')->uses('ReportsController');

// 500 error
Route::get('500', function () {
    abort(500);
});
