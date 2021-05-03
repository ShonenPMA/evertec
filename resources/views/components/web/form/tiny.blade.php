<div>
    <label for="{{ $name }}">{{ $label }}</label>

    <div class="w-full">
        <textarea class="w-full" name="{{ $name }}" id="{{ $name }}">{!! $value !!}</textarea>
        <input type="hidden" id="hinput{{$name}}" class="hinput">
        {{-- <input type="hidden" id="tinyMCE_logo" value="{{ asset('images/icon.png') }}" > --}}
        {{-- <input type="hidden" id="tinyMCE_logo_reverse" value="{{ asset('images/icon-reverse.png') }}" > --}}
    </div>
</div>
@once
    @push('scripts')
    <script src="{{ mix('js/tinyMCE.js') }}"></script>
    @endpush
@endonce

