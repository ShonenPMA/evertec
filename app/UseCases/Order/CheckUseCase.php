<?php

namespace App\UseCases\Order;

use App\Models\Order;
use App\Traits\AuthTrait;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\HttpException;

class CheckUseCase
{
    use AuthTrait;
    private $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function execute()
    {
        $this->checkStatus();
    }

    protected function getData() : array
    {
        return [
            'auth' => $this->getAuth(),
        ];
    }

    public function checkStatus()
    {
        if ($this->order->status == 'CREATED') {
            try {
                $response = Http::post(
                    config('checkout.URL')."/{$this->order->request_id}",
                    $this->getData()
                );
                $array = $response->json();

                $this->updateOrderStatus($array['status']['status']);
            } catch (HttpException $exception) {
                Log::warning("No se encuentró el servicio disponible para obtener datos de la orden, error :{$exception->getMessage()}");
            } finally {
                return $this;
            }
        }
    }

    protected function updateOrderStatus(string $status)
    {
        switch ($status) {
            case 'APPROVED':
                $this->order->status = 'PAYED';
                break;
            case 'REJECTED':
                $this->order->status = 'REJECTED';
                break;
        }
        $this->order->save();
    }
}
