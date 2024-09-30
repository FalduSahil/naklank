<?php

use App\Models\Category;
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
    if($path == 'home'){
        return asset('assets/home');
    }
    if($path == 'common'){
        return asset('assets/common');
    }
    if($path == 'upload'){
        return asset('assets/uploads');
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
