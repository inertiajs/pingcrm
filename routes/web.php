<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AddressesController;
use App\Http\Controllers\BanksController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ImagesController;
use App\Http\Controllers\OrganizationsController;
use App\Http\Controllers\TasksController;
use App\Http\Controllers\DocumentsController;
use App\Http\Controllers\RestaurantsController;
use App\Http\Controllers\EducationsController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\UsersController;
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

Route::get('login', [LoginController::class, 'showLoginForm'])
    ->name('login')
    ->middleware('guest');

Route::post('login', [LoginController::class, 'login'])
    ->name('login.attempt')
    ->middleware('guest');

Route::post('logout', [LoginController::class, 'logout'])
    ->name('logout');

// Clients

Route::get('clients', [ClientsController::class, 'index'])
    ->name('clients')
    ->middleware('remember', 'auth');

Route::get('clients/create', [ClientsController::class, 'create'])
    ->name('clients.create')
    ->middleware('auth');

Route::post('clients', [ClientsController::class, 'store'])
    ->name('clients.store')
    ->middleware('auth');

Route::get('clients/{client}/edit', [ClientsController::class, 'edit'])
    ->name('clients.edit')
    ->middleware('auth');


// Dashboard

Route::get('/', [DashboardController::class, 'index'])
    ->name('dashboard')
    ->middleware('auth');

// Users

Route::get('users', [UsersController::class, 'index'])
    ->name('users')
    ->middleware('remember', 'auth');

Route::get('users/create', [UsersController::class, 'create'])
    ->name('users.create')
    ->middleware('auth');

Route::post('users', [UsersController::class, 'store'])
    ->name('users.store')
    ->middleware('auth');

Route::get('users/{user}/edit', [UsersController::class, 'edit'])
    ->name('users.edit')
    ->middleware('auth');

Route::put('users/{user}', [UsersController::class, 'update'])
    ->name('users.update')
    ->middleware('auth');

Route::delete('users/{user}', [UsersController::class, 'destroy'])
    ->name('users.destroy')
    ->middleware('auth');

Route::put('users/{user}/restore', [UsersController::class, 'restore'])
    ->name('users.restore')
    ->middleware('auth');

// Organizations

Route::get('organizations', [OrganizationsController::class, 'index'])
    ->name('organizations')
    ->middleware('remember', 'auth');

Route::get('organizations/create', [OrganizationsController::class, 'create'])
    ->name('organizations.create')
    ->middleware('auth');

Route::post('organizations', [OrganizationsController::class, 'store'])
    ->name('organizations.store')
    ->middleware('auth');

Route::get('organizations/{organization}/edit', [OrganizationsController::class, 'edit'])
    ->name('organizations.edit')
    ->middleware('auth');

Route::put('organizations/{organization}', [OrganizationsController::class, 'update'])
    ->name('organizations.update')
    ->middleware('auth');

Route::delete('organizations/{organization}', [OrganizationsController::class, 'destroy'])
    ->name('organizations.destroy')
    ->middleware('auth');

Route::put('organizations/{organization}/restore', [OrganizationsController::class, 'restore'])
    ->name('organizations.restore')
    ->middleware('auth');

// Tasks

Route::get('tasks', [TasksController::class, 'index'])
    ->name('tasks')
    ->middleware('remember', 'auth');

Route::get('tasks/create', [TasksController::class, 'create'])
    ->name('tasks.create')
    ->middleware('auth');

Route::post('tasks', [TasksController::class, 'store'])
    ->name('tasks.store')
    ->middleware('auth');

Route::get('tasks/{task}/edit', [TasksController::class, 'edit'])
    ->name('tasks.edit')
    ->middleware('auth');

Route::put('tasks/{task}', [TasksController::class, 'update'])
    ->name('tasks.update')
    ->middleware('auth');

Route::delete('tasks/{task}', [TasksController::class, 'destroy'])
    ->name('tasks.destroy')
    ->middleware('auth');

Route::put('tasks/{task}/restore', [TasksController::class, 'restore'])
    ->name('tasks.restore')
    ->middleware('auth');

    
// Education

Route::get('educations', [EducationsController::class, 'index'])
->name('educations')
->middleware('remember', 'auth');

Route::get('educations/create', [EducationsController::class, 'create'])
->name('educations.create')
->middleware('auth');

Route::post('educations', [EducationsController::class, 'store'])
->name('educations.store')
->middleware('auth');

Route::get('educations/{education}/edit', [EducationsController::class, 'edit'])
->name('educations.edit')
->middleware('auth');

Route::put('educations/{education}', [EducationsController::class, 'update'])
->name('educations.update')
->middleware('auth');

Route::delete('educations/{education}', [EducationsController::class, 'destroy'])
->name('educations.destroy')
->middleware('auth');

Route::put('educations/{education}/restore', [EducationsController::class, 'restore'])
->name('educations.restore')
->middleware('auth');

// Restaurant

