<?php

namespace App\Http\Controllers;

use App\Http\Services\ProductService;

class ProductController extends Controller
{
    public static function getAllProducts()
    {
        $response = (new ProductService)->getAllProducts();
    }
}
