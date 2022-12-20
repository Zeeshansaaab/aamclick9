@props(['disabled' => false, 'type', 'id' => 'password'])

@if($type == 'password')
<div class="form-control-wrap">
    <a href="#" class="form-icon form-icon-right passcode-switch lg" data-target="{{ $id }}">
        <em class="passcode-icon icon-show icon ni ni-eye"></em>
        <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
    </a>
    <input type="password" class="form-control form-control-lg" id="{{ $id }}" placeholder="Enter your passcode" {{ $attributes }}>
</div>
@elseif ($type == 'checkbox')
    <input type="checkbox" class="custom-control-input" id="checkbox" {{ $attributes }}>
@else
<input type="{{ $type }}" {!! $attributes->merge(['class' => 'form-control form-control-lg']) !!}>
@endif