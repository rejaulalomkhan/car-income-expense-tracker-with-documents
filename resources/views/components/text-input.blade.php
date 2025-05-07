@props(['disabled' => false])

<input {{ $attributes->merge(['class' => 'form-input ' . ($disabled ? 'opacity-50 cursor-not-allowed' : '')]) }}
@disabled($disabled)>
