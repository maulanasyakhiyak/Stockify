<?php

namespace App\Repositories\DetailOpname;

use LaravelEasyRepository\Repository;

interface DetailOpnameRepository extends Repository{

    public function createDetailOpname($data);

    public function getDataByToken($token, $paginate=null);

}
