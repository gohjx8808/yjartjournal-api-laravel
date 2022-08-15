<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetAllProductsRequest;
use App\Http\Requests\GetProductDetailsRequest;
use App\Http\Services\ProductService;
use App\Mail\PaymentEmail;
use Illuminate\Support\Facades\Mail;

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

    public static function testEmail()
    {
        $data = ['message' => 'This is a test!'];

        return view('emails.payment',[ 'test_message' => $data['message'] ]);

        // Mail::to('jingxuan.goh@capbay.com')->send(new PaymentEmail($data));
    }
}
