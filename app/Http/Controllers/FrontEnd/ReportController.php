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
        $transactions = auth()->user()->transactions()->when(request()->keyword, function ($query) {
            $query->where('trx', 'LIKE', '%' . request()->keyword . '%')
            ->orWhere('remark', 'LIKE', '%' . request()->keyword . '%')
            ->orWhere('details', 'LIKE', '%' . request()->keyword . '%');
        })->latest()->paginate($limit);

        return Blade::render('<x-transaction-list :transactions="$transactions"/>', ['transactions' => $transactions]);
    }
}
