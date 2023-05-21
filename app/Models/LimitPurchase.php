<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LimitPurchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'usdLimit',
        'lbpLimit',
    ];
}
