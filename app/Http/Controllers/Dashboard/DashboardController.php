<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {

        return Inertia::render('Dashboard/Index',[
            'organizations' => Auth::user()->account->organizations()->count(),
            'customers' => Auth::user()->account->contacts()->count(),
            'users' =>Auth::user()->account->users()->count(),
            'reports' => 0
        ]);
    }
}
