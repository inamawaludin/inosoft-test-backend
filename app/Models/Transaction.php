<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as EloquentModel;

class Transaction extends EloquentModel
{
    use HasFactory;

    protected $collection = 'transaksi';
    protected $primaryKey = '_id';

    protected $fillable = [
        'name',
        'tanggal',
        'total_item',
        'total_price',
        'items'
    ];
}
