<?php

namespace App\Http\Controllers\FrontEnd;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Blade;

class UserController extends Controller
{
    public function referrals()
    {
        return view('frontend.user.referrals');
    }

    public function loadReferralTable()
    {
        $limit = \config()->get('settings.pagination_limit');
        $users = auth()->user()->referrals()->when(request()->keyword, function ($query) {
            $query->where('name', 'LIKE', '%' . request()->keyword . '%');
        })->latest()->paginate($limit);

        return Blade::render('<x-users-list :users="$users"/>', ['users' => $users]);
    }
    
   
}
