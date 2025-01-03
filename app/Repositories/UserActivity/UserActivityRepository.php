<?php

namespace App\Repositories\UserActivity;

use LaravelEasyRepository\Repository;

interface UserActivityRepository extends Repository{
    public function get_activity();
}
