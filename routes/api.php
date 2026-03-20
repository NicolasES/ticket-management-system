<?php

use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DepartmentUserController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TicketController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('departments', [DepartmentController::class, 'store'])->name('departments.store');
Route::get('departments/{departmentId}/users', [DepartmentUserController::class, 'index'])->name('departments.users.index');

Route::post('users', [UserController::class, 'store'])->name('users.store');

Route::post('login', [AuthController::class, 'login'])->name('api.login');
// This route is only to simulate login behavior and testing purposes.
// It should NEVER be used in a real production system without proper protection (authentication/authorization).
Route::post('login/direct/{userId}', [AuthController::class, 'loginDirectly'])->name('api.login.direct');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('tickets', [TicketController::class, 'index'])->name('tickets.index');
    Route::post('tickets', [TicketController::class, 'store'])->name('tickets.store');
});