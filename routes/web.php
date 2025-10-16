<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RtoController;
use App\Http\Controllers\Admin\RolePermissionController;

Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes
Route::get('/login', function () {
    return view('admin.auth.login');
})->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', function () {
    return view('admin.auth.register');
})->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// User Dashboard
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
});

// RTO Dashboard
Route::middleware(['auth', 'role:rto'])->group(function () {
    Route::get('/rto/dashboard', [RtoController::class, 'dashboard'])->name('rto.dashboard');
});

// Admin Routes
Route::middleware(['auth', 'role:admin|coordinator'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.pages.dashboard');
    })->name('dashboard');

    Route::get('/rto', function () {
        return view('admin.pages.add_rto');
    })->name('add_rto');

    Route::get('/students', function () {
        return view('admin.pages.students');
    })->name('students');

    Route::get('/courses', function () {
        return view('admin.pages.courses');
    })->name('courses');

    Route::get('/Industries', function () {
        return view('admin.pages.Industries');
    })->name('Industries');

    Route::get('/Coordinator', function () {
        return view('admin.pages.Coordinator');
    })->name('Coordinator');

    // Role & Permission Management
    Route::get('/roles', [RolePermissionController::class, 'roles'])->name('roles');
    Route::post('/roles', [RolePermissionController::class, 'storeRole']);
    Route::put('/roles/{id}', [RolePermissionController::class, 'updateRole']);
    Route::delete('/roles/{id}', [RolePermissionController::class, 'deleteRole']);
    Route::get('/permissions', [RolePermissionController::class, 'permissions'])->name('permissions');
    Route::post('/permissions', [RolePermissionController::class, 'storePermission']);
    Route::put('/permissions/{id}', [RolePermissionController::class, 'updatePermission']);
    Route::delete('/permissions/{id}', [RolePermissionController::class, 'deletePermission']);
    Route::get('/assign-permissions', [RolePermissionController::class, 'assignPermissions'])->name('assign-permissions');
    Route::post('/assign-permissions', [RolePermissionController::class, 'updateRolePermissions']);

    // User Management
    Route::get('/create-users', [App\Http\Controllers\Admin\UserManagementController::class, 'createUsers'])->name('create-users');
    Route::post('/create-users', [App\Http\Controllers\Admin\UserManagementController::class, 'storeUser']);
});


