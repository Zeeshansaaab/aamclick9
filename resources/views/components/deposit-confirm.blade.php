@php
    $cur_text = cur_text();
@endphp
@props([
    'amount',
    'gateway',
    'committees',
    'type'
])
<div class="modal fade" tabindex="-1" id="deposit-confirm" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-lg">
                <div class="nk-block-head nk-block-head-xs text-center">
                    <h5 class="nk-block-title">Confirm {{ $type == 'deposit' ? 'Deposit' : 'Withdrawal'}}</h5>
                    <div class="nk-block-text">
                        <div class="caption-text">You are about to deposit <strong>{{ $amount }}</strong> {{ $cur_text }} for <strong>{{ currency($amount * $gateway->currency_value, true) }}</strong> {{ $gateway->currency }}*</div>
                        <span class="sub-text-sm">Exchange rate: 1 {{ $cur_text }} = {{ currency($gateway->currency_value) }} {{ $gateway->currency }}</span>
                    </div>
                </div>
                <div class="nk-block">
                    <div class="buysell-overview">
                        <ul class="buysell-overview-list">
                            <li class="buysell-overview-item">
                                <span class="pm-title">Pay with</span>
                                <span class="pm-currency">
                                    @if($gateway->image)
                                        <img src="{{ $gateway->image }}" width="30px" height="30px" style="margin-right: 10px;"/>
                                    @endif 
                                    <span>{{ $gateway->name }}</span>
                                </span>
                            </li>
                            <li class="buysell-overview-item">
                                <span class="pm-title">Total</span>
                                <span class="pm-currency">{{ $amount }} {{ $cur_text }}</span>
                            </li>
                        </ul>
                        <div class="sub-text-sm mb-2">* Please follow the instruction below.</div>
                        <div class="border px-4 py-2">
                            {!! $gateway->description !!}
                        </div>
                    </div>
                    <form action="{{ $type == 'deposit' ? route('deposit.confirmed') : route('withdraw.confirmed') }}" method="POST" class="buysell-form" id="deposit_confirmed_form" data-form="ajax-form" data-close="deposit-confirm" data-redirect-url="{{route('reports.payments', [$type == 'deposit' ? 'deposited' : 'withdrawal', request()->deposit_type])}}">
                        <div class="buysell-field form-group">
                            <div class="form-label-group justify-content-center border">
                                <label class="form-label">Please fill these fields*</label>
                            </div>
                            @php
                                $parameters = is_array($gateway->gateway_parameters) ? $gateway->gateway_parameters : json_decode($gateway->gateway_parameters, true);
                            @endphp
                            @foreach ($parameters as $input)
                                <div class="form-group">
                                    <x-input-label class="text-capitalize" for="{{ $input['name'] }}" value="{{ $input['label'] }}"/>
                                    <div class="form-control-wrap">
                                        <x-text-input 
                                            id="{{ $input['name'] }}" 
                                            class="form-control text-capitalize" 
                                            type="{{ $input['type'] }}" 
                                            placeholder="{{ $input['label'] }}" 
                                            name="parameters[{{ $input['name']  }}]"
                                            required 
                                        />
                                    </div>
                                </div>
                            @endforeach
                            @if(request()->deposit_type == 'committee')
                                
                                    <div class="buysell-field form-group">
                                        <div class="form-label-group">
                                            <label class="form-label" for="buysell-amount">Committees</label>
                                        </div>
                                        <div class="form-control-group">
                                            <select class="form-control" name="committee_id" required>
                                                <option disabled selected value="">Select Type</option>
                                                @foreach ($committees as $committee)
                                                    <option value="{{ $committee->plan->id }}">{{ $committee->plan->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div><!-- Deposit type -->
                            @endif
                        </div><!-- .buysell-field -->
                        <input type="hidden" name="method_id" value="{{ $gateway->id }}" />
                        <div class="buysell-field form-action text-center">
                            <div>
                                <button type="submit" class="btn btn-primary btn-lg">Confirm the Deposit</button>
                            </div>
                            <div class="pt-3">
                                <a href="#" data-dismiss="modal" class="link link-danger">Cancel Deposit</a>
                            </div>
                        </div>
                    </form>
                </div><!-- .nk-block -->
            </div><!-- .modal-body -->
        </div><!-- .modal-content -->
    </div><!-- .modla-dialog -->
</div>