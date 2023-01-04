<?php

namespace App\Http\Controllers\frontend;

use App\Models\Plan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommitteeController extends Controller
{
    public function index()
    {
        $plans = Plan::committee()->whereStatus('active')->get();
        $title = 'Committee Plans';
        return view('frontend.plans.index', compact('plans', 'title'));
    }
}
