<?php

namespace App\Http\Controllers\FrontEnd;

use App\Models\Plan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PlanController extends Controller
{
    public function index()
    {
        $plans = Plan::default()->whereStatus('active')->orderBy('min_price', 'asc')->get();
        return view('frontend.plans.index', compact('plans', 'title'));
    }

}
