<?php

use App\Models\User;
use App\Enums\Status;
use App\Jobs\ScrapperJob;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
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

Route::get('update-database', function () {
    Artisan::call('migrate:fresh --seed');
    return "PHP ARTISAN MIGRATE:FRESH --SEED HAS EXECUTED SUCCESSFULLY";
});

Route::get('/', function () {
    // return redirect()->route('dashboard');
    return view('frontend.home');
});

Route::get('/scrape', function () {
    ScrapperJob::dispatch();
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
        Route::get('committee', [App\Http\Controllers\FrontEnd\ReportController::class, 'committee'])->name('committee');
        Route::get('committee/table', [App\Http\Controllers\FrontEnd\ReportController::class, 'loadCommitteeTable'])->name('committee.table');
        Route::get('{type}/{deposit_type}/payments/', [App\Http\Controllers\FrontEnd\ReportController::class, 'payments'])->name('payments');
        Route::get('{type}/{deposit_type}/payments/table', [App\Http\Controllers\FrontEnd\ReportController::class, 'loadPaymentsTable'])->name('payments.table');
        Route::get('installments', [App\Http\Controllers\FrontEnd\ReportController::class, 'installments'])->name('installments');
        Route::get('installments/table', [App\Http\Controllers\FrontEnd\ReportController::class, 'installmentsTable'])->name('installments.table');
        Route::get('commissions', [App\Http\Controllers\FrontEnd\ReportController::class, 'commissions'])->name('commissions');
        Route::get('commissions/table', [App\Http\Controllers\FrontEnd\ReportController::class, 'commissionsTable'])->name('commissions.table');
    });

    //Deposit
    Route::get('payment/{type}', [App\Http\Controllers\FrontEnd\PaymentController::class, 'index'])->name('payment');
    Route::post('deposit/confirm', [App\Http\Controllers\FrontEnd\PaymentController::class, 'depositConfirmation'])->name('deposit.confirm');
    Route::post('deposit/confirmed', [App\Http\Controllers\FrontEnd\PaymentController::class, 'depositConfirmed'])->name('deposit.confirmed');
    Route::post('withdraw/confirm', [App\Http\Controllers\FrontEnd\PaymentController::class, 'withdrawConfirmation'])->name('withdraw.confirm');
    Route::post('withdraw/confirmed', [App\Http\Controllers\FrontEnd\PaymentController::class, 'withdrawConfirmed'])->name('withdraw.confirmed');
    Route::resource('installments', App\Http\Controllers\FrontEnd\InstallmentController::class);
    Route::get('notifications', [App\Http\Controllers\FrontEnd\UserController::class, 'notifications'])->name('notifications');
    Route::resource('committees', App\Http\Controllers\FrontEnd\CommitteeController::class)->only(['index', 'store', 'show']);
    Route::post('committees/get-committee-number', [App\Http\Controllers\FrontEnd\CommitteeController::class, 'getCommitteeNumber'])->name('committees.get-committee-number');
    Route::get('plans', [App\Http\Controllers\FrontEnd\PlanController::class, 'index'])->name('plans.index');
});


require __DIR__.'/auth.php';
