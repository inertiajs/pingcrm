<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class RequirementController extends Controller
{
    public function index()
    {
        return Inertia::render('Requirements/Index');
    }
}
