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
    // Artisan::call('migrate:fresh --seed');
    
    ScrapperJob::dispatch();
    
    $page = 1;
    $totalRecords = 1;
    $limit = 1;
    $totalPages = 1;
    // Log::alert("Scraper running");
    // while ($totalPages >= $page) {
    //     $response = Http::withHeaders([
    //         // 'Authorization' => 'Bearer 3e28d3d0-bed4-450b-bb38-9c4f2f6415dd'
    //     ])->get('https://aamclick.com/api/users', [
    //             'limit' => $limit,
    //             'page' => $page
    //         ]);

    //     // Log::info($response);
    //     $totalRecords = $response->object()->total;
    //     $totalPages = ceil($totalRecords / $limit);
    //     // Log::info($response->object());
    //     foreach ($response->object()->data as $responseUser) {
    //         try {
    //             // DB::beginTransaction();
    //             $user = User::create([
    //                 'uuid' => $responseUser->aam_id,
    //                 'ref_by' => $responseUser->ref_by,
    //                 'name' => $responseUser->firstname . ' ' . $responseUser->lastname,
    //                 'email' => $responseUser->email,
    //                 'country_code' => substr($responseUser->mobile, 0, 4),
    //                 'mobile' => substr($responseUser->mobile, 4, 7),
    //                 'address' => json_encode($responseUser->address),
    //                 'status' => $responseUser->status == 1 ? Status::Active : Status::InActive,
    //                 'sv' => $responseUser->sv,
    //                 'email_verified_at' => $responseUser->created_at,
    //                 'ban_reason' => $responseUser->ban_reason,
    //                 'password' => $responseUser->password,
    //                 'created_at' => $responseUser->created_at,
    //                 'updated_at' => $responseUser->updated_at,
    //             ]);

    //             // DB::commit();
    //         } catch (Exception $e) {
    //             // DB::rollBack();
    //             Log::error($e);
    //         }
    //     }
    //     $page = 2;
    // }
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
