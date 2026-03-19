<?php

use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('departments', [DepartmentController::class, 'store'])->name('departments.store');

Route::post('users', [UserController::class, 'store'])->name('users.store');

Route::post('login', [AuthController::class, 'login'])->name('api.login');