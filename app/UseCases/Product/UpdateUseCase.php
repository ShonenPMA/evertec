<?php

declare(strict_types=1);

namespace  App\UseCases\Product;

use App\Dtos\Product\UpdateDto;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Mews\Purifier\Facades\Purifier;

class UpdateUseCase
{
    private $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function execute(UpdateDto $dto) : JsonResponse
    {
        $this->product->name = $dto->name;
        $this->product->slug = $dto->slug;
        $this->product->price = $dto->price;
        $this->product->discount = $dto->discount / 100;
        $this->product->abstract = Purifier::clean($dto->abstract);
        $this->product->description = Purifier::clean($dto->description);

        $this->product->save();

        return response()->json([
            'message' => 'Producto actualizado satisfactoriamente',
            'data' => $this->product,
            'redirect' => route('product.index'),
        ]);
    }
}
