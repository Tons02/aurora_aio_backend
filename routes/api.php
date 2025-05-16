<?php

use App\Http\Controllers\Api\AuroraStore\Checklist\AnswerController;
use App\Http\Controllers\Api\AuroraStore\Checklist\ChecklistController;
use App\Http\Controllers\Api\AuroraStore\Checklist\QuestionController;
use App\Http\Controllers\Api\AuroraStore\Checklist\SectionController;
use App\Http\Controllers\Api\AuroraStore\StoreController;
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
    Route::put('role-archived/{id}', [RoleController::class, 'archived'])->middleware(['abilities:role']);
    Route::resource("role", RoleController::class)->middleware(['abilities:role']);

    // User Controller
    Route::put('user-archived/{id}', [UserController::class, 'archived'])->middleware(['abilities:user']);
    Route::resource("user", UserController::class)->middleware(['abilities:user']);

    // Store Controller
    Route::put('store-archived/{id}', [StoreController::class, 'archived']);
    Route::resource("store", StoreController::class);

    // Checklist Controller
    Route::put('checklist-archived/{id}', [ChecklistController::class, 'archived']);
    Route::resource("checklist", ChecklistController::class);

    // Section Controller
    Route::put('section-archived/{id}', [SectionController::class, 'archived']);
    Route::resource("section", SectionController::class);

    // Question Controller
    Route::put('question-archived/{id}', [QuestionController::class, 'archived']);
    Route::resource("question", QuestionController::class);

    // Answer Controller
    Route::put('answer-archived/{id}', [AnswerController::class, 'archived']);
    Route::resource("answer", AnswerController::class);

    // auth controller
    Route::patch('changepassword', [AuthController::class, 'changedPassword']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::patch('resetpassword/{id}', [AuthController::class, 'resetPassword']);
});
