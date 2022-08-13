<?php

namespace App\Http\Repositories;

use App\Models\PromoCode;

class PromoCodeRepository
{
    public static function getPromoCodeByCode($code)
    {
        return PromoCode::query()
            ->with('promoType')
            ->where('code', $code)
            ->first();
    }
}
