@php
    $cur_text = cur_text();
@endphp
<x-app-layout>
    <x-slot name="title">{{$type == 'deposit' ? 'Deposit' : 'Withdraw'}}</x-slot>
    <x-slot name="breadcrumb">
        <x-breadcrumb currentPage="{{$type == 'deposit' ? 'Deposit' : 'Withdraw'}}" title="{{$type == 'deposit' ? 'Deposit' : 'Withdraw'}}" :links="['dashboard' => 'dashboard']"/>
    </x-slot>
    <x-slot name="header">
    </x-slot>
    <div class="buysell wide-xs m-auto">
        <div class="buysell-title text-center">
            <h3 class="title">What do you want to {{$type == 'deposit' ? 'Deposit' : 'Withdraw'}}!</h3>
        </div><!-- .buysell-title -->
        <div class="buysell-block" id="deposit-block">
            <form action="{{ $type == 'deposit' ? route('deposit.confirm') . '?type=deposit' : route('withdraw.confirm') . '?type=withdraw'  }}" method="POST" class="buysell-form" id="deposit_form" data-form="ajax-form" data-backend-modal="deposit-confirm">
                <div class="buysell-field form-group">
                    <div class="form-label-group">
                        <label class="form-label">Payment Method</label>
                    </div>
                    <div class="form-pm-group">
                        <x-gateways-dropdown :gateways="$gateways"/>
                    </div>
                </div><!-- Payment method -->
                @php
                    $types = $type == 'deposit' ? config('payment')['deposit'] : config('payment')['withdrawal'];
                @endphp
                <div class="buysell-field form-group">
                    <div class="form-group">
                        <label class="form-label">Deposit type</label>
                        <div class="form-control-wrap">
                            <select class="form-select" name="deposit_type" required>
                                <option disabled selected value="">Select Type</option>
                                @foreach ($types as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div><!-- Deposit type -->

                <div class="buysell-field form-group">
                    <div class="form-label-group">
                        <label class="form-label" for="buysell-amount">Amount to Deposit</label>
                    </div>
                    <div class="form-control-group">
                        <input type="text" class="form-control form-control-lg form-control-number" id="buysell-amount" name="amount" placeholder="0.055960" required>
                        <div class="form-dropdown">
                            <div class="text">{{ $cur_text }}</div>
                        </div>
                    </div>
                    <div class="form-note-group">
                        <span id="buysell-min" class="buysell-min form-note-alt"></span>
                        <span id="buysell-max" class="buysell-min form-note-alt"></span>
                        <span class="buysell-rate form-note-alt" id="buysell-rate"></span>
                    </div>
                </div><!-- Amount -->
                
                <div class="buysell-field form-action">
                    <button type="submit" class="btn btn-lg btn-block btn-primary">Continue to Deposit</button>
                </div><!-- .buysell-field -->
                <div class="form-note text-base text-center">Note: our transfer fee included, <a href="#">see our fees</a>.</div>
            </form><!-- .buysell-form -->
        </div><!-- .buysell-block -->
    </div>
    <x-slot name="scripts">
        <script>
            NioApp.coms.docReady.push(function(){ 
                $(document).on('change', '[name=method_id]', function(){
                    $('#buysell-min').text('Minimum: ' + $(this).data('min-amount') + '{{ $cur_text }}')
                    $('#buysell-max').text('Maximum: ' + $(this).data('max-amount') + '{{ $cur_text }}')
                    $('#buysell-rate').text("1 {{ $cur_text }} = " + parseFloat($(this).data('currency-value')).toFixed(2) + " " + $(this).data('currency'))
                })
                
            })
        </script>
    </x-slot>
</x-app-layout>