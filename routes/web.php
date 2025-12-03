<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{
    RtoController,
    AuthController,
    UserController,
    ProfileController,
    ContractController,
    EsignatureController,
    StudentNoteController,
    StudentDocumentController,
    RtoPersonalDocumentController
};

use App\Http\Controllers\Admin\{
    CourseController,
    StudentController,
    IndustryController,
    CoordinatorController,
    RolePermissionController,
    DocumentChecklistController,
    RtoController as AdminRtoController,
};


Route::get('/', function () {
    return view('admin.auth.login');
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
Route::middleware(['auth', 'role:rto|admin'])->prefix('rto')->group(function () {

    /** -------------------------
     *  Dashboard
     * -------------------------- */
    Route::get('/dashboard', [RtoController::class, 'dashboard'])->name('rto.dashboard');


    /** -------------------------
     *  Students
     * -------------------------- */
    Route::controller(RtoController::class)->group(function () {
        Route::get('/students', 'students')->name('rto.students');
        Route::post('/students', 'storeStudent');
        Route::put('/students/{id}', 'updateStudent');
        Route::delete('/students/{id}', 'destroyStudent');
        Route::post('/students/upload', 'uploadStudents');
        Route::get('/students/csv-format', 'csvFormat');
        // Route::post('/students/{id}/notes', 'saveStudentNotes');
    });


    /** -------------------------
     *  Student Notes
     * -------------------------- */
    Route::controller(StudentNoteController::class)->prefix('students/{student}')->group(function () {
        Route::get('/notes', 'index');
        Route::post('/notes', 'store');
    });


    /** -------------------------
     *  Student Documents
     * -------------------------- */
    Route::controller(StudentDocumentController::class)->prefix('student-documents')->group(function () {
        Route::get('/{student}', 'index')->name('rto.student-documents.index');
        Route::post('/{student}', 'store')->name('rto.student-documents.store');
        Route::get('/{student}/existing-checklists', 'getExistingChecklists');
        Route::post('/assign-types/{student}', 'assignTypes');
        Route::delete('/{document}', 'destroy');
    });


    /** -------------------------
     *  Personal Documents
     * -------------------------- */
    Route::controller(RtoPersonalDocumentController::class)->prefix('my-documents')->group(function () {
        Route::get('/', 'index')->name('rto.my-documents');
        Route::post('/', 'store');
        Route::delete('/{document}', 'destroy');
    });


    /** -------------------------
     *  Industries
     * -------------------------- */
    Route::get('/industries', [RtoController::class, 'industries'])->name('rto.industries');


    /** -------------------------
     *  E-Signature
     * -------------------------- */
    Route::controller(EsignatureController::class)->prefix('esignature')->group(function () {
        Route::get('/', 'index')->name('rto.esignature');
        Route::post('/', 'store');
        Route::put('/{esignature}', 'update');
        Route::delete('/{esignature}', 'destroy');
    });


    /** -------------------------
     *  Contracts
     * -------------------------- */
    Route::controller(ContractController::class)->prefix('contracts')->group(function () {
        Route::get('/', 'rtoIndex')->name('rto.contracts');
        Route::post('/{contract}/sign', 'signContract');
        Route::get('/{contract}/view', 'viewContract')->name('rto.contracts.view');
    });
});


// Universal Profile Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show']);
    Route::put('/profile', [ProfileController::class, 'update']);
});

