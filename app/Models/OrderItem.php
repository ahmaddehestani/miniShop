<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/*
 * @property foreignId order_id
 * @property foreignId product_id
 * @property unsignedInteger price
 * @property unsignedInteger quantity
 * @property unsignedInteger subtotal
 */


class OrderItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'order_items';

    protected $fillable = [

        'order_id',
        'product_id',
        'price',
        'quantity',
        'subtotal',

    ];
}