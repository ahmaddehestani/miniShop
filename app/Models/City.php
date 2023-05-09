<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/*
 * @property foreignId province_id
 * @property string name
 */

class City extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'cities';

    protected $fillable = [

        'province_id',
        'name',

    ];
}
