<header class="bg-gray-800 text-white p-4 flex justify-between items-center">
    <div class="w-1/3">
        <h1 class="text-xl text-center uppercase">
            <a href="{{ route('welcome') }}">{{ config('app.name') }}</a>
        </h1>
    </div>
    <div class="w-2/3 flex justify-end">
        @guest
            <a class="mr-2 border-white border-2 rounded-md p-2" href="{{ route('register') }}">Registrarme</a>
            <a class="mr-2 border-white bg-white border-2 rounded-md p-2 text-gray-800" href="{{ route('login') }}">Iniciar sesión</a>
        @endguest

        @auth
            <a 
                class="mr-2 border-white border-2 rounded-md p-2" 
                onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                href="">Cerrar Sesión</a>
            <form id="logout-form" action="{{ route('logout')}}" method="POST" style="display: none;">@csrf</form>
            
        @endauth
    </div>
</header>