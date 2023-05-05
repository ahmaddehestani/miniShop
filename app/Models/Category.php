<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/*
 * @property unsignedBigInteger parent_id
 * @property string description
 * @property string name
 */

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [

        'parent_id',
        'name',
        'description',
    ];
    protected $table = 'categories';
}