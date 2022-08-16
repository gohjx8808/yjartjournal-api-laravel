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
        // return view('emails.payment', [
        //     'paymentOption' => 'Bank Transfer',
        //     'name' => 'tester',
        //     'amount' => number_format(70, 2),
        //     'products' => [[
        //         "id" => "5ijVADxXLTqLqYwVpJelh5",
        //         "quantity" => 1,
        //         "totalPrice" => 25.2
        //     ]],
        //     "totalAmount" => 25.2,
        //     "totalDiscount" => 5,
        //     "shippingFee" => 8,
        //     "totalAfterDiscount" => 28.2,
        //     "note" => 'testing',
        //     'receiverName' => 'test receiver',
        //     'phoneNo' => '1234567',
        //     'addressLine1' => '1, Lorong Test 2',
        //     'addressLine2' => 'Taman Test',
        //     'postcode' => 12300,
        //     'city' => 'test city',
        //     'state' => 'Selangor',
        //     'country' => 'Malaysia'
        // ]);

        Mail::to('jingxuan.goh@capbay.com')->send(new PaymentEmail('asdasd'));
    }
}
