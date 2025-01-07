<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login');
});

require __DIR__.'/auth.php';
