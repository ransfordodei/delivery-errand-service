<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
use Illuminate\Support\Facades\DB;

Route::get('/show-users', function () {
    $users = DB::table('users')->get(); // fetch all records from users table
    return view('show-users', compact('users'));
});