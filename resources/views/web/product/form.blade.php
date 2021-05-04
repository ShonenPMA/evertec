@extends('layouts.web')

@section('content')
    <div class="w-full container flex justify-center items-center min-h-screen bg-gray-100 mx-auto">
        <div>
            <h1 class="text-4xl mt-4 text-center">{{ $data['title'] }}</h1>

            <form action="{{ $data['action'] }}" class="my-16 block max-w-4xl mx-auto">
                @method($data['method'])
                <x-web.form.input
                    placeholder="Nombre"
                    name="name"
                    :required="true"
                    :autofocus="true"
                />

                <x-web.form.input
                    placeholder="Precio"
                    name="price"
                    :required="true"

                />
                <x-web.form.input
                    placeholder="Descuento (1-100)"
                    name="discount"
                    :required="true"

                />

                <x-web.form.tiny
                    label="Resumen"
                    name="abstract"
                    value=""
                />

                <x-web.form.tiny
                    label="Descripción"
                    name="description"
                    value=""
                />
                
                

                <button type="submit" class="w-full mt-4 px-1 py-2 border border-gray-400 text-white rounded-md bg-gray-800">
                Crear producto</button>
                    


            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ mix('js/httpWeb.js') }}"></script>
@endpush