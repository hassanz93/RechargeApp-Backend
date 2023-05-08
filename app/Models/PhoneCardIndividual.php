<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhoneCardIndividual extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'userSoldId',
        'transactionId',
        'cardDetailsId',
        'code',
        'expiryDate',
        'status',
    ];
}
