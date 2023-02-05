<?php

use App\Models\Plan;
use App\Models\Setting;
use App\Models\CommissionRecord;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;
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

function getFile($path){
    return asset('storage/' . $path);
}
?>