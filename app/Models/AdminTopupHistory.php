<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminTopupHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'agentId',
        'topUpUsd',
        'topUpLbp',
        'receivedMoney',
     ];
}
