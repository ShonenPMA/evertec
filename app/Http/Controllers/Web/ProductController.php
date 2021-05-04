<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Dtos\Product\CreateDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\CreateRequest;
use App\Http\Resources\ProductCollection;
use App\Models\Product;
use App\UseCases\Product\CreateUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Display a view.
     *
     * @return  \Illuminate\View\View
     */
    public function index() : View
    {
        return view('web.product.index')
        ->with('total', Product::count());
    }

    public function list() : ProductCollection
    {
        $size = request()->get('size') ?? 5;

        return new ProductCollection(Product::where('id', '<>', auth()->user()->id)->orderBy('name', 'ASC')->paginate($size));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return  \Illuminate\View\View
     */
    public function create() : View
    {
        $data['title'] = 'Nuevo producto';
        $data['action'] = route('product.store');
        $data['method'] = 'POST';
        $data['product'] = null;

        return view('web.product.form')
        ->with('data', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Product\CreateRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateRequest $request) : JsonResponse
    {
        $dto = CreateDto::fromRequest($request);
        $useCase = new CreateUseCase(new Product());

        return $useCase->execute($dto);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
