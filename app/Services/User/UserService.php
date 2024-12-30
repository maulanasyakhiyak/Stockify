<?php

namespace App\Services\User;

use LaravelEasyRepository\BaseService;

interface UserService extends BaseService{

    public function store($data);

    public function update($data, $id);

    public function destroy($id);

}
