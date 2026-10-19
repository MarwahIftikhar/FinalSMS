<?php

use App\Http\Controllers\AdmissionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;

Route::get('/login', [AuthController::class, 'create'])->middleware('guest')->name('login');
Route::post('/login', [AuthController::class, 'store'])->middleware('guest')->name('login.store');
Route::post('/logout', [AuthController::class, 'destroy'])->middleware('auth')->name('logout');

use App\Http\Controllers\UserController;


Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        $branch = \App\Models\Branch::find(session('active_branch_id', 1));

        return view('dashboard', compact('branch'));
    })->name('dashboard');

    Route::resource('admissions', AdmissionController::class)->except('show');
    // Creates a new class directly from the Admission form.
    Route::post(
        '/classes/store-from-admission',
        [ClassController::class, 'storeFromAdmission']
    )->name('classes.storeFromAdmission');
    Route::resource('classes', ClassController::class)
        ->parameters(['classes' => 'schoolClass']);
    Route::post('/sections/store-from-admission', [SectionController::class, 'storeFromAdmission'])
        ->name('sections.storeFromAdmission');
    Route::resource('sections', SectionController::class)
        ->parameters(['sections' => 'section']);
    Route::post('/branch/switch', [BranchController::class, 'switch'])
        ->middleware('role:super_admin')
        ->name('branches.switch');
    Route::resource('branches', BranchController::class);

    // Administration modules: super admin only
    Route::resource('users', UserController::class);

    Route::resource('roles', RoleController::class);
    
    Route::post('/roles/{role}/assign-user', [RoleController::class, 'assignUserRole'])
        ->middleware('role:super_admin')
        ->name('roles.assignUserRole');
    Route::post('/roles/{role}/remove-user', [RoleController::class, 'removeUserRole'])
        ->middleware('role:super_admin')
        ->name('roles.removeUserRole');
});
