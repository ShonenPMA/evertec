<?php

namespace App\Dtos\Auth;

use App\Abstracts\DataTransferObject;
use App\Http\Requests\Authentication\RegisterRequest;

class RegisterDto extends DataTransferObject
{
    public $email;
    public $password;
    public $name;
    public $phone;

    public static function fromRequest(RegisterRequest $request)
    {
        return new self($request->all());
    }
}
