<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SortByOption extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    const A_TO_Z = 1;
    const Z_TO_A = 2;
    const LOW_TO_HIGH = 3;
    const HIGH_TO_LOW = 4;
}
