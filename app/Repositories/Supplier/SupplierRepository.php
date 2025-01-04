<?php

namespace App\Repositories\Supplier;

use LaravelEasyRepository\Repository;

interface SupplierRepository extends Repository{

    public function index($page = null, $search = null);
    /**
        * @return bool
    */
    public function destroy($id);

    public function store($data);

    public function update($data, $id);
}
