<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/*
 * @property foreignId user_id
 * @property tinyInteger status
 * @property tinyInteger payment_status
 * @property unsignedInteger delivery_amount
 * @property unsignedInteger paying_amount
 * @property unsignedInteger total_amount
 */

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'orders';

    protected $fillable = [

        'user_id',
        'status',
        'total_amount',
        'delivery_amount',
        'paying_amount',
        'payment_status',

    ];
}