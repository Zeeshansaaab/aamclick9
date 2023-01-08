<?php

namespace App\Http\Controllers\FrontEnd;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Blade;

class ReportController extends Controller
{
    public function transactions()
    {
        return view('frontend.reports.transactions');
    }
    public function loadTransactionsTable()
    {
        $limit = \config()->get('settings.pagination_limit');
        $transactions = auth()->user()->transactions()->active()->when(request()->keyword, function ($query) {
            $query->where('trx', 'LIKE', '%' . request()->keyword . '%')
            ->orWhere('remark', 'LIKE', '%' . request()->keyword . '%')
            ->orWhere('details', 'LIKE', '%' . request()->keyword . '%');
        })->orderByDesc('id')->paginate($limit);

        return Blade::render('<x-transaction-list :transactions="$transactions"/>', ['transactions' => $transactions]);
    }

    public function payments($type)
    {
        return view('frontend.reports.payments', ['type' => $type]);
    }

    public function loadPaymentsTable($type)
    {
        $limit = \config()->get('settings.pagination_limit');
        $payments = auth()->user()->payments()->whereRelation('transaction', 'type', $type)->with([
            'transaction' => function ($query) {
                $query->when(request()->keyword, function ($query) {
                    $query->where('trx', 'LIKE', '%' . request()->keyword . '%')
                        ->orWhere('remark', 'LIKE', '%' . request()->keyword . '%')
                        ->orWhere('details', 'LIKE', '%' . request()->keyword . '%');
                }
                );
            },
            'gateway' => function ($query) {
                $query->when(request()->keyword, function ($query) {
                        $query->where('name', 'LIKE', '%' . request()->keyword . '%');
                    });
                }
            ])->orderByDesc('id')->paginate($limit);

        return Blade::render('<x-payment-list :payments="$payments"/>', ['payments' => $payments]);
    }

}
