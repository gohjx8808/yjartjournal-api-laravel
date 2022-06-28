<?php

namespace App\Http\Services;

use App\Contentful\ContentfulAPI;
use Contentful\Delivery\Client;
use Contentful\Delivery\Query;
use Contentful\RichText\Renderer;
use Exception;

class ProductService
{
    public function getAllProducts()
    {
        $renderer = new Renderer();

        $contentful = new ContentfulAPI();
        $query = new Query();
        $query->setContentType('products');
        $products = $contentful->getAllProducts($query);

        $productList = [];

        foreach ($products as $product) {
            $productImages = $product->productImage;
            $imgURLs = collect($productImages)->map(function ($img) {
                return [
                    'filename' => $img->getFile()->getFilename(),
                    'url' => $img->getFile()->getUrl()
                ];
            });
            $productData = [
                'name' => $product->name,
                'images' => $imgURLs,
                'price' => $product->price,
                'description' => $renderer->render($product->contentDescription),
                'category' => $product->category,
                'discountedPrice' => $product->discountedPrice
            ];

            array_push($productList, $productData);
        }

        dd($productList);
    }
}
