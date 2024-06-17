<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buah extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'harga',
        'berat',
        'satuan_berat',
        'stok',
        'gambar',
    ];
}
