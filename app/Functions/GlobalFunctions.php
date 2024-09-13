<?php

use App\Models\Category;
use App\Models\Label;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

function getAuthUser($type)
{
    return Auth::guard($type)->user();
}

function getConstant($key)
{
    return Config::get('constants.'.$key);
}

function getPath($path)
{
    if($path == 'admin'){
        return asset('assets/admin');
    }
    if($path == 'web'){
        return asset('assets/web');
    }
    return asset('assets');
}

function getPublicPathConstant($key)
{
    return public_path(Config::get('constants.'.$key)).'/';
}


function getCategories()
{
    return Category::all();
}

function getLabels($id = '')
{
    if($id){
        return Label::whereCategoryId($id)->get();
    }
    return Label::whereStatus('active')->get();
}

function generateOrderNumber()
{
    return 'ORD-' . mt_rand(1000, 9999) . '-' . mt_rand(1000, 9999);
}

function generateRandomPassword($length = 8) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    $charLength = strlen($characters);
    $password = '';
    for ($i = 0; $i < $length; $i++) {
        $randomIndex = mt_rand(0, $charLength - 1);
        $password .= $characters[$randomIndex];
    }

    return $password;
}

function formatNumber($number)
{
    return number_format($number, 0, '.', ',');
}
