<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as EloquentModel;

class Car extends EloquentModel
{
    use HasFactory;

    protected $fillable = [
        'mesin',
        'kapasitas_penumpang',
        'tipe',
        'stok',
        'kendaraan'
    ];
}
