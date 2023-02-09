<?php

namespace App\Traits;

use Exception;
use App\Models\LoginLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

trait LoginLogTrait{
    public static function getIp(){
        $ip = $_SERVER["REMOTE_ADDR"];
        //Deep detect ip
        if (filter_var(@$_SERVER['HTTP_FORWARDED'], FILTER_VALIDATE_IP)) {
            $ip = $_SERVER['HTTP_FORWARDED'];
        }
        if (filter_var(@$_SERVER['HTTP_FORWARDED_FOR'], FILTER_VALIDATE_IP)) {
            $ip = $_SERVER['HTTP_FORWARDED_FOR'];
        }
        if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP)) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP)) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
        if (filter_var(@$_SERVER['HTTP_X_REAL_IP'], FILTER_VALIDATE_IP)) {
            $ip = $_SERVER['HTTP_X_REAL_IP'];
        }
        if (filter_var(@$_SERVER['HTTP_CF_CONNECTING_IP'], FILTER_VALIDATE_IP)) {
            $ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
        }
        if ($ip == '::1') {
            $ip = '127.0.0.1';
        }

        return $ip;
    }

    public function createLoginLog($user){
        
        try{
            DB::beginTransaction();
            $ip = self::getIp();
            $info = json_decode(json_encode(ClientInfo::ipInfo()), true);
            $browserInfo = ClientInfo::osBrowser();
            $log = LoginLog::updateOrCreate(['ip' => $ip, 'user_id' => $user->id], [
                'city'          => @implode(',',$info['city']),
                'country'       => @implode(',', $info['country']),
                'country_code'  => @implode(',',$info['code']),
                'longitude'     => @implode(',',$info['long']),
                'latitude'      => @implode(',',$info['lat']),
                'browser'       => @$browserInfo['browser'],
                'os'            => @$browserInfo['os_platform'],
            ]);
            DB::commit();
        } catch(Exception $e){
            DB::rollBack();
            Auth::guard('web')->logout();
            request()->session()->invalidate();
            request()->session()->regenerateToken();
            return redirect()->back()->withErrors([
                'message' => $e->getMessage()
            ]);
        }
    }
}