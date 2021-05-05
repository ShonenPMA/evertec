@extends('layouts.web')

@section('content')
    <div class="w-full container bg-gray-100 mx-auto mt-8 py-8">
        <h1 class="text-4xl text-center mb-8">Listado de ordenes</h1>

        @if ($total > 0)
        <table id="orders">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Comprador</th>
                    <th>Estado</th>
                    <th>Total</th>
                    <th>Ver detalle</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>

        @else
            No hay ordenes generadas
        @endif

    </div>
@endsection

@push('scripts')
    <script src="{{ mix('js/httpWeb.js') }}"></script>
    <script src="{{ mix('js/orders.js') }}"></script>
@endpush