<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ExpedientController;
use App\Http\Controllers\ImagesController;
use App\Http\Controllers\MachineryController;
use App\Http\Controllers\OrganizationsController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\RequirementController;
use App\Http\Controllers\TemplateController;
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

Route::get('simulador', [DashboardController::class, 'showSimulator'])
    ->name('simulator')
    ->middleware('guest');


// Dashboard

// Route::get('/', [DashboardController::class, 'index'])
//     ->name('dashboard')
//     ->middleware('auth');
Route::get('/', [ExpedientController::class, 'index'])->middleware('auth');

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

// Requirements
Route::prefix('requirements')->name('requirements')->middleware('auth', 'role:owner')->group(function () {
    Route::get('/', [RequirementController::class, 'index'])->middleware('remember');
    Route::get('/create', [RequirementController::class, 'create'])->name('.create');
    Route::post('/', [RequirementController::class, 'store'])->name('.store');
    Route::get('/{requirement}/edit', [RequirementController::class, 'edit'])->name('.edit');
    Route::put('/{requirement}', [RequirementController::class, 'update'])->name('.update');
    Route::delete('/{requirement}', [RequirementController::class, 'destroy'])->name('.destroy');
    Route::put('/{requirement}/restore', [RequirementController::class, 'restore'])->name('.restore');
});
// Templates
Route::prefix('templates')->name('templates')->middleware('auth', 'role:owner')->group(function () {
    Route::get('/', [TemplateController::class, 'index'])->middleware('remember');
    Route::get('/create', [TemplateController::class, 'create'])->name('.create');
    Route::post('/', [TemplateController::class, 'store'])->name('.store');
    Route::get('/{template}/edit', [TemplateController::class, 'edit'])->name('.edit');
    Route::put('/{template}', [TemplateController::class, 'update'])->name('.update');
    Route::delete('/{template}', [TemplateController::class, 'destroy'])->name('.destroy');
    Route::put('/{template}/restore', [TemplateController::class, 'restore'])->name('.restore');
});

// Expedients
Route::prefix('expedients')->name('expedients')->middleware('auth')->group(function () {
    Route::get('/', [ExpedientController::class, 'index'])->middleware('remember');
    Route::get('/{expedient}/show', [ExpedientController::class, 'show'])->name('.show');
    Route::get('/create', [ExpedientController::class, 'create'])->name('.create');
    Route::post('/', [ExpedientController::class, 'store'])->name('.store');
    Route::get('/{expedient}/documents', [ExpedientController::class, 'documents'])->name('.documents');
    Route::get('/{expedient}/edit', [ExpedientController::class, 'edit'])->name('.edit');
    Route::put('/{expedient}', [ExpedientController::class, 'update'])->name('.update');
    Route::delete('/{expedient}', [ExpedientController::class, 'destroy'])->name('.destroy');
    Route::put('/{expedient}/restore', [ExpedientController::class, 'restore'])->name('.restore');
    Route::put('/{expedient}/addRequirement', [ExpedientController::class, 'addRequirement'])->name('.addRequirement');
});

// Documents
Route::prefix('documents')->name('documents')->middleware('auth')->group(
    function () {
        Route::get('/', [DocumentController::class, 'index'])->middleware('remember');
        Route::put('/{document}/update', [DocumentController::class, 'update'])->name('.update');
        Route::get('/{document}/downloadFilesZip', [DocumentController::class, 'downloadFilesZip'])->name('.downloadFilesZip');
        Route::put('/{document}/uploadFiles', [DocumentController::class, 'uploadFiles'])->name('.uploadFiles');
        Route::delete('/{file}/deleteFile', [DocumentController::class, 'deleteFile'])->name('.deleteFile');
    }
);
// Machinery
Route::prefix('machineries')->name('machineries')->middleware('auth', 'role:owner')->group(
    function () {
        Route::get('/', [MachineryController::class, 'index'])->middleware('remember');
        Route::get('/create', [MachineryController::class, 'create'])->name('.create');
        Route::post('/', [MachineryController::class, 'store'])->name('.store');
        Route::get('/{machinery}/edit', [MachineryController::class, 'edit'])->name('.edit');
        Route::put('/{machinery}', [MachineryController::class, 'update'])->name('.update');
        Route::delete('/{machinery}', [MachineryController::class, 'destroy'])->name('.destroy');
        Route::put('/{machinery}/restore', [MachineryController::class, 'restore'])->name('.restore');
    }
);

// Images

Route::get('/img/{path}', [ImagesController::class, 'show'])->where('path', '.*');
Route::get('/files/{path}', [ImagesController::class, 'files'])->where('path', '.*');

// 500 error

// Route::get('500', function () {
//     // Force debug mode for this endpoint in the demo environment
//     if (App::environment('demo')) {
//         Config::set('app.debug', true);
//     }

//     echo $fail;
// });
