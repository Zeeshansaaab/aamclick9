<?php

use App\Jobs\ScrapperJob;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Models\Event;

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

// Route::get('crons', function () {
//     Artisan::call('schedule:work');
//     return "PHP ARTISAN Schedule:work";
// });

Route::get('/', function () {
    $events = Event::all()->toArray();
    return view('frontend.home', compact('events'));
})->name('home');

Route::get('/scrape', function () {
    ScrapperJob::dispatch();
});
Route::middleware(['auth'])->group(function () {
   
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/login-activity', [ProfileController::class, 'loginLogs'])->name('profile.login-logs');
    Route::delete('/profile/login-activity/{log}', [ProfileController::class, 'destroyLoginLogs'])->name('profile.destroy.login-logs');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('dashboard', [App\Http\Controllers\FrontEnd\DashboardController::class, 'index'])->name('dashboard');
    Route::get('dashboard/chart', [App\Http\Controllers\FrontEnd\DashboardController::class, 'charts'])->name('dashboard.chart');
    //Referrals
    Route::get('referrals/{level}', [App\Http\Controllers\FrontEnd\UserController::class, 'referrals'])->name('referrals');
    Route::get('referrals/table/{level}', [App\Http\Controllers\FrontEnd\UserController::class, 'loadReferralTable'])->name('referrals.table');
    
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
