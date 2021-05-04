<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Product extends JsonResource
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
            'name' => $this->name,
            'price' => 'S/. '.number_format($this->price),
            'discount' => $this->discount,
            'total_views' => $this->total_views,
            'total_orders' => $this->total_orders,
            'buttonEdit' => '<a class="edit p-2 bg-yellow-600 text-white" href="'.route('product.edit', $this).'">EDITAR</a>',
            'buttonDelete' => '<a class="delete p-2 bg-red-600 text-white" href="'.route('product.destroy', $this).'">ELIMINAR</a>',
        ];
    }
}