// Admin Routes
Route::middleware(['auth', 'role:admin|coordinator'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard
        // Route::get('/dashboard', fn() => view('admin.pages.dashboard'))->name('dashboard');

        // Dashboard
        Route::get('dashboard', [AdminRtoController::class, 'dashboard'])->name('dashboard');

        // RTOs
        Route::controller(AdminRtoController::class)->group(function () {
            Route::get('/rtos', 'index')->name('rtos');
            Route::get('/rtos/create', 'create')->name('rtos.create');
            Route::get('/rtos/data', 'data')->name('rtos.data');
            Route::post('/rtos', 'store')->name('rtos.store');
            Route::get('/rtos/{id}/edit', 'edit')->name('rtos.edit');
            Route::put('/rtos/{id}', 'update')->name('rtos.update');
            Route::delete('/rtos/{id}', 'destroy');
            Route::patch('/rtos/{id}/toggle-status', 'toggleStatus');
            Route::post('/rtos/update-status/{id}', 'updateStatus');
        });

        // Students
        Route::controller(StudentController::class)->group(function () {
            Route::get('/students', 'index')->name('students');
            Route::get('/students/create', 'create')->name('students.create');
            Route::get('/students/data', 'data')->name('students.data');
            Route::post('/students', 'store')->name('students.store');
            Route::put('/students/{id}', 'update')->name('students.update');
            Route::delete('/students/{id}', 'destroy');
            Route::post('/students/upload', 'upload');
            Route::get('/students/download', 'download')->name('students.download');
            Route::get('/students/csv-format', 'csvFormat');
        });

        Route::controller(StudentNoteController::class)->prefix('students/{student}')->group(function () {
            Route::get('/notes', 'index');
            Route::post('/notes', 'store');
        });

        // Courses
        Route::controller(CourseController::class)->group(function () {
            Route::get('/courses', 'index')->name('courses');
            Route::get('/courses/create', 'create')->name('courses.create');
            Route::get('/courses/data', 'data')->name('courses.data');
            Route::post('/courses', 'store')->name('courses.store');
            Route::get('/courses/{id}/edit', 'edit')->name('courses.edit');
            Route::put('/courses/{id}', 'update')->name('courses.update');
            Route::delete('/courses/{id}', 'destroy');
            Route::post('/courses/update-status/{id}', 'updateStatus');
        });

        // Industries
        Route::controller(IndustryController::class)->group(function () {
            Route::get('/industries', 'index')->name('industries');
            Route::get('/industries/create', 'create')->name('industries.create');
            Route::get('/industries/data', 'data')->name('industries.data');
            Route::post('/industries', 'store')->name('industries.store');
            Route::get('/industries/{id}/edit', 'edit')->name('industries.edit');
            Route::put('/industries/{id}', 'update')->name('industries.update');
            Route::delete('/industries/{id}', 'destroy');
            Route::patch('/industries/{id}/toggle-status', 'toggleStatus');
            Route::post('/industries/update-status/{id}', 'updateStatus');
        });

        // Coordinators
        Route::controller(CoordinatorController::class)->group(function () {
            Route::get('/coordinators', 'index')->name('coordinators');
            Route::get('/coordinators/create', 'create')->name('coordinators.create');
            Route::get('/coordinators/data', 'data')->name('coordinators.data');
            Route::post('/coordinators', 'store')->name('coordinators.store');
            Route::get('/coordinators/{id}/edit', 'edit')->name('coordinators.edit');
            Route::put('/coordinators/{id}', 'update')->name('coordinators.update');
            Route::delete('/coordinators/{id}', 'destroy');
            Route::patch('/coordinators/{id}/reset-password', 'resetPassword');
            Route::patch('/coordinators/{id}/toggle-status', 'toggleStatus');
            Route::post('/coordinators/update-status/{id}', 'updateStatus');
        });

        // Role & Permissions
        Route::controller(RolePermissionController::class)->group(function () {
            Route::get('/roles', 'roles')->name('roles');
            Route::post('/roles', 'storeRole');
            Route::put('/roles/{id}', 'updateRole');
            Route::delete('/roles/{id}', 'deleteRole');

            Route::get('/permissions', 'permissions')->name('permissions');
            Route::post('/permissions', 'storePermission');
            Route::put('/permissions/{id}', 'updatePermission');
            Route::delete('/permissions/{id}', 'deletePermission');

            Route::get('/assign-permissions', 'assignPermissions')->name('assign-permissions');
            Route::post('/assign-permissions', 'updateRolePermissions');
        });

        // Student Documents
        Route::controller(StudentDocumentController::class)->group(function () {
            Route::get('/student-documents/{student}', 'index')->name('student-documents.index');
            Route::post('/student-documents/{student}', 'store')->name('student-documents.store');
            Route::post('/student-documents/assign-types/{student}', 'assignTypes');
            Route::delete('/student-documents/{document}', 'destroy');
        });

        // Document Checklist
        Route::controller(DocumentChecklistController::class)->group(function () {
            Route::get('/document-checklist', 'index')->name('document-checklist');
            Route::post('/document-checklist', 'store');
            Route::put('/document-checklist/{id}', 'update');
            Route::delete('/document-checklist/{id}', 'destroy');
            Route::patch('/document-checklist/{id}/toggle-status', 'toggleStatus');
        });

        // Contracts
        Route::controller(ContractController::class)->group(function () {
            Route::get('/contracts', 'adminIndex')->name('contracts');
            Route::post('/contracts', 'store');
            Route::get('/contracts/{contract}/view', 'adminViewContract')->name('contracts.view');
            Route::delete('/contracts/{contract}', 'destroy');
        });
    });
