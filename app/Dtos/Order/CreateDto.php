<?php

namespace App\Dtos\Order;

use App\Abstracts\DataTransferObject;
use App\Http\Requests\Order\CreateRequest;

class CreateDto extends DataTransferObject
{
    public $name;
    public $email;
    public $phone;

    public static function fromRequest(CreateRequest $request)
    {
        return new self($request->all());
    }
}
