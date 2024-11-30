<?php

namespace App\Repositories\RiwayatOpname;

use LaravelEasyRepository\Repository;

interface RiwayatOpnameRepository extends Repository{

    public function createRiwayat($keterangan);
    public function findById($id);
    public function RiwayatAll();
    public function update($id,$data);
    public function delete($id);
}
