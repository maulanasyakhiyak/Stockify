<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserActivityLog extends Model
{
    use HasFactory;

    protected $table = 'user_activity_logs';

    public $timestamps = false;

    protected $fillable = [
        'user_id', 
        'activity', 
        'description',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->deleting_at = Carbon::now()->subMonth();
            $model->created = Carbon::now();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class); // Menunjukkan bahwa UserActivityLog milik satu User
    }
}
