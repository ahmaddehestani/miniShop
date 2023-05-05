<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/*
 * @property foreignId province_id
 * @property string name
 */

class City extends Model
{
    use HasFactory;
    protected $table = 'cities';

    protected $fillable = [

        'province_id',
        'name',

    ];
}