<?php

namespace App\Console\Commands;

use App\Models\UserActivityLog;
use Carbon\Carbon;
use Illuminate\Console\Command;

class DeleteOldRecords extends Command
{
    protected $signature = 'records:delete-old';
    protected $description = 'Hapus data yang sudah lama soft delete';

    public function handle()
    {
        $expiredLogs = UserActivityLog::where('deleting_at', '<=', Carbon::now())->get();

        foreach ($expiredLogs as $log) {
          $log->delete();  // Hapus data
        }

        $this->info('Expired logs telah dihapus.');
    }
}
