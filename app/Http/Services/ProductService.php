<?php

namespace App\Http\Services;

use App\Contentful\ContentfulAPI;
use App\Http\Repositories\ProductRepository;
use App\Http\Requests\GetProductDetailsRequest;
use Contentful\RichText\Renderer;

class ProductService
{
    public static function getAllProducts()
    {
        $contentful = new ContentfulAPI();
        $products = $contentful->getAllProducts();

        $productList = [];

        foreach ($products as $product) {
            $productImages = $product->productImage;

            $productData = [
                'id' => $product->getId(),
                'name' => $product->name,
                'images' => self::getProductImagesLinks($productImages),
                'price' => $product->price,
                'category' => $product->category,
                'discountedPrice' => $product->discountedPrice
            ];

            array_push($productList, $productData);
        }

        return $productList;
    }

    public static function getProductDetails(GetProductDetailsRequest $request)
    {
        $productId = $request->productId;

        $contentful = new ContentfulAPI();
        $details = $contentful->getSingleProduct($productId);

        $renderer = new Renderer();

        $productImages = $details->productImage;

        $productDetails = [
            'id' => $details->getId(),
            'name' => $details->name,
            'images' => self::getProductImagesLinks($productImages),
            'price' => $details->price,
            'description' => $renderer->render($details->contentDescription),
            'category' => $details->category,
            'discountedPrice' => $details->discountedPrice
        ];

        return $productDetails;
    }

    public static function getProductImagesLinks($productImages)
    {
        return collect($productImages)->map(function ($img) {
            return [
                'filename' => $img->getFile()->getFilename(),
                'url' => $img->getFile()->getUrl()
            ];
        });
    }

    public static function getAllSortByOptions()
    {
        $options = ProductRepository::getAllSortByOptions();

        $optionList = $options->map(function ($option) {
            return ['value' => $option->id, 'label' => $option->name];
        });

        return $optionList;
    }
}
