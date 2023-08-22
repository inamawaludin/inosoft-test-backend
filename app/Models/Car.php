<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as EloquentModel;

class Car extends EloquentModel
{
    use HasFactory;

    protected $collection = 'mobil';
    protected $primaryKey = '_id';

    protected $fillable = [
        'mesin',
        'kapasitas_penumpang',
        'tipe',
        'stok',
        'kendaraan'
    ];
}
