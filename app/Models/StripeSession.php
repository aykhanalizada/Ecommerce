<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StripeSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id', 'payment_status', 'amount_total', 'currency'
    ];
}
