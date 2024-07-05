<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrganisationController;
use App\Http\Controllers\UserController;

Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    
    // Get user's own record or record in organisations they belong to or created
    Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');

    // Get all organisations the user belongs to or created
    Route::get('/organisations', [OrganisationController::class, 'index'])->name('organisations.index');

    // Get a single organisation record by ID
    Route::get('/organisations/{orgId}', [OrganisationController::class, 'show'])->name('organisations.show');

    // Create a new organisation
    Route::post('/organisations', [OrganisationController::class, 'store'])->name('organisations.store');
    
});

// Add a user to a particular organisation
Route::post('/organisations/{orgId}/users', [OrganisationController::class, 'addUser'])->name('organisations.addUser');