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
        $users = auth()->user()->team()->with('planUser')->withSum('planUser', 'balance')->when(request()->keyword, function ($query) {
            $query->where('name', 'LIKE', '%' . request()->keyword . '%');
        })->orderBy('plan_user_sum_balance', 'desc')->paginate($limit);
        return Blade::render('<x-users.users-list :users="$users"/>', ['users' => $users]);
    }

    public function notifications()
    {
        if(request()->is_all == "true"){
            auth()->user()->unreadNotifications->markAsRead();
        }
        $notifications = auth()->user()->unreadNotifications()->limit(request()->limit)->get();
        return Blade::render('<x-notification-list :notifications="$notifications"/>', [
            'notifications' => $notifications
        ]);
    }
    
   
}
