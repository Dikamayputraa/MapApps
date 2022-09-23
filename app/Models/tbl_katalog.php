<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_katalog extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = "tbl_katalog";
    protected $fillable = ['nama_produk', 'berat', 'harga', 'gambar', 'keterangan'];
}
