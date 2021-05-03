@extends('layouts.master')
@section('prefix',config('app.name'))
@section('app')
<x-web.header />
<div class="w-full mx-auto min-h-screen pt-16 lg:pt-0">
    @yield('content')
</div>
<x-web.footer />
@endsection
@push('scripts')
<script src="{{ mix('js/swal.js') }}"></script>
@endpush
