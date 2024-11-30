<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailOpname extends Model
{
    use HasFactory;

     // Menentukan nama tabel jika tidak sesuai dengan nama model
     protected $table = 'detail_opname';

     // Menentukan kolom yang dapat diisi secara massal
     protected $fillable = [
         'riwayat_opname_id',
         'product_id',
         'stok_fisik',
         'stok_sistem',
         'selisih',
         'keterangan'
     ];
 
     // Relasi dengan RiwayatOpname
     public function riwayatOpname()
     {
         return $this->belongsTo(RiwayatOpname::class, 'riwayat_opname_id');
     }
 
     // Relasi dengan Product
     public function product()
     {
         return $this->belongsTo(Product::class, 'product_id');
     }
}
