<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/*
 * @property foreignId brand_id
 * @property foreignId category_id
 * @property string primary_image
 * @property text description
 * @property unsignedInteger price
 * @property unsignedInteger quantity
 * @property unsignedInteger delivery_amount
 */

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'products';

    protected $fillable = [
        'name',
        'brand_id',
        'category_id',
        'primary_image',
        'description',
        'price',
        'quantity',
        'delivery_amount',
    ];

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
}
