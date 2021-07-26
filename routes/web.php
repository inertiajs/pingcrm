<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ImagesController;
use App\Http\Controllers\OrganizationsController;
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

Route::get('login', [AuthenticatedSessionController::class, 'create'])
    ->name('login')
    ->middleware('guest');

Route::post('login', [AuthenticatedSessionController::class, 'store'])
    ->name('login.store')
    ->middleware('guest');

Route::delete('logout', [AuthenticatedSessionController::class, 'destroy'])
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

    Route::delete('clients/{client}', [ClientsController::class, 'destroy'])
    ->name('clients.destroy')
    ->middleware('auth');

    Route::put('clients/{client}', [ClientsController::class, 'update'])
    ->name('clients.update')
    ->middleware('auth');



// Projects

    Route::get('projects', [ProjectsController::class, 'index'])
        ->name('projects')
        ->middleware('remember', 'auth');

    Route::get('projects/create', [ProjectsController::class, 'create'])
            ->name('projects.create')
            ->middleware('auth');

    // Route::get('projects/create', [ProjectsController::class, 'create'])
    //     ->name('Projects.create')
    //     ->middleware('auth');

    Route::post('projects', [ProjectsController::class, 'store'])
        ->name('projects.store')
        ->middleware('auth');

    Route::get('projects/{project}/edit', [ProjectsController::class, 'edit'])
        ->name('projects.edit')
        ->middleware('auth');

    Route::delete('projects/{project}', [ProjectsController::class, 'destroy'])
            ->name('projects.destroy')
            ->middleware('auth');

    Route::put('projects/{project}', [ProjectsController::class, 'update'])
                ->name('projects.update')
                ->middleware('auth');

    Route::put('projects/{project}/restore', [ProjectsController::class, 'restore'])
                ->name('projects.restore')
                ->middleware('auth');



// Issues

                Route::get('issues', [IssuesController::class, 'index'])
                    ->name('issues')
                    ->middleware('remember', 'auth');

                Route::get('issues/create', [IssuesController::class, 'create'])
                        ->name('issues.create')
                        ->middleware('auth');

                // Route::get('projects/create', [ProjectsController::class, 'create'])
                //     ->name('Projects.create')
                //     ->middleware('auth');

                Route::post('issues', [IssuesController::class, 'store'])
                    ->name('issues.store')
                    ->middleware('auth');

                Route::get('issues/{issue}/edit', [IssuesController::class, 'edit'])
                    ->name('issues.edit')
                    ->middleware('auth');

                Route::delete('issues/{issue}', [IssuesController::class, 'destroy'])
                        ->name('issues.destroy')
                        ->middleware('auth');

                Route::put('issues/{issue}', [IssuesController::class, 'update'])
                            ->name('issues.update')
                            ->middleware('auth');

                Route::put('issues/{issue}/restore', [IssuesController::class, 'restore'])
                            ->name('issues.restore')
                            ->middleware('auth');


// Dashboard

Route::get('/', [DashboardController::class, 'index'])
    ->name('dashboard')
    ->middleware('auth');

// Users

Route::get('users', [UsersController::class, 'index'])
    ->name('users')
    ->middleware('auth');

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
    ->middleware('auth');

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

// Contacts

Route::get('contacts', [ContactsController::class, 'index'])
    ->name('contacts')
    ->middleware('auth');

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

Route::get('/img/{path}', [ImagesController::class, 'show'])
    ->where('path', '.*')
    ->name('image');
