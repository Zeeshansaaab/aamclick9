@props([
    'gateways'
])
<ul class="buysell-pm-list">
    @foreach ($gateways as $gateway)
        <li class="buysell-pm-item">
            <input required class="buysell-pm-control" value="{{ $gateway->id }}" type="radio" name="method_id" data-min-amount="{{ $gateway->min_amount }}" data-max-amount="{{ $gateway->max_amount }}" data-currency-value="{{ $gateway->currency_value }}" data-currency="{{ $gateway->currency }}" id="{{ $gateway->slug }}">
            <label class="buysell-pm-label" for="{{ $gateway->slug }}">
                <span class="pm-name">{{ $gateway->name }}</span>
                @if($gateway->image)
                <span class="pm-icon">
                    <img src="{{ $gateway->image }}" width="30px" height="30px" />
                </span>
                @endif
            </label>
        </li>
    @endforeach
    
</ul>