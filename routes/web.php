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

    Route::get('/rto', [App\Http\Controllers\Admin\RtoController::class, 'index'])->name('add_rto');
    Route::post('/rto', [App\Http\Controllers\Admin\RtoController::class, 'store']);
    Route::put('/rto/{id}', [App\Http\Controllers\Admin\RtoController::class, 'update']);
    Route::delete('/rto/{id}', [App\Http\Controllers\Admin\RtoController::class, 'destroy']);
    Route::patch('/rto/{id}/toggle-status', [App\Http\Controllers\Admin\RtoController::class, 'toggleStatus']);

    Route::get('/students', [App\Http\Controllers\Admin\StudentController::class, 'index'])->name('students');
    Route::get('/students/download', [App\Http\Controllers\Admin\StudentController::class, 'download'])->name('students.download');

    Route::get('/courses', [App\Http\Controllers\Admin\CourseController::class, 'index'])->name('courses');
    Route::post('/courses', [App\Http\Controllers\Admin\CourseController::class, 'store']);
    Route::put('/courses/{id}', [App\Http\Controllers\Admin\CourseController::class, 'update']);
    Route::delete('/courses/{id}', [App\Http\Controllers\Admin\CourseController::class, 'destroy']);


    Route::get('/Industries', [App\Http\Controllers\Admin\IndustryController::class, 'index'])->name('Industries');
    Route::post('/Industries', [App\Http\Controllers\Admin\IndustryController::class, 'store']);
    Route::put('/Industries/{id}', [App\Http\Controllers\Admin\IndustryController::class, 'update']);
    Route::delete('/Industries/{id}', [App\Http\Controllers\Admin\IndustryController::class, 'destroy']);
    Route::patch('/Industries/{id}/toggle-status', [App\Http\Controllers\Admin\IndustryController::class, 'toggleStatus']);

    Route::get('/Coordinator', [App\Http\Controllers\Admin\CoordinatorController::class, 'index'])->name('Coordinator');
    Route::post('/Coordinator', [App\Http\Controllers\Admin\CoordinatorController::class, 'store']);
    Route::put('/Coordinator/{id}', [App\Http\Controllers\Admin\CoordinatorController::class, 'update']);
    Route::delete('/Coordinator/{id}', [App\Http\Controllers\Admin\CoordinatorController::class, 'destroy']);
    Route::patch('/Coordinator/{id}/reset-password', [App\Http\Controllers\Admin\CoordinatorController::class, 'resetPassword']);

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
    // Route::get('/create-users', [App\Http\Controllers\Admin\UserManagementController::class, 'createUsers'])->name('create-users');
    // Route::post('/create-users', [App\Http\Controllers\Admin\UserManagementController::class, 'storeUser']);
});


