<?php 

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin as Admin;
Route::get('/', function(){
    return redirect()->route('admin.dashboard');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('plans', Admin\PlanController::class);
    Route::get('plans-dt', [Admin\PlanController::class, 'dataTable'])->name('plans.dt');
});