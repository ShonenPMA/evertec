@extends('layouts.web')

@section('content')
<div class="min-h-screen">
            <div class="container mx-auto my-4 shadow-md ">
                <picture>
                    <img class="max-w-4xl mx-auto block my-4" src="{{$product->image}}" alt="{{ $product->slug }}">
                </picture>
                <div>
                    <h2 class="mt-2 text-2xl text-center font-semibold tracking-widest">{{ $product->name }}</h2>
                    <div class="text-center text-xl my-4">
                        <span class="{{ $product->discount > 0 ? 'line-through text-gray-400' : '' }}">{{ $product->real_price }}</span>
                        @if ($product->discount)
                            <span class="font-bold text-gray-800 ml-4">{{ $product->real_discount }}</span>                         
                        @endif
                    </div>
                    <p class="p-4 mb-4">{!! $product->description !!}</p>
                    <div class="flex justify-center">
                        <a class="text-center font-semibold mx-auto py-2 px-4 my-4 bg-gray-900 text-white transition-all duration-300 hover:bg-gray-400 hover:text-gray-900" href="">Comprar</a>
                    </div>
                </div>
            </div>
    </div>

</div>
@endsection