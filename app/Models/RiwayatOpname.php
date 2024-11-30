<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatOpname extends Model
{
    use HasFactory;

    protected $table = 'riwayat_opname';

    // Menentukan kolom yang dapat diisi secara massal
    protected $fillable = [
        'id',
        'token',
        'tanggal_opname',
        'user_id',
        'notes',
    ];

    // Menentukan kolom 'id' sebagai string (UUID)
    protected $casts = [
        'id' => 'string', // Mengonversi 'id' ke string, karena UUID disimpan sebagai string
    ];

    // Non-auto-incrementing ID
    public $incrementing = false;
    
    // Jenis key menggunakan string (UUID)
    protected $keyType = 'string';

    /**
     * Relasi satu ke banyak dengan DetailOpname
     */
    public function detailOpnames()
    {
        return $this->hasMany(DetailOpname::class, 'riwayat_opname_id');
    }

    /**
     * Relasi dengan User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
