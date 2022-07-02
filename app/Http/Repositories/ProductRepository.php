<?php

namespace App\Http\Repositories;

use App\Models\SortByOption;

class ProductRepository
{
    public static function getAllSortByOptions()
    {
        return SortByOption::all();
    }
}
