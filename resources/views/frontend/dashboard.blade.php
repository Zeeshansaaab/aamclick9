
@php
    $cur_text = cur_text();
@endphp
<x-app-layout>
    <x-slot name="title">Dashboard</x-slot>

    <x-slot name="breadcrumb">
        <x-breadcrumb currentPage="Dashboard" title="Dashboard"/>
    </x-slot>

    <x-slot name="header">
        <div class="nk-block-between-md g-4">
            <div class="nk-block-head">
                <div class="nk-block-head-sub"><span>Welcome!</span></div>
                <a href="{{route('profile.show')}}" class="nk-block-head-content">
                    <h2 class="nk-block-title fw-normal">{{ $user->name }}
                        <span class="badge badge-primary">{{$user->planUser->plan->name}}</span>
                    </h2>
                    <div class="nk-block-des"><p></p></div>
                </a>
            </div><!-- .nk-block-head-content -->
            <div class="nk-block-head-content">
                <ul class="nk-block-tools gx-3">
                    <li>
                        <a href="{{ route('payment', 'credit') }}" class="btn btn-primary"><span>Deposit</span> <em class="icon ni ni-arrow-long-right"></em></a>
                    </li>
                    <li><a href="{{ route('payment', 'debit') }}" class="btn btn-white btn-light"><span>Withdraw</span> <em class="icon ni ni-arrow-long-right d-none d-sm-inline-block"></em></a></li>
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
                                        <a href="{{ route('reports.payments', ['deposit', 'default']) }}" class="text-white number-lg amount">
                                            {{ currency($user->depositAmount(), true) }}
                                        </a>
                                    </div>
                                    <div class="nk-wg7-stats-group">
                                        <a href="{{route('reports.transactions')}}?keyword=profit_bonus" class="nk-wg7-stats w-100 text-white">
                                            <div class="nk-wg7-title">Profit Balance</div>
                                            <div class="number-lg">{{ currency($user->profitBonus(), true) }}</div>
                                        </a>
                                    </div>
                                    <div class="nk-wg7-foot">
                                        <span class="nk-wg7-note">Last login at
                                            <span>{{formatDateTime($last_login)}}</span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="nk-block" style="padding-top: 20px;">
                    <div class="nk-block-head-xs">
                        <div class="nk-block-head-content">
                            <h6 class="nk-block-title title">Detail</h6>
                        </div>
                    </div>
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
                                        href="#"
                                        ><div class="nk-wgw-name">
                                            <div class="nk-wgw-icon">
                                                <em
                                                    class="icon ni ni-sign-usd"
                                                ></em>
                                            </div>
                                            <h5 class="nk-wgw-title title">
                                                Referral income
                                            </h5>
                                        </div>
                                        <div class="nk-wgw-balance">
                                            <div class="amount">
                                                {{ currency($user->referralIncome(), true) }}<span
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
                                        href="#"
                                        ><div class="nk-wgw-name">
                                            <div class="nk-wgw-icon">
                                                <em
                                                    class="icon ni ni-sign-usd"
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
                                        href="#"
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
                                                {{currency(0)}}<span
                                                    class="currency currency-eth"
                                                    >{{ $cur_text }}</span
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
                                        href="#"
                                        ><div class="nk-wgw-name">
                                            <div class="nk-wgw-icon">
                                                <em
                                                    class="icon ni ni-sign-usd"
                                                ></em>
                                            </div>
                                            <h5 class="nk-wgw-title title">
                                                Bonus Withdraw
                                            </h5>
                                        </div>
                                        <div class="nk-wgw-balance">
                                            <div class="amount">
                                                {{currency(auth()->user()->transactions()->whereType('debit')->where('remark', 'profit_bonus')->sum('amount'))}}<span
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
                                        href="#"
                                        ><div class="nk-wgw-name">
                                            <div class="nk-wgw-icon">
                                                <em
                                                    class="icon ni ni-sign-usd"
                                                ></em>
                                            </div>
                                            <h5 class="nk-wgw-title title">
                                                Total Withdraw
                                            </h5>
                                        </div>
                                        <div class="nk-wgw-balance">
                                            <div class="amount">
                                                {{currency(auth()->user()->withdrawalAmount(), true)}}
                                                <span
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
                                    <a class="nk-wgw-inner"
                                        href="#"
                                    ><div class="nk-wgw-name">
                                            <div class="nk-wgw-icon">
                                                <em
                                                    class="icon ni ni-sign-eth"
                                                ></em>
                                            </div>
                                            <h5 class="nk-wgw-title title">
                                                Reward
                                            </h5>
                                        </div>
                                        <div class="nk-wgw-balance">
                                            <div class="amount">
                                                {{ currency($rewardBonus) }}
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
                                        href="#"
                                        ><div class="nk-wgw-name">
                                            <div class="nk-wgw-icon">
                                                <em
                                                    class="icon ni ni-sign-usd"
                                                ></em>
                                            </div>
                                            <h5 class="nk-wgw-title title">
                                               Committees
                                            </h5>
                                        </div>
                                        <div class="nk-wgw-balance">
                                            <div class="amount">
                                                {{auth()->user()->committees()->count()}}<span
                                                    class="currency currency-nio"
                                                    ></span
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
                                        href="{{route('installments.create')}}"
                                        ><div class="nk-wgw-name">
                                            <div class="nk-wgw-icon">
                                                <em
                                                    class="icon ni ni-sign-usd"
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
                        @if($rewardBonus >= $rewardPlan->price)
                            <div class="col-sm-4">
                                <div class="card bg-success">
                                    <div class="nk-wgw sm">
                                        <form class="nk-wgw-inner text-center" action="{{route('claim-reward')}}" method="post" data-form="ajax-form" data-redirect-url="{{route('dashboard')}}">
                                            <input type="hidden" name="amount" value="{{$rewardBonus}}"/>
                                            <button
                                                class="btn"
                                                href="#"
                                                >
                                                <div class="nk-wgw-balance">
                                                    <div class="amount fw-bold">
                                                       Click here <br/>
                                                        Claim reward
                                                    </div>
                                                </div>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endif
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
                    <h5 class="title">Profit Bonus</h5>
                </div>
            </div>
            <div class="tranx-list card card-bordered">
                @foreach ($transactions as $transaction)
                    <div class="tranx-item">
                        <div class="tranx-col">
                            <div class="tranx-info">
                                <div class="tranx-data">
                                    <div class="tranx-label">
                                        {{ $transaction->details }}
                                        <em
                                            class="tranx-icon sm icon ni ni-sign-usd @if($transaction->type == 'credit') bg-success-dim @else bg-danger-dim @endif"
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
