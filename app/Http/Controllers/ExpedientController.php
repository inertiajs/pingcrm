<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class ExpedientController extends Controller
{
    public function index()
    {
        return Inertia::render('Expedients/Index');
    }
}
