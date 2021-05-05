<header class="bg-gray-800 text-white p-4 flex justify-between items-center">
    <div class="w-1/4">
        <h1 class="text-xl text-center uppercase">
            <a href="{{ route('welcome') }}">{{ config('app.name') }}</a>
        </h1>
    </div>
    <div class="w-3/4 flex justify-end items-center">
        <form action="{{ route('order.search') }}" method="POST" class="w-full mr-8">
            <div class="flex mx-4 w-7/12">
                <input type="text" name="code" class="w-full p-2 text-gray-800 block" placeholder="Busca tu orden de compra por medio de tu codigo de rastreo" required>
                <button class="border px-2" type="submit">Buscar</button>
            </div>
        </form>
        @guest
        <div class="w-5/12">
            <a class="mr-2 border-white border-2 rounded-md p-2" href="{{ route('register') }}">Registrarme</a>
            <a class="mr-2 border-white bg-white border-2 rounded-md p-2 text-gray-800" href="{{ route('login') }}">Iniciar sesión</a>
        </div>
            
        @endguest

        @auth
        <div class="w-5/12">
            @can('list-orders')
            <a  
                class="mr-2 border-white border-2 rounded-md p-2" 
                href="{{ route('order.index') }}">
                Ordenes
            </a>
            @endcan
            @can('list-products')
            <a  
                class="mr-2 border-white border-2 rounded-md p-2" 
                href="{{ route('product.index') }}">
                Productos
            </a>
            @endcan
        

            <a 
                class="mr-2 border-white border-2 rounded-md p-2" 
                onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                href="">Cerrar Sesión</a>
            <form id="logout-form" action="{{ route('logout')}}" method="POST" style="display: none;">@csrf</form>
        </div>
        @endauth
    </div>
</header>