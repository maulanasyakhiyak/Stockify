<?php

namespace App\Services\UserActivity;

use LaravelEasyRepository\Service;
use App\Repositories\UserActivity\UserActivityRepository;
use Carbon\Carbon;

class UserActivityServiceImplement extends Service implements UserActivityService{

     /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
     protected $mainRepository;

    public function __construct(UserActivityRepository $mainRepository)
    {
      $this->mainRepository = $mainRepository;
    }

    public function getActivities($range = 'All time'){
      switch($range){
        case '1 day':
          $date = Carbon::now()->startOfDay()->format('Y-m-d H:i:s');
          break;
        case '7 days':
          $date = Carbon::now()->subDays(7)->format('Y-m-d H:i:s');
          break;
        case '1 month':
          $date = Carbon::now()->subMonth()->format('Y-m-d H:i:s');
          break;
        default:
          $date = Carbon::now()->subMonth()->format('Y-m-d H:i:s');
          session(['activity'=>[ 'range' => '1 month' ]]);
          break;
        }
        // dd($range);
        return $this->mainRepository->get_activity($date);
    }
    // Define your custom methods :)
}
