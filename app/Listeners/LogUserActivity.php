<?php

namespace App\Listeners;

use App\Models\UserActivityLog;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogUserActivity
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
{
    UserActivityLog::create([
        'user_id' => $event->userId,        // ID pengguna dari event
        'activity' => $event->activity,    // Jenis aktivitas dari event
        'description' => $event->description, // Deskripsi aktivitas dari event
        'logged_at' => now(),              // Timestamp aktivitas
    ]);
}
}
