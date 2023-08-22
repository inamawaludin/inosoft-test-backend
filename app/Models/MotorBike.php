<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as EloquentModel;

class MotorBike extends EloquentModel
{
    use HasFactory;

    protected $collection = 'motor';
    protected $primaryKey = '_id';

    protected $fillable = [
        'mesin',
        'suspensi',
        'transmisi',
        'stok',
        'kendaraan'
    ];
}
