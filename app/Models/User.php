<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory;
    use Notifiable;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'role',
        'email_verified_at'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function stockTransactions()
    {
        return $this->hasMany(StockTransaction::class);
    }
    public function activityLogs()
    {
        return $this->hasMany(UserActivityLog::class); // Menunjukkan bahwa User dapat memiliki banyak UserActivityLog
    }
}
