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
        $transactions = auth()->user()->transactions()->when(\request()->reward != 1, function ($query){
            $query->active();
        })->when(\request()->remark, function ($query){
            $query->where('remark', request()->remark);
        })->when(request()->keyword, function ($query) {
            $query->where('trx', 'LIKE', '%' . request()->keyword . '%')
            ->orWhere('details', 'LIKE', '%' . request()->keyword . '%')
            ->orWhere('amount', 'LIKE', '%' . request()->keyword . '%');
//            ->orWhere('type',    'LIKE', '%' . request()->keyword . '%');
        })->orderBy('id', 'desc')->paginate($limit);
        return Blade::render('<x-transaction-list :transactions="$transactions"/>', ['transactions' => $transactions]);
    }

    public function payments($type, $deposit_type)
    {
        return view('frontend.reports.payments', ['type' => $type]);
    }

    public function loadPaymentsTable($type, $deposit_type)
    {
        $limit = \config()->get('settings.pagination_limit');
        $payments = auth()->user()->payments()->where('deposit_type', $deposit_type)->whereRelation('transaction', 'remark', $type)->with([
            'transaction' => function ($query) {
                $query->when(
                    request()->keyword,
                    function ($query) {
                        $query->where('trx', 'LIKE', '%' . request()->keyword . '%')
                            ->orWhere('remark', 'LIKE', '%' . request()->keyword . '%')
                            ->orWhere('details', 'LIKE', '%' . request()->keyword . '%');
                    }
                );
            },
            'gateway' => function ($query) {
                $query->when(
                    request()->keyword,
                    function ($query) {
                            $query->where('name', 'LIKE', '%' . request()->keyword . '%');
                        }
                );
            },
            'plan' => function ($query){
                $query->when(request()->uuid, function ($query){
                    $query->whereUuid(request()->uuid);
                });
            }
            ])->latest()->paginate($limit);

        return Blade::render('<x-payment-list :payments="$payments"/>', ['payments' => $payments]);
    }

    public function committee()
    {
        return view('frontend.reports.committee');
    }
    public function loadCommitteeTable()
    {
        $limit = \config()->get('settings.pagination_limit');
        $committees = auth()->user()->committees()->with(['plan'])->when(request()->keyword, function ($query) {
            $query->whereHas('plan', function($subQuery){
                $subQuery->where('name', 'LIKE', '%' . request()->keyword . '%');
            });
        })->latest()->paginate($limit);
        return Blade::render('<x-committee-item :committees="$committees"/>', ['committees' => $committees]);
    }

    function installments(){
        return view('frontend.reports.installments');
    }

    function installmentsTable(){
        $limit = \config()->get('settings.pagination_limit');
        $installments = auth()->user()->installments()->when(request()->keyword, function ($query) {
            $query->where('name', 'LIKE', request()->keyword);
        })->latest()->paginate($limit);
        return Blade::render('<x-installment-item :installments="$installments"/>', ['installments' => $installments]);
    }
    function commissions(){
        return view('frontend.reports.commissions');
    }

    function commissionsTable(){
        $limit = \config()->get('settings.pagination_limit');
        $commissions = auth()->user()->commissions()->with(['from', 'transaction'])->when(request()->keyword, function ($query) {
            $query->where('name', 'LIKE', request()->keyword);
        })->latest()->paginate($limit);
        return Blade::render('<x-commission-item :commissions="$commissions"/>', ['commissions' => $commissions]);
    }
}
