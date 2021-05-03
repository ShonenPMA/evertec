<?php

namespace App\Dtos\Auth;

use App\Abstracts\DataTransferObject;
use App\Http\Requests\Authentication\LoginRequest;

class LoginDto extends DataTransferObject
{
    public $email;

    public $password;

    public static function fromRequest(LoginRequest $request) : self
    {
        return new self($request->all());
    }
}
