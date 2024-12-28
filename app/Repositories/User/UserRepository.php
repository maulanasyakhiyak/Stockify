<?php

namespace App\Repositories\User;

use LaravelEasyRepository\Repository;

interface UserRepository extends Repository{

    public function index($page = null, $search = null);

    public function store($data);

    public function update($data,$id);

    public function find($id);
}
