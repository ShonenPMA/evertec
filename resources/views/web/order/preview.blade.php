@extends('layouts.web')

@section('content')
    <div class="w-full container flex justify-center items-center min-h-screen bg-gray-100 mx-auto">
        <div>
            <h1 class="text-4xl mt-4 text-center">Generar orden de compra</h1>

            <div>
                <form class="my-16 block max-w-4xl mx-auto">
                    @method('POST')
                    <x-web.form.input
                        placeholder="Nombre"
                        name="name"
                        :required="true"
                        :autofocus="true"
                    />
                    <x-web.form.input
                        placeholder="Correo"
                        name="email"
                        :required="true"
                    />
                    <x-web.form.input
                        placeholder="Celular"
                        name="phone"
                        :required="true"
                    />
                    
                    <button type="submit" class="w-full mt-4 px-1 py-2 border border-gray-400 text-white rounded-md bg-gray-800">
                    Generar orden</button>
                        
    
    
                </form>
                <div class="container mx-auto my-4 shadow-md ">
                    <h1 class="text-4xl mt-4 text-center my-4">Producto a comprar</h1>
                    <table class="w-full mt-4 table-auto">
                        <thead>
                            <tr class="bg-gray-900 text-white">
                                <th>Vista previa</th>
                                <th>Nombre</th>
                                <th>Precio</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <picture>
                                        <img class="max-w-xs mx-auto block my-4" src="{{$product->image}}" alt="{{ $product->slug }}">
                                    </picture>
                                </td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->total_price}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ mix('js/httpWeb.js') }}"></script>
@endpush