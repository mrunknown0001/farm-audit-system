<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::group(['middleware' => 'auth:sanctum'], function () {
    // Route::get('users', [UserController::class, 'users']);
});