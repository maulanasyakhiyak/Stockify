<?php

namespace App\Services\StockTransaction;

use LaravelEasyRepository\Service;
use App\Repositories\StockTransaction\StockTransactionRepository;

class StockTransactionServiceImplement extends Service implements StockTransactionService{

     /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
     protected $mainRepository;

    public function __construct(StockTransactionRepository $mainRepository)
    {
      $this->mainRepository = $mainRepository;
    }

    public function getTransactionWithfilter($data){

        // Jika 'search' tidak null
        if (!empty($data['search'])) {
            $search = $data['search'];
        }

        // Jika 'status' tidak null
        if (!empty($data['status']) && is_array($data['status'])) {
            $status = $data['status'];
        }

        // Jika 'type' tidak null
        if (!empty($data['type'])) {
            $query->where('type', $data['type']);
        }

        // Jika hanya 'start' dikirim
        if (!empty($data['start']) && empty($data['end'])) {
            $query->whereDate('created_at', '>=', $data['start']);
        }

        // Jika hanya 'end' dikirim
        if (empty($data['start']) && !empty($data['end'])) {
            $query->whereDate('created_at', '<=', $data['end']);
        }

        // Jika 'start' dan 'end' keduanya dikirim
        if (!empty($data['start']) && !empty($data['end'])) {
            $query->whereBetween('created_at', [$data['start'], $data['end']]);
        }

        return $query->get();
    }
}
