<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function view()
    {
        return view('web.welcome')
        ->with('products', Product::orderBy('name', 'ASC')->get());
    }
}
