<?php

namespace App\Contentful;

use Contentful\Delivery\Client;
use Contentful\Delivery\Query;

class ContentfulAPI
{
    private $client;

    public function __construct()
    {
        $this->client = new Client(config('contentful.delivery.token'), config('contentful.delivery.space'));
    }

    public function getAllProducts(string $orderByKeyword)
    {
        $query = new Query();
        $query->setContentType('products')->orderBy($orderByKeyword);
        $entry = $this->client->getEntries($query);

        return collect($entry->getItems());
    }

    public function getSingleProduct(string $id)
    {
        $entry = $this->client->getEntry($id);

        return $entry;
    }
}
