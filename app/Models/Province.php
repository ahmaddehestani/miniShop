<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/*
 * @property string name
 */

class Province extends Model
{
    use HasFactory;
    protected $table = 'provinces';

    protected $fillable = [

        'name',

    ];
}