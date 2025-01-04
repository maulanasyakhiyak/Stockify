<?php

namespace App\Services\UserActivity;

use LaravelEasyRepository\BaseService;

interface UserActivityService extends BaseService{

    public function getActivities($range = 'All time');

}
