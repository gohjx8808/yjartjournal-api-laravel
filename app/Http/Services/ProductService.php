<?php

namespace App\Http\Services;

use App\Contentful\ContentfulAPI;
use App\Http\Repositories\ProductRepository;
use App\Http\Requests\GetAllProductsRequest;
use App\Http\Requests\GetProductDetailsRequest;
use App\Models\SortByOption;
use Contentful\RichText\Renderer;

class ProductService
{
    public static function getAllProducts(GetAllProductsRequest $request)
    {
        $contentful = new ContentfulAPI();
        $sortById = $request->sortBy;
        $nameSearch = $request->nameSearch;

        $sortByKeyword = self::getContentfulOrderByKeyword($sortById);
        $products = $contentful->getAllProducts($sortByKeyword);

        if (!empty($nameSearch)) {
            $products = $products->filter(function ($product) use ($nameSearch) {
                if (stripos($product['name'], $nameSearch)) {
                    return $product;
                };
            })->values();
        }

        $productList = $products->map(function ($product) {
            $productImages = $product->productImage;

            $productData = [
                'id' => $product->getId(),
                'name' => $product->name,
                'images' => self::getProductImagesLinks($productImages),
                'price' => $product->price,
                'category' => ucwords($product->category),
                'discountedPrice' => $product->discountedPrice
            ];

            return $productData;
        })->groupBy('category');

        $data = [
            'products' => $productList,
            'categories' => $productList->keys()
        ];

        return $data;
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

    public static function getContentfulOrderByKeyword(int $sortById)
    {
        switch ($sortById) {
            case SortByOption::A_TO_Z:
                return 'fields.name';
            case SortByOption::Z_TO_A:
                return '-fields.name';
            case SortByOption::LOW_TO_HIGH:
                return 'fields.price';
            case SortByOption::HIGH_TO_LOW:
                return '-fields.price';
        }
    }
}
