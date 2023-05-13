<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgentTopupHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'agentId',
        'resellerId',
        'topUpUsd',
        'topUpLbp',
        'receivedMoney',
     ];
}
