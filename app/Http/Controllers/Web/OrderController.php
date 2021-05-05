<?php

namespace App\Http\Controllers\Web;

use App\Dtos\Order\CreateDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Order\CreateRequest;
use App\Http\Requests\Order\SearchRequest;
use App\Models\Order;
use App\Models\Product;
use App\UseCases\Order\CheckUseCase;
use App\UseCases\Order\CreateUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class OrderController extends Controller
{
    /**
     * Show a preview of the order.
     *
     * @param  \App\Models\Product $product
     * @return  \Illuminate\View\View
     */
    public function preview(Product $product)
    {
        return view('web.order.preview')
        ->with('product', $product);
    }

    /**
     * Create a order.
     *
     * @param \App\Http\Requests\Order\CreateRequest $request
     * @param  \App\Models\Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function generate(CreateRequest $request, Product $product) : JsonResponse
    {
        $dto = CreateDto::fromRequest($request);
        $useCase = new CreateUseCase(new Order(), $product);

        return $useCase->execute($dto);
    }

    /**
     * Show info of the order.
     *
     * @param  \App\Models\Order $order
     * @return  \Illuminate\View\View
     */
    public function check(Order $order) : View
    {
        $useCase = new CheckUseCase($order);
        $useCase->execute();

        return view('web.order.check')
        ->with('order', $order);
    }

    /**
     * Search order by code
     * @param  \App\Http\Requests\Order\SearchRequest $request
     * @return \Illuminate\Http\JsonResponse
     */

     public function search(SearchRequest $request)
     {
        $order = Order::search($request->code)->first();

        if($order)
        {
            return response()->json([
                'message' => 'Orden encontrada',
                'redirect' => route('order.check', $order->code)
            ]);
        }

        return response()->json([
            'message' => 'No hay ninguna orden de compra con ese código',

        ], Response::HTTP_BAD_REQUEST);
     }
}
