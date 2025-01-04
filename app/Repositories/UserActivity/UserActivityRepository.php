<?php

namespace App\Repositories\UserActivity;

use LaravelEasyRepository\Repository;

interface UserActivityRepository extends Repository{
    /**
     * @param string $date Tanggal dalam format 'Y-m-d H:i:s' (contoh: 2025-01-04 09:50:52)
     */
    public function get_activity($date);
}
