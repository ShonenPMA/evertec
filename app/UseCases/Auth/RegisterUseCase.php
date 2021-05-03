<?php

declare(strict_types=1);

namespace App\UseCases\Auth;

use App\Dtos\Auth\RegisterDto;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class RegisterUseCase
{
    protected $user;

    public function __construct()
    {
        $this->user = new User();
    }

    public function execute(RegisterDto $dto) : JsonResponse
    {
        $this->user->name = $dto->name;
        $this->user->email = $dto->email;
        $this->user->password = bcrypt($dto->password);
        $this->user->phone = $dto->phone;

        $this->user->save();

        return response()->json([
            'message' => 'Usuario registrado',
            'data' => $this->user,
            'redirect' => route('login'),
        ]);
    }
}
