<?php
use App\Http\Controllers\EloquentController;


Route::get('eloquent', [EloquentController::class, 'index'])
    ->name('eloquent')
    ->middleware('remember', 'auth');