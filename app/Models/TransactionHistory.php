<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionHistory extends Model
{
    use HasFactory;
    protected $fillable = [
        'userId',
        'card',
        'quantity',
        'usdPayed',
        'lbpPayed'
    ];
}
