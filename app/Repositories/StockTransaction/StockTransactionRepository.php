<?php

namespace App\Repositories\StockTransaction;

use LaravelEasyRepository\Repository;

interface StockTransactionRepository extends Repository{

    public function searchTransaction($search);

    public function getStockTransaction($searchFilter = null, $status = null, $type = null ,$start = null,$end = null);

    public function getFirstDate();

    public function get_stock_for_chart($range);

    public function store($data);

    public function get_total_transaction($option='in');

    public function get_total_stock();

    public function laporanStokBarang($date_start = null, $date_end = null, $kategoriId = null);

    public function laporan_barang_masuk_keluar($type);

    public function get_receive_today();

    public function get_dispatched_today();
}
