<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/*
 * @property foreignId product_id
 * @property string image
 * @property text description
*/

class ProductImage extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'product_images';

    protected $fillable = [

        'product_id',
        'image',

    ];
}