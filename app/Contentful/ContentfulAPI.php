<?php

namespace App\Contentful;

use Contentful\Delivery\Client;

class ContentfulAPI
{
    private $client;

    public function __construct()
    {
        $this->client = new Client(config('contentful.delivery.token'), config('contentful.delivery.space'));
    }

    public function getAllProducts($query = null)
    {
        $entry = $this->client->getEntries($query);

        return $entry;
    }
}
