
@php
    $user = auth()->user()->load(['planUser.plan', 'referrals']);
    $transactions = auth()->user()->transactions()->latest()->limit(4)->get();
    $cur_text = cur_text();
@endphp
<x-app-layout>
    <x-slot name="breadcrumb">
        <x-breadcrumb currentPage="Dashboard" title="Dashboard"/>
    </x-slot>

    <x-slot name="header">
        <div class="nk-block-between-md g-4">
            <div class="nk-block-head">
                <div class="nk-block-head-sub"><span>Welcome!</span></div>
                <div class="nk-block-head-content">
                    <h2 class="nk-block-title fw-normal">{{ $user->name }}</h2>
                    <div class="nk-block-des"><p></p></div>
                </div>
            </div><!-- .nk-block-head-content -->
            <div class="nk-block-head-content">
                <ul class="nk-block-tools gx-3">
                    <li>
                        <a href="#" class="btn btn-primary"><span>Deposit</span> <em class="icon ni ni-arrow-long-right"></em></a>
                    </li>
                    <li><a href="#" class="btn btn-white btn-light"><span>Buy / Sell</span> <em class="icon ni ni-arrow-long-right d-none d-sm-inline-block"></em></a></li>
                    <li class="opt-menu-md dropdown">
                        <a href="#" class="btn btn-white btn-light btn-icon" data-toggle="dropdown"><em class="icon ni ni-setting"></em></a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <ul class="link-list-opt no-bdr">
                                <li><a href="#"><em class="icon ni ni-coin-alt"></em><span>Curreny Settings</span></a></li>
                                <li><a href="#"><em class="icon ni ni-notify"></em><span>Push Notification</span></a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div><!-- .nk-block-head-content -->
        </div><!-- .nk-block-between -->
    </x-slot>
    {{-- Dashboard Cards --}}
    <div class="nk-block">
        <div class="row gy-gs">
            <div class="col-lg-5 col-xl-4">
                <div class="nk-block">
                    <div class="nk-block-head-xs">
                        <div class="nk-block-head-content">
                            <h5 class="nk-block-title title">Overview</h5>
                        </div>
                    </div>
                    <div class="nk-block">
                        <div class="card card-bordered text-light is-dark h-100">
                            <div class="card-inner">
                                <div class="nk-wg7">
                                    <div class="nk-wg7-stats">
                                        <div class="nk-wg7-title">
                                            Total Deposit in {{ $cur_text }}
                                        </div>
                                        <div class="number-lg amount">
                                            {{ currency($user->planUser->balance, true) }} 
                                        </div>
                                    </div>
                                    <div class="nk-wg7-stats-group">
                                        <div class="nk-wg7-stats w-50">
                                            <div class="nk-wg7-title">Profit Balance</div>
                                            <div class="number-lg">{{ currency($user->planUser->profit_bonus, true) }}</div>
                                        </div>
                                        <div class="nk-wg7-stats w-50">
                                            <div class="nk-wg7-title">
                                                Plan
                                            </div>
                                            <div class="number">
                                                @if($user->planUser->plan)
                                                {{ $user->planUser->plan->name }}
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="nk-wg7-foot">
                                        <span class="nk-wg7-note">Last login at
                                            <span>19 Nov, 2019</span></span
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="nk-block">
                    <div class="nk-block">
                        <div class="card card-bordered text-light is-dark h-100">
                            <div class="card-inner text-center">
                                <div class="nk-wg7">
                                    <div class="nk-wg7-stats">
                                        <div class="nk-wg7-title">
                                            User ID
                                        </div>
                                        <div class="amount" style="font-size: 1.5rem;">
                                            {{ $user->uuid }} 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 col-xl-8">
                <div class="nk-block">
                    <div class="nk-block-head-xs">
                        <div class="nk-block-between-md g-2">
                            <div class="nk-block-head-content">
                                <h5 class="nk-block-title title">
                                    Deposits
                                </h5>
                            </div>
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col-sm-4">
                            <div class="card bg-light">
                                <div class="nk-wgw sm">
                                    <a
                                        class="nk-wgw-inner"
                                        href="/demo5/crypto/wallet-bitcoin.html"
                                        ><div class="nk-wgw-name">
                                            <div class="nk-wgw-icon">
                                                <em
                                                    class="icon ni ni-sign-btc"
                                                ></em>
                                            </div>
                                            <h5 class="nk-wgw-title title">
                                                Referral income
                                            </h5>
                                        </div>
                                        <div class="nk-wgw-balance">
                                            <div class="amount">
                                                {{ currency($user->planUser->referral_income, true) }}<span
                                                    class="currency currency-nio"
                                                    >{{ $cur_text }}</span
                                                >
                                            </div>
                                        </div></a
                                    >
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="card bg-light">
                                <div class="nk-wgw sm">
                                    <a
                                        class="nk-wgw-inner"
                                        href="/demo5/crypto/wallet-bitcoin.html"
                                        ><div class="nk-wgw-name">
                                            <div class="nk-wgw-icon">
                                                <em
                                                    class="icon ni ni-sign-btc"
                                                ></em>
                                            </div>
                                            <h5 class="nk-wgw-title title">
                                                Referral deposit
                                            </h5>
                                        </div>
                                        <div class="nk-wgw-balance">
                                            <div class="amount">
                                                {{ currency($user->planUser->referral_deposit, true) }}<span
                                                    class="currency currency-btc"
                                                    >{{ $cur_text }}</span
                                                >
                                            </div>
                                        </div></a
                                    >
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="card bg-light">
                                <div class="nk-wgw sm">
                                    <a
                                        class="nk-wgw-inner"
                                        href="/demo5/crypto/wallet-bitcoin.html"
                                        ><div class="nk-wgw-name">
                                            <div class="nk-wgw-icon">
                                                <em
                                                    class="icon ni ni-sign-eth"
                                                ></em>
                                            </div>
                                            <h5 class="nk-wgw-title title">
                                                Total Team deposit
                                            </h5>
                                        </div>
                                        <div class="nk-wgw-balance">
                                            <div class="amount">
                                                0.000560<span
                                                    class="currency currency-eth"
                                                    >ETH</span
                                                >
                                            </div>
                                        </div></a
                                    >
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="nk-block nk-block-md">
                    <div class="nk-block-head-xs">
                        <div class="nk-block-between-md g-2">
                            <div class="nk-block-head-content">
                                <h6 class="nk-block-title title">Withdraw</h6>
                            </div>
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col-sm-4">
                            <div class="card bg-light">
                                <div class="nk-wgw sm">
                                    <a
                                        class="nk-wgw-inner"
                                        href="/demo5/crypto/wallet-bitcoin.html"
                                        ><div class="nk-wgw-name">
                                            <div class="nk-wgw-icon">
                                                <em
                                                    class="icon ni ni-sign-btc"
                                                ></em>
                                            </div>
                                            <h5 class="nk-wgw-title title">
                                                Bonus Withdraw
                                            </h5>
                                        </div>
                                        <div class="nk-wgw-balance">
                                            <div class="amount">
                                                0<span
                                                    class="currency currency-nio"
                                                    >{{ $cur_text }}</span
                                                >
                                            </div>
                                        </div></a
                                    >
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="card bg-light">
                                <div class="nk-wgw sm">
                                    <a
                                        class="nk-wgw-inner"
                                        href="/demo5/crypto/wallet-bitcoin.html"
                                        ><div class="nk-wgw-name">
                                            <div class="nk-wgw-icon">
                                                <em
                                                    class="icon ni ni-sign-btc"
                                                ></em>
                                            </div>
                                            <h5 class="nk-wgw-title title">
                                                Profit Withdraw
                                            </h5>
                                        </div>
                                        <div class="nk-wgw-balance">
                                            <div class="amount">
                                                {{-- auth()->user()->withdrawals()->sum('amount') --}}
                                                0<span
                                                    class="currency currency-btc"
                                                    >BTC</span
                                                >
                                            </div>
                                        </div></a
                                    >
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="nk-block nk-block-md">
                    <div class="nk-block-head-xs">
                        <div class="nk-block-between-md g-2">
                            <div class="nk-block-head-content">
                                <h6 class="nk-block-title title">Committee</h6>
                            </div>
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col-sm-4">
                            <div class="card bg-light">
                                <div class="nk-wgw sm">
                                    <a
                                        class="nk-wgw-inner"
                                        href="/demo5/crypto/wallet-bitcoin.html"
                                        ><div class="nk-wgw-name">
                                            <div class="nk-wgw-icon">
                                                <em
                                                    class="icon ni ni-sign-btc"
                                                ></em>
                                            </div>
                                            <h5 class="nk-wgw-title title">
                                               Committee
                                            </h5>
                                        </div>
                                        <div class="nk-wgw-balance">
                                            <div class="amount">
                                                0<span
                                                    class="currency currency-nio"
                                                    >{{ $cur_text }}</span
                                                >
                                            </div>
                                        </div></a
                                    >
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="card bg-light">
                                <div class="nk-wgw sm">
                                    <a
                                        class="nk-wgw-inner"
                                        href="/demo5/crypto/wallet-bitcoin.html"
                                        ><div class="nk-wgw-name">
                                            <div class="nk-wgw-icon">
                                                <em
                                                    class="icon ni ni-sign-btc"
                                                ></em>
                                            </div>
                                            <h5 class="nk-wgw-title title">
                                                Installment
                                            </h5>
                                        </div>
                                        <div class="nk-wgw-balance">
                                            <div class="amount">
                                                Get Installment
                                            </div>
                                        </div></a
                                    >
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="card bg-light">
                                <div class="nk-wgw sm">
                                    <a
                                        class="nk-wgw-inner"
                                        href="/demo5/crypto/wallet-bitcoin.html"
                                        ><div class="nk-wgw-name">
                                            <div class="nk-wgw-icon">
                                                <em
                                                    class="icon ni ni-sign-eth"
                                                ></em>
                                            </div>
                                            <h5 class="nk-wgw-title title">
                                                Coming soon
                                            </h5>
                                        </div>
                                        <div class="nk-wgw-balance">
                                            <div class="amount">
                                               -
                                            </div>
                                        </div></a
                                    >
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Dashboard cards end --}}
{{-- Transactions and chart --}}
@if(count($transactions) > 0)
<div class="nk-block nk-block-lg">
    <div class="row gy-gs">
        
        <div class="col-md-6">
            @if(count($transactions) > 0)
            <div class="card-head">
                <div class="card-title mb-0">
                    <h5 class="title">Recent Transactions</h5>
                </div>
            </div>
            <div class="tranx-list card card-bordered">
                @foreach ($transactions as $transaction)
                    <div class="tranx-item">
                        <div class="tranx-col">
                            <div class="tranx-info">
                                <div class="tranx-data">
                                    <div class="tranx-label">
                                        {{ $transaction->remark }}
                                        <em
                                            class="tranx-icon sm icon ni ni-sign-btc"
                                        ></em>
                                    </div>
                                    <div class="tranx-date">
                                        {{ date('M-d-Y', strtotime($transaction->created_at))}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tranx-col">
                            <div class="tranx-amount">
                                <div class="number">
                                    {{ currency($transaction->amount, true) }}
                                    <span class="currency currency-btc">{{ $cur_text }}</span>
                                </div>
                                <div class="number-sm">
                                    {{ currency($transaction->post_balance, true) }}
                                    <span class="currency currency-usd">{{ $cur_text }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            @endif
        </div>
        <div class="col-md-6">
            <div class="card-head">
                <div class="card-title mb-0">
                    <h5 class="title">Balance Flow</h5>
                </div>
            </div>
            <div class="card card-bordered">
                <div class="card-inner">
                    <div class="nk-wg4">
                        <div class="nk-wg4-group justify-center gy-3 gx-4">
                            <div class="nk-wg4-item">
                                <div class="sub-text">
                                    <div
                                        class="dot dot-lg sq"
                                        data-bg="#5ce0aa"
                                        style="background: rgb(92, 224, 170)"
                                    ></div>
                                    <span>Received</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="nk-ck3">
                        <div class="chartjs-size-monitor">
                            <div class="chartjs-size-monitor-expand">
                                <div class=""></div>
                            </div>
                            <div class="chartjs-size-monitor-shrink">
                                <div class=""></div>
                            </div>
                        </div>
                        <canvas
                            class="chart-account-summary chartjs-render-monitor"
                            id="summaryBalance"
                            width="550"
                            height="387"
                            style="display: block; height: 258px; width: 367px"
                        ></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
{{-- Transactions and charts end --}}
{{-- Referrals card --}}
<div class="nk-block">
    <div class="card card-bordered">
        <div class="nk-refwg">
            <div class="nk-refwg-invite card-inner">
                <div class="nk-refwg-head g-3">
                    <div class="nk-refwg-title">
                        <h5 class="title">Refer Us &amp; Earn</h5>
                        <div class="title-sub">
                            Use the bellow link to invite your friends.
                        </div>
                    </div>
                    <div class="nk-refwg-action">
                        <a href="#" class="btn btn-primary">Invite</a>
                    </div>
                </div>
                <div class="nk-refwg-url">
                    <div class="form-control-wrap">
                        <div
                            class="form-clip clipboard-init"
                            data-clipboard-target="#refUrl"
                            data-success="Copied"
                            data-text="Copy Link"
                        >
                            <em class="clipboard-icon icon ni ni-copy"></em>
                            <span class="clipboard-text">Copy Link</span>
                        </div>
                        <div class="form-icon">
                            <em class="icon ni ni-link-alt"></em>
                        </div>
                        <input
                            type="text"
                            class="form-control copy-text"
                            id="refUrl"
                            value="{{ route('register') }}?ref={{ $user->uuid }}"
                        />
                    </div>
                </div>
            </div>
            <div class="nk-refwg-stats card-inner bg-lighter">
                <div class="nk-refwg-group g-3">
                    <div class="nk-refwg-name">
                        <h6 class="title">
                            My Referral
                            <em
                                class="icon ni ni-info"
                                data-bs-toggle="tooltip"
                                data-bs-placement="right"
                                aria-label="Referral Informations"
                                data-bs-original-title="Referral Informations"
                            ></em>
                        </h6>
                    </div>
                    <div class="nk-refwg-info g-3">
                        <div class="nk-refwg-sub">
                            <div class="title">{{ count($user->referrals) }}</div>
                            <div class="sub-text">Total Joined</div>
                        </div>
                    </div>
                </div>
                <div class="nk-refwg-ck">
                    <div class="chartjs-size-monitor">
                        <div class="chartjs-size-monitor-expand">
                            <div class=""></div>
                        </div>
                        <div class="chartjs-size-monitor-shrink">
                            <div class=""></div>
                        </div>
                    </div>
                    <canvas
                        class="chart-refer-stats chartjs-render-monitor"
                        id="refBarChart"
                        style="display: block; height: 50px; width: 339px"
                        width="508"
                        height="75"
                    ></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<x-slot name="scripts">
    <script>
   

    function referStats(selector, set_data){
        var $selector = (selector) ? $(selector) : $('.chart-refer-stats');
        $selector.each(function(){
            var $self = $(this), _self_id = $self.attr('id'), _get_data = (typeof set_data === 'undefined') ? eval(_self_id) : set_data;
            var selectCanvas = document.getElementById(_self_id).getContext("2d");
            var chart_data = [];
            for (var i = 0; i < _get_data.datasets.length; i++) {
                chart_data.push({
                    label: _get_data.datasets[i].label,
                    data: _get_data.datasets[i].data,
                    // Styles
                    backgroundColor: _get_data.datasets[i].color,
                    borderWidth:2,
                    borderColor: 'transparent',
                    hoverBorderColor : 'transparent',
                    borderSkipped : 'top',
                    barPercentage : .5,
                    categoryPercentage : .7
                });
            } 
            var chart = new Chart(selectCanvas, {
                type: 'bar',
                data: {
                    labels: _get_data.labels,
                    datasets: chart_data,
                },
                options: {
                    legend: {
                        display: false,
                    },
                    maintainAspectRatio: false,
                    tooltips: {
                        enabled: true,
                        rtl: NioApp.State.isRTL,
                        callbacks: {
                            title: function(tooltipItem, data) {
                                return data.datasets[tooltipItem[0].datasetIndex].label;
                            },
                            label: function(tooltipItem, data) {
                                return data.datasets[tooltipItem.datasetIndex]['data'][tooltipItem['index']] + ' ' + _get_data.dataUnit;
                            }
                        },
                        backgroundColor: '#fff',
                        titleFontSize: 13,
                        titleFontColor: '#6783b8',
                        titleMarginBottom: 6,
                        bodyFontColor: '#9eaecf',
                        bodyFontSize: 12,
                        bodySpacing:4,
                        yPadding: 10,
                        xPadding: 10,
                        footerMarginTop: 0,
                        displayColors: false
                    },
                    scales: {
                        yAxes: [{
                            display: false,
                            ticks: {
                                beginAtZero: true
                            },
                        }],
                        xAxes: [{
                            display: false,
                            ticks: {
                                reverse: NioApp.State.isRTL
                            }
                        }]
                    }
                }
            });
        })
    }
    

    function accountSummary(selector, set_data){
        var $selector = (selector) ? $(selector) : $('.chart-account-summary');
        $selector.each(function(){
            var $self = $(this), _self_id = $self.attr('id'), _get_data = (typeof set_data === 'undefined') ? eval(_self_id) : set_data;
            var selectCanvas = document.getElementById(_self_id).getContext("2d");
            var chart_data = [];
            for (var i = 0; i < _get_data.datasets.length; i++) {
                chart_data.push({
                    label: _get_data.datasets[i].label,
                    tension:.4,
                    backgroundColor: 'transparent',
                    borderWidth:2,
                    borderColor: _get_data.datasets[i].color,
                    pointBorderColor: 'transparent',
                    pointBackgroundColor: 'transparent',
                    pointHoverBackgroundColor: "#fff",
                    pointHoverBorderColor: _get_data.datasets[i].color,
                    pointBorderWidth: 2,
                    pointHoverRadius: 4,
                    pointHoverBorderWidth: 2,
                    pointRadius: 4,
                    pointHitRadius: 4,
                    data: _get_data.datasets[i].data,
                });
            } 
            var chart = new Chart(selectCanvas, {
                type: 'line',
                data: {
                    labels: _get_data.labels,
                    datasets: chart_data,
                },
                options: {
                    legend: {
                        display: false,
                    },
                    maintainAspectRatio: false,
                    tooltips: {
                        rtl: NioApp.State.isRTL,
                        callbacks: {
                            title: function(tooltipItem, data) {
                                return data['labels'][tooltipItem[0]['index']];
                            },
                            label: function(tooltipItem, data) {
                                return data.datasets[tooltipItem.datasetIndex]['data'][tooltipItem['index']] + ' ' + _get_data.dataUnit;
                            }
                        },
                        backgroundColor: '#eff6ff',
                        titleFontSize: 13,
                        titleFontColor: '#6783b8',
                        titleMarginBottom: 6,
                        bodyFontColor: '#9eaecf',
                        bodyFontSize: 12,
                        bodySpacing:4,
                        yPadding: 10,
                        xPadding: 10,
                        footerMarginTop: 0,
                        displayColors: false
                    },
                    scales: {
                        yAxes: [{
                            position : NioApp.State.isRTL ? "right" : "left",
                            ticks: {
                                beginAtZero: false,
                                fontSize:12,
                                fontColor:'#9eaecf',
                                padding: 10
                            },
                            gridLines: { 
                                color: NioApp.hexRGB("#526484",.2),
                                tickMarkLength:0,
                                zeroLineColor: NioApp.hexRGB("#526484",.2)
                            },
                        }],
                        xAxes: [{
                            ticks: {
                                fontSize:12,
                                fontColor:'#9eaecf',
                                source: 'auto',
                                padding: 5,
                                reverse: NioApp.State.isRTL
                            },
                            gridLines: {
                                color: "transparent",
                                tickMarkLength:20,
                                zeroLineColor: NioApp.hexRGB("#526484",.2),
                                offsetGridLines: true,
                            }
                        }]
                    }
                }
            });
        })
    }

    // init accountSummary
NioApp.coms.docReady.push(function(){ 
    ajax("{{ route('dashboard.chart') }}", 'GET', function(response){
        // {{-- Ref bar chart --}}
        var refBarChart = {
            labels : response.data.referralUsersLabels,
            dataUnit : 'People',
            datasets : [{
                label : "Joined",
                color : "#6baafe",
                data: response.data.referralUsersData
            }]
        }
        // {{-- Summarybalance --}}
        var summaryBalance = {
            labels : response.data.transactionsLabels,
            dataUnit : "{{ $cur_text }}",
            datasets : [{
                label : "Total Transactions",
                color : "#5ce0aa",
                data  : response.data.transactionsData
            }]
        };

        accountSummary('.chart-account-summary', summaryBalance); 
        console.log(refBarChart)
        referStats('.chart-refer-stats', refBarChart); 
    })

    
});
    </script>
</x-slot>

</x-app-layout>
