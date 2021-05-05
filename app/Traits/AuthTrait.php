<?php

namespace App\Traits;

use Carbon\Carbon;

trait AuthTrait
{
    public function getAuth() : array
    {
        $nonce = config('checkout.NONCE');
        $seed = Carbon::now()->addMinutes(5)->toIso8601String();
        $tranKey = base64_encode(sha1($nonce.$seed.config('checkout.SECRETKEY'), true));

        return [
            'login' => config('checkout.LOGIN'),
            'tranKey' => $tranKey,
            'nonce' => base64_encode($nonce),
            'seed' => $seed,
        ];
    }
}
