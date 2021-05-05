<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Dtos\Product\CreateDto;
use App\Dtos\Product\UpdateDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\CreateRequest;
use App\Http\Requests\Product\UpdateRequest;
use App\Http\Resources\ProductCollection;
use App\Models\Product;
use App\UseCases\Product\CreateUseCase;
use App\UseCases\Product\UpdateUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
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

        return new ProductCollection(Product::orderBy('name', 'ASC')->paginate($size));
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
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return  \Illuminate\View\View
     */
    public function edit(Product $product) : View
    {
        $data['title'] = "Editar producto {$product->name}";
        $data['action'] = route('product.update', $product);
        $data['method'] = 'PUT';
        $data['product'] = $product;

        return view('web.product.form')
        ->with('data', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Product\UpdateRequest  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request, Product $product) : JsonResponse
    {
        $dto = UpdateDto::fromRequest($request);
        $useCase = new UpdateUseCase($product);

        return $useCase->execute($dto);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Product $product) : RedirectResponse
    {
        $product->delete();

        return redirect()->back();
    }

    /**
     * Show a preview of the product.
     *
     * @param  \App\Models\Product $product
     * @return  \Illuminate\View\View
     */
    public function preview(Product $product)
    {
        return view('web.product.preview')
        ->with('product', $product);
    }
}
