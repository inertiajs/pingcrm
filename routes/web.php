<?php


use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AddressesController;
use App\Http\Controllers\BanksController;
use App\Http\Controllers\ProfilesController;
use App\Http\Controllers\BudgetsController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\ExperiencesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ImagesController;
use App\Http\Controllers\IssuesController;
use App\Http\Controllers\OrganizationsController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\TasksController;
use App\Http\Controllers\FollowupsController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\DocumentsController;
use App\Http\Controllers\RestaurantsController;
use App\Http\Controllers\EducationsController;
use App\Http\Controllers\HolidaysController;
use App\Http\Controllers\LeavesController;
use App\Http\Controllers\OfficeruleController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\RuleCategoryController;
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


// RuleCategory

Route::get('rulecategory', [RuleCategoryController::class, 'index'])
->name('rulecategory')
->middleware('remember', 'auth');

Route::get('rulecategory/create', [RuleCategoryController::class, 'create'])
->name('rulecategory.create')
->middleware('auth');

Route::post('rulecategory', [RuleCategoryController::class, 'store'])
->name('rulecategory.store')
->middleware('auth');

Route::get('rulecategory/{rulecategory}/edit', [RuleCategoryController::class, 'edit'])
->name('rulecategory.edit')
->middleware('auth');

Route::put('rulecategory/{rulecategory}', [RuleCategoryController::class, 'update'])
->name('rulecategory.update')
->middleware('auth');

Route::delete('rulecategory/{rulecategory}', [RuleCategoryController::class, 'destroy'])
->name('rulecategory.destroy')
->middleware('auth');

Route::put('rulecategory/{rulecategory}/restore', [RuleCategoryController::class, 'restore'])
->name('rulecategory.restore')
->middleware('auth');

// Organizations

Route::get('organizations', [OrganizationsController::class, 'index'])
    ->name('organizations')
    ->middleware('auth');



// Leaves

Route::get('leaves',[LeavesController::class, 'index'])
    ->name('leaves')
    ->middleware('remember', 'auth');


Route::get('leaves/create', [LeavesController::class, 'create'])
    ->name('leaves.create')
    ->middleware('auth');

Route::post('leaves', [LeavesController::class, 'store'])
    ->name('leaves.store')
    ->middleware('auth');

Route::get('leaves/{leave}/edit', [LeavesController::class, 'edit'])
    ->name('leaves.edit')
    ->middleware('auth');

Route::put('leaves/{leave}', [LeavesController::class, 'update'])
    ->name('leaves.update')
    ->middleware('auth');

Route::delete('leaves/{leave}', [LeavesController::class, 'destroy'])
    ->name('leaves.destroy')
    ->middleware('auth');

Route::put('leaves/{leave}/restore', [LeavesController::class, 'restore'])
    ->name('leaves.restore')
    ->middleware('auth');



// Holidays

Route::get('holidays', [HolidaysController::class, 'index'])
    ->name('holidays')
    ->middleware('remember', 'auth');

Route::get('holidays/create', [HolidaysController::class, 'create'])
    ->name('holidays.create')
    ->middleware('auth');

Route::post('holidays', [HolidaysController::class, 'store'])
    ->name('holidays.store')
    ->middleware('auth');

Route::get('holidays/{holiday}/edit', [HolidaysController::class, 'edit'])
    ->name('holidays.edit')
    ->middleware('auth');

Route::put('holidays/{holiday}', [HolidaysController::class, 'update'])
    ->name('holidays.update')
    ->middleware('auth');

Route::delete('holidays/{holiday}', [HolidaysController::class, 'destroy'])
    ->name('holidays.destroy')
    ->middleware('auth');

Route::put('holidays/{holiday}/restore', [HolidaysController::class, 'restore'])
    ->name('holidays.restore')
    ->middleware('auth');

// Companys

Route::get('companys', [CompanysController::class, 'index'])
    ->name('companys')
    ->middleware('remember', 'auth');

Route::get('companys/create', [CompanysController::class, 'create'])
    ->name('companys.create')
    ->middleware('auth');

Route::post('companys', [CompanysController::class, 'store'])
    ->name('companys.store')
    ->middleware('auth');

Route::get('companys/{company}/edit', [CompanysController::class, 'edit'])
    ->name('organizations.edit')
    ->middleware('auth');

Route::put('companys/{company}', [CompanysController::class, 'update'])
    ->name('companys.update')
    ->middleware('auth');

Route::delete('companys/{company}', [CompanysController::class, 'destroy'])
    ->name('companys.destroy')
    ->middleware('auth');

Route::put('companys/{company}/restore', [CompanysController::class, 'restore'])
    ->name('companys.restore')
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

// Officerule

Route::get('officerule', [OfficeRuleController::class, 'index'])
    ->name('officerule')
    ->middleware('remember', 'auth');

Route::get('officerule/create', [OfficeRuleController::class, 'create'])
    ->name('officerule.create')
    ->middleware('auth');

Route::post('officerule', [OfficeRuleController::class, 'store'])
    ->name('officerule.store')
    ->middleware('auth');

Route::get('officerule/{officerule}/edit', [OfficeRuleController::class, 'edit'])
    ->name('officerule.edit')
    ->middleware('auth');

Route::put('officerule/{officerule}', [OfficeRuleController::class, 'update'])
    ->name('officerule.update')
    ->middleware('auth');

Route::delete('officerule/{officerule}', [OfficeRuleController::class, 'destroy'])
    ->name('officerule.destroy')
    ->middleware('auth');

