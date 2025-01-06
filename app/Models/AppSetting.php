<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppSetting extends Model
{
    use HasFactory;
    protected $table = 'app_settings'; // Menentukan nama tabel jika tidak mengikuti konvensi Laravel

    protected $fillable = [
        'app_name',
        'logo_path',
    ];
}
