<?php

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Artisan;

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

Route::get('update-database', function () {
    Artisan::call('migrate:fresh --seed');
    return "PHP ARTISAN MIGRATE:FRESH --SEED HAS EXECUTED SUCCESSFULLY";
});

Route::get('/', function () {
    return redirect()->route('dashboard');
    // return view('frontend.welcome');
});


Route::middleware(['auth', 'verified'])->group(function () {
    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('dashboard', [App\Http\Controllers\FrontEnd\DashboardController::class, 'index'])->name('dashboard');
    Route::get('dashboard/chart', [App\Http\Controllers\FrontEnd\DashboardController::class, 'charts'])->name('dashboard.chart');
    //Referrals
    Route::get('referrals', [App\Http\Controllers\FrontEnd\UserController::class, 'referrals'])->name('referrals');
    Route::get('referrals/table', [App\Http\Controllers\FrontEnd\UserController::class, 'loadReferralTable'])->name('referrals.table');
    
    Route::prefix('reports')->name('reports.')->group(function () {
        //Transactions
        Route::get('transactions', [App\Http\Controllers\FrontEnd\ReportController::class, 'transactions'])->name('transactions');
        Route::get('transactions/table', [App\Http\Controllers\FrontEnd\ReportController::class, 'loadTransactionsTable'])->name('transactions.table');
        Route::get('{type}/payments/', [App\Http\Controllers\FrontEnd\ReportController::class, 'payments'])->name('payments');
        Route::get('{type}/payments/table', [App\Http\Controllers\FrontEnd\ReportController::class, 'loadPaymentsTable'])->name('payments.table');
    });

    //Deposit
    Route::get('deposit', [App\Http\Controllers\FrontEnd\DepositController::class, 'index'])->name('deposit');
    Route::post('deposit/confirm', [App\Http\Controllers\FrontEnd\DepositController::class, 'depositConfirmation'])->name('deposit.confirm');
    Route::post('deposit/confirmed', [App\Http\Controllers\FrontEnd\DepositController::class, 'depositConfirmed'])->name('deposit.confirmed');

    Route::get('notifications', [App\Http\Controllers\FrontEnd\UserController::class, 'notifications'])->name('notifications');
});

Route::get('plans', [App\Http\Controllers\FrontEnd\PlanController::class, 'index'])->name('plans.index');
Route::get('committee/plans', [App\Http\Controllers\FrontEnd\CommitteeController::class, 'index'])->name('committee.plans.index');

require __DIR__.'/auth.php';
