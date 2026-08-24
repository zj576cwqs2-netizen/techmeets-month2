<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable = [
        'payment_intent_id',
        'amount',
        'currency',
        'status',
    ];
}
