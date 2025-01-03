<?php

namespace App\Repositories\UserActivity;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\UserActivityLog;

class UserActivityRepositoryImplement extends Eloquent implements UserActivityRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;

    public function __construct(UserActivityLog $model)
    {
        $this->model = $model;
    }

    public function get_activity(){
        $userActivityLogs = UserActivityLog::with('user')->get();
        dd($userActivityLogs);

        return $data;
    }
}
