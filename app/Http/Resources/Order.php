<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Order extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'product' => $this->product_name,
            'buyer' => $this->customer_name,
            'state' => $this->real_status,
            'total' => "S/. {$this->total}",
            'detail' => '<a class="edit p-2 bg-yellow-600 text-white" href="'.route('order.check', $this).'">VER DETALLE</a>',
        ];
    }
}
