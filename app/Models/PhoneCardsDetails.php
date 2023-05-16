<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhoneCardsDetails extends Model
{
    use HasFactory;


      protected $fillable = [
        'name',
        'categoryId',
        'type',
        'dollarPrice',
        'validity' ,
        'purchaseQuantity',
        'grace',
        'show',
        'lowQuantity',
        'imageUrl',
        'currencySoldIn'
    ];
}
