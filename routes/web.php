<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;

Route::get('/', function () {
    Log::channel('k_chanel')->info('Test stdout log');
     Log::channel('k_chanel')->warning('warning');
    Log::channel('k_chanel')->error('Test stderr log');
    return view('welcome');
});

Route::get('/home', function () {
    return view('home');
});
