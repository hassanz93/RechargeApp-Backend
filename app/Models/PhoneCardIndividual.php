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
        'cardDetailsId',
        'code',
        'expiryDate',
        'status',
    ];
}
