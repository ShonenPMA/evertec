@extends('layouts.web')

@section('content')
    <div class="w-full container bg-gray-100 mx-auto mt-8 py-8">
        <h1 class="text-4xl text-center mb-8">Listado de productos</h1>
        <div class="w-full my-4 px-4">
            <a 
                class="border-white bg-gray-800 text-white border-2 rounded-md p-2" 
                href="{{ route('product.create') }}">Nuevo producto</a>
        </div>
        @if ($total > 0)
        <table id="products">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Descuento</th>
                    <th>Total de visitas</th>
                    <th>Total de ordenes</th>
                    <th>Editar</th>
                    <th>Eliminar</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>

        @else
            No hay productos registrados
        @endif

    </div>
@endsection

@push('scripts')
    <script src="{{ mix('js/httpWeb.js') }}"></script>
    <script src="{{ mix('js/products.js') }}"></script>
@endpush