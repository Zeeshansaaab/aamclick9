<?php

namespace App\Http\Controllers\FrontEnd;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Blade;

class UserController extends Controller
{
    public function referrals($level)
    {
        return view('frontend.user.referrals', compact('level'));
    }

    public function loadReferralTable($level)
    {
        $limit = \config()->get('settings.pagination_limit');
        $users = User::query();
        if($level == 1){
            $users->where('ref_by', auth()->user()->id);
        }
        if($level == 2){
            $users->whereHas('refBy', function($query){
                $query->where('ref_by', 1);
            });
        }
        if($level == 3){
            $users->whereHas('refBy', function($query){
                $query->whereHas('refBy', function($query){
                    $query->where('ref_by', 1);
                });
            });
        }
        if($level == 4){
            $users->whereHas('refBy', function($query){
                $query->whereHas('refBy', function($query){
                    $query->whereHas('refBy', function($query){
                        $query->where('ref_by', 1);
                    });
                });
            });
        }
        $users = $users->with('planUser')->withSum('planUser', 'balance')->when(request()->keyword, function ($query) {
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
