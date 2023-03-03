<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:view_dashboard')->only(['index']);
    }

    public function index()
    {
        return view('admin.dashboard');
    }
}
