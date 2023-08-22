<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as EloquentModel;

class Vehicle extends EloquentModel
{
    use HasFactory;

    protected $collection = 'kendaraan';
    protected $primaryKey = '_id';


    protected $fillable = [
        'tahun_keluaran',
        'warna',
        'harga',
        'stok'
    ];
}
