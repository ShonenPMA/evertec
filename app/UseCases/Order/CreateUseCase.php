<?php

namespace App\UseCases\Order;

use App\Dtos\Order\CreateDto;
use App\Models\Order;
use App\Models\Product;
use App\Traits\AuthTrait;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpKernel\Exception\HttpException;

class CreateUseCase
{
    use AuthTrait;

    private $order;
    private $product;

    public function __construct(Order $order, Product $product)
    {
        $this->order = $order;
        $this->product = $product;
    }

    public function execute(CreateDto $dto)
    {
        return $this
            ->generateOrder($dto)
            ->checkout();
    }

    public function generateOrder(CreateDto $dto)
    {
        DB::beginTransaction();
        $this->order->customer_name = $dto->name;
        $this->order->customer_email = $dto->email;
        $this->order->customer_mobile = $dto->phone;
        $this->order->code = uniqid('EVERTEC');

        $this->order->product_name = $this->product->name;
        $this->order->total = $this->product->raw_price;
        $this->order->save();

        return $this;
    }

    public function checkout()
    {
        try {
            $response = Http::post(
                config('checkout.URL'),
                $this->getData()
            );
            $array = $response->json();

            $this->updateOrderData($array);

            return response()->json([
                'message' => 'Orden de compra generada',
                'redirect' => $array['processUrl'],
            ]);
        } catch (HttpException $exception) {
            DB::rollback();

            return response()->json([
               'message' => 'El servicio no se encuentra disponible, intentalo mas tarde',
           ], Response::HTTP_BAD_REQUEST);
        }
    }

    protected function updateOrderData(array $response)
    {
        $this->order->request_id = $response['requestId'];

        $this->order->save();
        DB::commit();
    }

    protected function getBuyer() : array
    {
        return [
            'name' => $this->order->customer_name,
            'email' => $this->order->customer_email,
            'mobile' => $this->order->customer_mobile,
        ];
    }

    protected function getPayment() : array
    {
        return [
            'reference' => $this->order->code,
            'description' => $this->order->product_name,
            'amount' => [
                'currency' => 'PEN',
                'total' => $this->order->total,
            ],
            'allowPartial' => false,
        ];
    }

    protected function getData() : array
    {
        return [
            'buyer' => $this->getBuyer(),
            'auth' => $this->getAuth(),
            'payment' => $this->getPayment(),
            'returnUrl' => route('order.check', $this->order),
            'expiration' => Carbon::now()->addMinutes(30)->toIso8601String(),
            'ipAddress' => '127.0.0.1',
            'userAgent' => 'PlacetoPay Sandbox',
        ];
    }
}
