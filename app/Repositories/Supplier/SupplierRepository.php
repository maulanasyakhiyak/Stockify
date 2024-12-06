<?php

namespace App\Repositories\Supplier;

use LaravelEasyRepository\Repository;

interface SupplierRepository extends Repository{

    public function index($page = null, $search = null);

    public function updateSupplier($data, $id);
}
