<?php

namespace App\Dtos\Product;

use App\Abstracts\DataTransferObject;
use App\Http\Requests\Product\CreateRequest;

class CreateDto extends DataTransferObject
{
    public $name;
    public $price;
    public $discount;
    public $abstract;
    public $description;
    public $slug;

    public static function fromRequest(CreateRequest $request)
    {
        return new self($request->all());
    }
}
