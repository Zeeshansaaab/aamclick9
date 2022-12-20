@props(['messages'])

@if ($messages)

    <ul {{ $attributes->merge(['class' => '']) }}>
        @foreach ((array) $messages as $message)
            <li><span class="invalid text-sm text-danger">{{ $message }}</span></li>
        @endforeach
    </ul>
@endif
