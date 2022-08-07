<?php

namespace App\Http\Controllers;

use App\Http\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public static function getOrderHistory()
    {
        $response = OrderService::getOrderHistory();

        return response($response);
    }
}
