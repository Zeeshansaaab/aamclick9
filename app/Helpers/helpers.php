<?php

use App\Enums\Status;
use App\Models\Setting;
use App\Models\CommissionRecord;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\Facades\Image;
use App\Notifications\NotificationManager;

function getRealIP()
{
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

function getTrx($length = 12)
{
    $characters = 'ABCDEFGHJKMNOPQRSTUVWXYZ123456789';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
/*
* Recursive top-down tree traversal example:
* Indent and print child nodes
*/
function getSettings($group = null)
{
    $settings = Cache::get('settings');

    if(!$settings){
        $settings = Setting::all();
    }

    if($group){
        $setting =  $settings->where('group', $group)->values();
    }

    return $setting;
}


function makeDirectory($path)
{
    if (file_exists($path)) return true;
    return mkdir($path, 0755, true);
}

function removeFile($path)
{
    return file_exists($path) && is_file($path) ? @unlink($path) : false;
}
function uploadImage($file, $directory, $size = null, $old = null, $thumb = null)
{
    $location = 'storage/' . $directory;
    $path = makeDirectory($location);
    if (!$path) throw new Exception('File could not been created.');
    if (!empty($old)) {
        removeFile($location . '/' . $old);
        removeFile($location . '/thumb_' . $old);
    }


    // $filename = uniqid() . time() . '.' . $file->getClientOriginalExtension();
    $filename = uniqid() . time() . '.png';


    $image = Image::make($file);


    if (!empty($size)) {
        $size = explode('x', strtolower($size));
        $image->resize($size[0], $size[1]);
    }
    $image->save($location . '/' . $filename);

    if (!empty($thumb)) {
        $thumb = explode('x', $thumb);
        Image::make($file)->resize($thumb[0], $thumb[1])->save($location . '/thumb_' . $filename);
    }
    return $directory . $filename;
}

function cur_text(){
    $settings = getSettings('currency_setting');
    return $settings->where('key', 'cur_text')->first()->value;
}

function currency($currency, $noSymbol = false)
{
    $currency = number_format(($currency), 2, '.', ',');
    if (!$noSymbol) {
        return $currency . ' ' . cur_text();
    }
    return $currency;
}

function getUserId(){
    $user = \App\Models\User::select('uuid')->orderby('id','DESC')->first();
    if($user){
        $id = explode('AAM',$user->uuid)[1];
        if( $id > 99999){
            return "AAM" . $id + 1;
        }
        return "AAM" . sprintf('%05u', $id+1);
    }
    return "AAM00001";
}

function formatDate($date){
    return $date->format('d M D Y');
}
function formatDateTime($date){
    return $date->format('d M D Y h:m');
}

function nameAronnym($name){
    preg_match_all('/(?<=\s|^)\w/iu', $name, $matches);
    return mb_strtoupper(implode('', array_slice($matches[0], 0, 2)));
}

function getFile($path){
    return asset('storage/' . $path);
}

function levelCommission($user, $amount, $commissionType)
{
    $levels = $user->planUser->plan->levels->where('commission_type', $commissionType)->where('percentage', '>', 0)->values();
    $level = 1;
    foreach($levels as $level){
        $referer = $user->refBy()->with('planLevel.plan')->first();
        $plan = $referer->planUser->plan;
        if($referer && $referer->planUser->plan){
            $commissionLevel = $plan->levels()->where('commission_type', $commissionType)
            ->where('percentage', '>', 0)
            ->where('level', $level)->first();
            if($commissionLevel && $commissionLevel->percent > 0){
                $commission = ($amount * $commissionLevel->percent) / 100;
                $referer->planLevel->$commissionType += $commission;
                $referer->planLevel->save();

                $transaction = $referer->transactions()->create([
                    'amount'        => $commission,
                    'charge'        => 0,
                    'trx_type'      => '+',
                    'post_balance'  => $referer->planLevel->$commissionType,
                    'trx'           => getTrx(),
                    'details'       => $commissionLevel->percent . "% profit bonus added",
                    'remark'        => 'referral_commission',
                    'type'          => 'credit',
                    'status'        =>  Status::Active
                ]);

                $referer->commissions()->create([
                    'from_id'         => $user->id,
                    'level'           => $level,
                    'transaction_id'  => $transaction->id
                ]);

                $referer->notify(new NotificationManager([
                    'title'         => 'REFERRAL COMMISSION',
                    'description'   => currency($commission) . " amount is added for level $level referral commission",
                    'redirect_url'  => route('reports.commissions')
                ]));
            }
        }
        $level++;
        $user = $referer;
    }
}

function createTransaction($user, $amount, $details, $remark, $redirect_url = '', $type="credit"){
    $transaction = $user->transactions()->create([
        'amount'        => $amount,
        'charge'        => 0,
        'trx_type'      => $type == "credit" ? '+' : '-',
        'trx'           => getTrx(),
        'details'       => $details,
        'remark'        => $remark,
        'type'          => $type,
        'status'        => Status::Pending
    ]);
    \Illuminate\Support\Facades\Notification::send($user, new NotificationManager([
        'title'         => ucFirst($remark) . " Amount " . currency($transaction->amount) . " is $type",
        'description'   => ucFirst($remark) . " Amount " . currency($transaction->amount) . " is $type",
        'redirect_url'  => $redirect_url . "&keyword=$transaction->trx"
    ]));
}
?>
