<?php

namespace App\Dtos\Product;

use App\Abstracts\DataTransferObject;
use App\Http\Requests\Product\UpdateRequest;

class UpdateDto extends DataTransferObject
{
    public $name;
    public $price;
    public $discount;
    public $abstract;
    public $description;
    public $slug;

    public static function fromRequest(UpdateRequest $request)
    {
        return new self($request->all());
    }
}
