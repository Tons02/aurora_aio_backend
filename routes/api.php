<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Masterlist\BusinessUnitController;
use App\Http\Controllers\Api\Masterlist\CompanyController;
use App\Http\Controllers\Api\Masterlist\DepartmentController;
use App\Http\Controllers\Api\Masterlist\LocationController;
use App\Http\Controllers\Api\Masterlist\SubUnitController;
use App\Http\Controllers\Api\Masterlist\UnitController;
use App\Http\Controllers\Api\UserManagement\RoleController;
use App\Http\Controllers\Api\UserManagement\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('login', [AuthController::class, 'login']);


Route::middleware(['auth:sanctum'])->group(function () {

    //Masterlist
    Route::resource("companies", CompanyController::class)->middleware(['abilities:companies']);
    Route::resource("business-units", BusinessUnitController::class)->middleware(['abilities:business_units']);
    Route::resource("departments", DepartmentController::class)->middleware(['abilities:departments']);
    Route::resource("units", UnitController::class)->middleware(['abilities:units']);
    Route::resource("sub-units", SubUnitController::class)->middleware(['abilities:sub_units']);
    Route::resource("locations", LocationController::class)->middleware(['abilities:locations']);

    // Role Controller
    Route::put('role-archived/{id}', [RoleController::class, 'archived'])->middleware(['abilities:role_management']);
    Route::resource("role", RoleController::class)->middleware(['abilities:role_management']);

    // User Controller
    // Route::put('user-archived/{id}', [UserController::class, 'archived'])->middleware(['abilities:user_management']);
    // Route::resource("user", UserController::class)->middleware(['abilities:user_management']);

    // auth controller
    Route::patch('changepassword', [AuthController::class, 'changedPassword']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::patch('resetpassword/{id}', [AuthController::class, 'resetPassword']);
});
