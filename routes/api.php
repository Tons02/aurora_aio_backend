<?php

use App\Http\Controllers\Api\AuroraStore\Checklist\AnswerController;
use App\Http\Controllers\Api\AuroraStore\Checklist\ChecklistController;
use App\Http\Controllers\Api\AuroraStore\Checklist\QuestionController;
use App\Http\Controllers\Api\AuroraStore\Checklist\SectionController;
use App\Http\Controllers\Api\AuroraStore\StoreController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Masterlist\OneChargingController;
use App\Http\Controllers\Api\UserManagement\RoleController;
use App\Http\Controllers\Api\UserManagement\UserController;
use Illuminate\Support\Facades\Route;


Route::post('login', [AuthController::class, 'login']);

// One Charging Controller
Route::put('one-charging/{id}', [OneChargingController::class, 'archived']);
Route::resource("one-charging", OneChargingController::class);

// Role Controller
Route::put('role-archived/{id}', [RoleController::class, 'archived']);
Route::resource("role", RoleController::class);

// User Controller
Route::put('user-archived/{id}', [UserController::class, 'archived']);
Route::get('users-export', [UserController::class, 'export']);
Route::resource("user", UserController::class);

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

Route::middleware(['auth:sanctum'])->group(function () {});
