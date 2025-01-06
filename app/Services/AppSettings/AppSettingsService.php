<?php

namespace App\Services\AppSettings;

use LaravelEasyRepository\BaseService;

interface AppSettingsService extends BaseService{

    public function UpdateApp($data);

}
