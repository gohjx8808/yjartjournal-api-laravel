<?php

namespace App\Http\Repositories;

use App\Models\PromoCode;

class PromoCodeRepository
{
    public static function getPromoCodeByCode($code)
    {
        return PromoCode::where('code', $code)->first();
    }
}
