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
        'tanggal',
        'jumlah',
    ];
}
