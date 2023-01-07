<?php

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('frontend.welcome');
});


Route::middleware('auth')->group(function () {
    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('dashboard', [App\Http\Controllers\FrontEnd\DashboardController::class, 'index'])->name('dashboard');
    Route::get('dashboard/chart', [App\Http\Controllers\FrontEnd\DashboardController::class, 'charts'])->name('dashboard.chart');
    //Referrals
    Route::get('referrals', [App\Http\Controllers\FrontEnd\UserController::class, 'referrals'])->name('referrals');
    Route::get('referrals/table', [App\Http\Controllers\FrontEnd\UserController::class, 'loadReferralTable'])->name('referrals.table');
    
    Route::prefix('reports')->group(function () {
        //Transactions
        Route::get('transactions', [App\Http\Controllers\FrontEnd\ReportController::class, 'transactions'])->name('transactions');
        Route::get('transactions/table', [App\Http\Controllers\FrontEnd\ReportController::class, 'loadTransactionsTable'])->name('transactions.table');
    });
});

Route::get('plans', [App\Http\Controllers\FrontEnd\PlanController::class, 'index'])->name('plans.index');
Route::get('committee/plans', [App\Http\Controllers\FrontEnd\CommitteeController::class, 'index'])->name('committee.plans.index');

require __DIR__.'/auth.php';