Route::get('restaurants', [RestaurantsController::class, 'index'])
->name('restaurants')
->middleware('remember', 'auth');

Route::get('restaurants/create', [RestaurantsController::class, 'create'])
->name('restaurants.create')
->middleware('auth');

Route::post('restaurants', [RestaurantsController::class, 'store'])
->name('restaurants.store')
->middleware('auth');

Route::get('restaurants/{restaurant}/edit', [RestaurantsController::class, 'edit'])
->name('restaurants.edit')
->middleware('auth');

Route::put('restaurants/{restaurant}', [RestaurantsController::class, 'update'])
->name('educations.update')
->middleware('auth');

Route::delete('restaurants/{restaurant}', [RestaurantsController::class, 'destroy'])
->name('restaurants.destroy')
->middleware('auth');

Route::put('restaurants/{restaurant}/restore', [RestaurantsController::class, 'restore'])
->name('restaurants.restore')
->middleware('auth');

// Document

Route::get('documents', [DocumentsController::class, 'index'])
->name('documents')
->middleware('remember', 'auth');

Route::get('documents/create', [DocumentsController::class, 'create'])
->name('documents.create')
->middleware('auth');

Route::post('documents', [DocumentsController::class, 'store'])
->name('documents.store')
->middleware('auth');

Route::get('documents/{document}/edit', [DocumentsController::class, 'edit'])
->name('documents.edit')
->middleware('auth');

Route::put('documents/{document}', [DocumentsController::class, 'update'])
->name('documents.update')
->middleware('auth');

Route::delete('documents/{document}', [DocumentsController::class, 'destroy'])
->name('documents.destroy')
->middleware('auth');

Route::put('documents/{document}/restore', [DocumentsController::class, 'restore'])
->name('documents.restore')
->middleware('auth');





// Addresses

Route::get('addresses', [AddressesController::class, 'index'])
    ->name('addresses')
    ->middleware('remember', 'auth');

Route::get('addresses/create', [AddressesController::class, 'create'])
    ->name('addresses.create')
    ->middleware('auth');

Route::post('addresses', [AddressesController::class, 'store'])
    ->name('addresses.store')
    ->middleware('auth');

Route::get('addresses/{address}/edit', [AddressesController::class, 'edit'])
    ->name('addresses.edit')
    ->middleware('auth');

Route::put('addresses/{address}', [AddressesController::class, 'update'])
    ->name('addresses.update')
    ->middleware('auth');

Route::delete('addresses/{address}', [AddressesController::class, 'destroy'])
    ->name('addresses.destroy')
    ->middleware('auth');

Route::put('addresses/{address}/restore', [AddressesController::class, 'restore'])
    ->name('addresses.restore')
    ->middleware('auth');


// banks

Route::get('banks', [BanksController::class, 'index'])
->name('banks')
->middleware('remember', 'auth');

Route::get('banks/create', [BanksController::class, 'create'])
->name('banks.create')
->middleware('auth');

Route::post('banks', [BanksController::class, 'store'])
->name('banks.store')
->middleware('auth');

Route::get('banks/{bank}/edit', [BanksController::class, 'edit'])
->name('banks.edit')
->middleware('auth');

Route::put('banks/{bank}', [BanksController::class, 'update'])
->name('banks.update')
->middleware('auth');

Route::delete('banks/{bank}', [BanksController::class, 'destroy'])
->name('banks.destroy')
->middleware('auth');

Route::put('banks/{bank}/restore', [BanksController::class, 'restore'])
->name('banks.restore')
->middleware('auth');


// Contacts

Route::get('contacts', [ContactsController::class, 'index'])
    ->name('contacts')
    ->middleware('remember', 'auth');

Route::get('contacts/create', [ContactsController::class, 'create'])
    ->name('contacts.create')
    ->middleware('auth');

Route::post('contacts', [ContactsController::class, 'store'])
    ->name('contacts.store')
    ->middleware('auth');

Route::get('contacts/{contact}/edit', [ContactsController::class, 'edit'])
    ->name('contacts.edit')
    ->middleware('auth');

Route::put('contacts/{contact}', [ContactsController::class, 'update'])
    ->name('contacts.update')
    ->middleware('auth');

Route::delete('contacts/{contact}', [ContactsController::class, 'destroy'])
    ->name('contacts.destroy')
    ->middleware('auth');

Route::put('contacts/{contact}/restore', [ContactsController::class, 'restore'])
    ->name('contacts.restore')
    ->middleware('auth');

// Reports

Route::get('reports', [ReportsController::class, 'index'])
    ->name('reports')
    ->middleware('auth');

// Images

Route::get('/img/{path}', [ImagesController::class, 'show'])->where('path', '.*');

// 500 error

Route::get('500', function () {
    // Force debug mode for this endpoint in the demo environment
    if (App::environment('demo')) {
        Config::set('app.debug', true);
    }

    echo $fail;
});
