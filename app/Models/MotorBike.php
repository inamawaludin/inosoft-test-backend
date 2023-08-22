<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as EloquentModel;

class MotorBike extends EloquentModel
{
    use HasFactory;

    protected $fillable = [
        'mesin',
        'suspensi',
        'transmisi',
        'stok',
        'kendaraan'
    ];
}
