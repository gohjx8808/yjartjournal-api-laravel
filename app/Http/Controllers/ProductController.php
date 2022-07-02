<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetProductDetailsRequest;
use App\Http\Services\ProductService;

class ProductController extends Controller
{
    public static function getAllProducts()
    {
        $response =  ProductService::getAllProducts();

        return response($response);
    }

    public static function getProductDetails(GetProductDetailsRequest $request)
    {
        $response = ProductService::getProductDetails($request);

        return response($response);
    }

    public static function getSortByOptions(){
        $response = ProductService::getAllSortByOptions();

        return response($response);
    }
}
