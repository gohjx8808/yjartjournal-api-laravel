<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetAllProductsRequest;
use App\Http\Requests\GetProductDetailsRequest;
use App\Http\Services\ProductService;

class ProductController extends Controller
{
    public static function getAllProducts(GetAllProductsRequest $request)
    {
        $response =  ProductService::getAllProducts($request);

        return response($response);
    }

    public static function getProductDetails(GetProductDetailsRequest $request)
    {
        $response = ProductService::getProductDetails($request);

        return response($response);
    }

    public static function getSortByOptions()
    {
        $response = ProductService::getAllSortByOptions();

        return response($response);
    }

    public static function getImageGallery()
    {
        $response = ProductService::getProductGalleryImages();

        return response($response);
    }
}
