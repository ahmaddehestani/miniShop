<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/*
 * @property string display_name
 * @property string name
 */

class Brand extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [

        'display_name',
        'name',
    ];
    protected $table = 'brands';
}