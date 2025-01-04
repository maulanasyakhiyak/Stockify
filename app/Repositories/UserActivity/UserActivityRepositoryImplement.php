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
    /**
     * @param string $date Tanggal dalam format 'Y-m-d H:i:s' (contoh: 2025-01-04 09:50:52)
     */
    protected $model;

    public function __construct(UserActivityLog $model)
    {
        $this->model = $model;
    }

    public function get_activity($date){
        $query =  $this->model->query()->with('user')
        ->when($date, function ($query) use ($date) {
            $query->where('created','>=', $date);
        });
        $activity = $query->get();

        return $activity;
    }
}
