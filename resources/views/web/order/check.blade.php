@extends('layouts.web')

@section('content')
    <div class="w-full container flex justify-center items-center min-h-screen bg-gray-100 mx-auto">
        <div>
            <h1 class="text-4xl mt-4 text-center">Orden de compra generada</h1>

            <div class="container mx-auto my-4 shadow-md ">
                <table class="w-full mt-4 table-auto">
                    <thead>
                        <tr class="bg-gray-900 text-white">
                            <th>Dato</th>
                            <th>Información</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="py-2 px-4">Estado de la orden de compra: </td>
                            <td class="py-2 px-4">{{ $order->status }}</td>
                        </tr>
                        <tr>
                            <td class="py-2 px-4">Código de rastreo: </td>
                            <td class="py-2 px-4">{{ $order->code }}</td>
                        </tr>
                        <tr>
                            <td class="py-2 px-4">Producto: </td>
                            <td class="py-2 px-4">{{ $order->product_name }}</td>
                        </tr>
                        <tr>
                            <td class="py-2 px-4">Total</td>
                            <td class="py-2 px-4">{{ $order->total }}</td>
                        </tr>
                        <tr>
                            <td class="py-2 px-4">Nombre del comprador</td>
                            <td class="py-2 px-4">{{ $order->customer_name }}</td>
                        </tr>
                        <tr>
                            <td class="py-2 px-4">Correo del comprador</td>
                            <td class="py-2 px-4">{{ $order->customer_email }}</td>
                        </tr>
                        <tr>
                            <td class="py-2 px-4">Celular del comprador</td>
                            <td class="py-2 px-4">{{ $order->customer_mobile }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ mix('js/httpWeb.js') }}"></script>
@endpush