Route::put('officerule/{officerule}/restore', [OfficeRuleController::class, 'restore'])
    ->name('officerule.restore')
    ->middleware('auth');

// Followups

Route::get('followups', [FollowupsController::class, 'index'])
->name('followups')
->middleware('remember', 'auth');

Route::get('followups/create', [FollowupsController::class, 'create'])
->name('followups.create')
->middleware('auth');

Route::post('followups', [FollowupsController::class, 'store'])
->name('followups.store')
->middleware('auth');

Route::get('followups/{followup}/edit', [FollowupsController::class, 'edit'])
->name('followups.edit')
->middleware('auth');

Route::put('followups/{followup}', [FollowupsController::class, 'update'])
->name('followups.update')
->middleware('auth');

Route::delete('followups/{followup}', [FollowupsController::class, 'destroy'])
->name('followups.destroy')
->middleware('auth');

Route::put('followups/{followup}/restore', [FollowupsController::class, 'restore'])
->name('followups.restore')
->middleware('auth');

// Comments

Route::get('comments', [CommentsController::class, 'index'])
    ->name('comments')
    ->middleware('remember', 'auth');

Route::get('comments/create', [CommentsController::class, 'create'])
    ->name('comments.create')
    ->middleware('auth');

Route::post('comments', [CommentsController::class, 'store'])
    ->name('comments.store')
    ->middleware('auth');

Route::get('comments/{comment}/edit', [CommentsController::class, 'edit'])
    ->name('comments.edit')
    ->middleware('auth');

Route::put('comments/{comment}', [CommentsController::class, 'update'])
    ->name('comments.update')
    ->middleware('auth');

Route::delete('comments/{comment}', [CommentsController::class, 'destroy'])
    ->name('comments.destroy')
    ->middleware('auth');

Route::put('comments/{comment}/restore', [CommentsController::class, 'restore'])
->name('comments.restore')
->middleware('auth');

// Experiences

Route::get('experiences', [ExperiencesController::class, 'index'])
    ->name('experiences')
    ->middleware('remember', 'auth');

Route::get('experiences/create', [ExperiencesController::class, 'create'])
    ->name('experiences.create')
    ->middleware('auth');

Route::post('experiences', [ExperiencesController::class, 'store'])
    ->name('experiences.store')
    ->middleware('auth');

Route::get('experiences/{experience}/edit', [ExperiencesController::class, 'edit'])
    ->name('experiences.edit')
    ->middleware('auth');

Route::put('experiences/{experience}', [ExperiencesController::class, 'update'])
    ->name('experiences.update')
    ->middleware('auth');

Route::delete('experiences/{experience}', [ExperiencesController::class, 'destroy'])
    ->name('experiences.destroy')
    ->middleware('auth');

Route::put('experiences/{experience}/restore', [ExperiencesController::class, 'restore'])
->name('experiences.restore')
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

// Budget

Route::get('budgets', [BudgetsController::class, 'index'])
->name('budgets')
->middleware('remember', 'auth');

Route::get('budgets/create', [BudgetsController::class, 'create'])
->name('budgets.create')
->middleware('auth');

Route::post('budgets', [BudgetsController::class, 'store'])
->name('budgets.store')
->middleware('auth');

Route::get('budgets/{budget}/edit', [BudgetsController::class, 'edit'])
->name('budgets.edit')
->middleware('auth');

Route::put('budgets/{budget}', [BudgetsController::class, 'update'])
->name('budgets.update')
->middleware('auth');

Route::delete('budgets/{budget}', [BudgetsController::class, 'destroy'])
->name('budgets.destroy')
->middleware('auth');

Route::put('budgets/{budget}/restore', [BudgetsController::class, 'restore'])
->name('budgets.restore')
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

// profiles

Route::get('profiles', [ProfilesController::class, 'index'])
->name('profiles')
->middleware('remember', 'auth');

Route::get('profiles/create', [ProfilesController::class, 'create'])
->name('profiles.create')
->middleware('auth');

Route::post('profiles', [ProfilesController::class, 'store'])
->name('profiles.store')
->middleware('auth');

Route::get('profiles/{profile}/edit', [ProfilesController::class, 'edit'])
->name('profiles.edit')
->middleware('auth');

Route::put('profiles/{profile}', [ProfilesController::class, 'update'])
->name('profiles.update')
->middleware('auth');

Route::delete('profiles/{profile}', [ProfilesController::class, 'destroy'])
->name('profiles.destroy')
->middleware('auth');

Route::put('profiles/{profile}/restore', [ProfilesController::class, 'restore'])
->name('profiles.restore')
->middleware('auth');

// budgets

Route::get('budgets', [BudgetsController::class, 'index'])
->name('budgets')
->middleware('remember', 'auth');

Route::get('budgets/create', [BudgetsController::class, 'create'])
->name('budgets.create')
->middleware('auth');

Route::post('budgets', [BudgetsController::class, 'store'])
->name('budgets.store')
->middleware('auth');

Route::get('budgets/{budget}/edit', [BudgetsController::class, 'edit'])
->name('budgets.edit')
->middleware('auth');

Route::put('budgets/{budget}', [BudgetsController::class, 'update'])
->name('budgets.update')
->middleware('auth');

Route::delete('budgets/{budget}', [BudgetsController::class, 'destroy'])
->name('budgets.destroy')
->middleware('auth');

Route::put('budgets/{budget}/restore', [BudgetsController::class, 'restore'])
->name('budgets.restore')
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
