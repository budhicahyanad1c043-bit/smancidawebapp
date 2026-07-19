<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Setting;

class DashboardController extends Controller
{
    //
    public function index()
    {
        // Berbagi data dasar ke view dashboard
        return view('dashboard.index');
    }

}
