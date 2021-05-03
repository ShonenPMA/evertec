<header class="bg-gray-800 text-white p-4 flex justify-between items-center">
    <div class="w-1/3">
        <h1 class="text-xl text-center uppercase">
            <a href="{{ route('welcome') }}">{{ config('app.name') }}</a>
        </h1>
    </div>
    <div class="w-2/3 flex justify-end">
        @guest
            <a class="mr-2 border-white border-2 rounded-md p-2" href="">Registrarme</a>
            <a class="mr-2 border-white bg-white border-2 rounded-md p-2 text-gray-800" href="">Iniciar sesión</a>
        @endguest
    </div>
</header>