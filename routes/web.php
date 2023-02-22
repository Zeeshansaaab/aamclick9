<?php

use App\Models\User;
use App\Models\Event;
use App\Jobs\ScrapperJob;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FrontEnd as Frontend;
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
    Route::get('dashboard', [Frontend\DashboardController::class, 'index'])->name('dashboard');
    Route::get('dashboard/chart', [Frontend\DashboardController::class, 'charts'])->name('dashboard.chart');
    Route::post('claim-reward', [Frontend\DashboardController::class, 'claimReward'])->name('claim-reward');
    //Referrals
    Route::get('referrals/{level}', [Frontend\UserController::class, 'referrals'])->name('referrals');
    Route::get('referrals/table/{level}', [Frontend\UserController::class, 'loadReferralTable'])->name('referrals.table');

    Route::prefix('reports')->name('reports.')->group(function () {
        //Transactions
        Route::get('transactions', [Frontend\ReportController::class, 'transactions'])->name('transactions');
        Route::get('transactions/table', [Frontend\ReportController::class, 'loadTransactionsTable'])->name('transactions.table');
        Route::get('committee', [Frontend\ReportController::class, 'committee'])->name('committee');
        Route::get('committee/table', [Frontend\ReportController::class, 'loadCommitteeTable'])->name('committee.table');
        Route::get('{type}/{deposit_type}/payments/', [Frontend\ReportController::class, 'payments'])->name('payments');
        Route::get('{type}/{deposit_type}/payments/table', [Frontend\ReportController::class, 'loadPaymentsTable'])->name('payments.table');
        Route::get('installments', [Frontend\ReportController::class, 'installments'])->name('installments');
        Route::get('installments/table', [Frontend\ReportController::class, 'installmentsTable'])->name('installments.table');
        Route::get('commissions', [Frontend\ReportController::class, 'commissions'])->name('commissions');
        Route::get('commissions/table', [Frontend\ReportController::class, 'commissionsTable'])->name('commissions.table');
    });

    //Deposit
    Route::get('payment/{type}', [Frontend\PaymentController::class, 'index'])->name('payment');
    Route::post('deposit/confirm', [Frontend\PaymentController::class, 'depositConfirmation'])->name('deposit.confirm');
    Route::post('deposit/confirmed', [Frontend\PaymentController::class, 'depositConfirmed'])->name('deposit.confirmed');
    Route::post('withdraw/confirm', [Frontend\PaymentController::class, 'withdrawConfirmation'])->name('withdraw.confirm');
    Route::post('withdraw/confirmed', [Frontend\PaymentController::class, 'withdrawConfirmed'])->name('withdraw.confirmed');
    Route::resource('installments', Frontend\InstallmentController::class);
    Route::get('notifications', [Frontend\UserController::class, 'notifications'])->name('notifications');
    Route::resource('committees', Frontend\CommitteeController::class)->only(['index', 'store', 'show']);
    Route::post('committees/get-committee-number', [Frontend\CommitteeController::class, 'getCommitteeNumber'])->name('committees.get-committee-number');
    Route::get('plans', [Frontend\PlanController::class, 'index'])->name('plans.index');
    Route::resource('umrah', Frontend\UmrahController::class)->only('index');

});


require __DIR__.'/auth.php';
