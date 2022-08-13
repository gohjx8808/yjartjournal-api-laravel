<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromoType extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    const NUMBER_TEXT = 'number';
    const PERCENTAGE_TEXT = 'percentage';
}
