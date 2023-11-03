<?php

namespace App\Http\Controllers\Dashboard;
use App\Http\Controllers\Controller;
use Inertia\Inertia;

class ReportsController extends Controller
{
    public function index()
    {
        return Inertia::render('Reports/Index');
    }
}
