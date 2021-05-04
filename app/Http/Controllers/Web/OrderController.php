<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Show a preview of the order
     * 
     * @param  \App\Models\Product 
     * @return  \Illuminate\View\View
     */ 
    public function preview(Product $product)
    {
        return view('web.order.preview')
        ->with('product', $product);
    }
}
