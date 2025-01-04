<?php

namespace App\Services\Supplier;

use LaravelEasyRepository\BaseService;

interface SupplierService extends BaseService{
    /**
        * Simpan pengguna baru.
        * @return array{status: bool, message: string}
        * Data yang dibutuhkan:
        * - `name`
        * - `email`
        * - `phone`
        * - `address`
    */
    public function store($data);

    /**
        * Simpan pengguna baru.
        * @return array{status: bool, message: string}
        * Data yang dibutuhkan:
        * - `name`
        * - `email`
        * - `phone`
        * - `address`
    */
    public function update($data,$id);

}
