<?php

namespace App\Services\StockTransaction;

use App\Repositories\DetailOpname\DetailOpnameRepository;
use App\Repositories\Product\ProductRepository;
use LaravelEasyRepository\Service;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Repositories\ProductStock\ProductStockRepository;
use App\Repositories\RiwayatOpname\RiwayatOpnameRepository;
use App\Repositories\StockTransaction\StockTransactionRepository;
use Exception;

class StockTransactionServiceImplement extends Service implements StockTransactionService{

     /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
     protected $mainRepository;
     protected $riwayatOpnameRepository;
     protected $productStockRepository;
     protected $detailOpnameRepository;
     protected $productRepository;

    public function __construct(StockTransactionRepository $mainRepository,
                                RiwayatOpnameRepository $riwayatOpnameRepository,
                                ProductStockRepository $productStockRepository,
                                DetailOpnameRepository $detailOpnameRepository,
                                ProductRepository $productRepository)
    {
      $this->mainRepository = $mainRepository;
      $this->riwayatOpnameRepository = $riwayatOpnameRepository;
      $this->productStockRepository = $productStockRepository;
      $this->detailOpnameRepository = $detailOpnameRepository;
      $this->productRepository = $productRepository;
    }

    public function stockOpname($data,$keterangan)
    {
        // Validasi data
        $validator = Validator::make($data, [
            '*.id' => 'required|string|exists:products,id',  // pastikan id ada di tabel products
            '*.value' => 'required|numeric',           // pastikan value berupa angka dan >= 0
        ]);
    
        // Jika validasi gagal, lempar exception
        if ($validator->fails()) {
            throw new ValidationException($validator);
        } 
        
        // Buat riwayat opname
        $riwayat = $this->riwayatOpnameRepository->createRiwayat($keterangan);
        if (!$riwayat) {
            throw new \Exception('Gagal membuat riwayat opname.');
        }else{
            foreach($data as $item){
                // Ambil stok terakhir produk
                $currentStock = $this->productStockRepository->getOne($item['id'], 'stock_akhir');
                if ($currentStock === null) {
                    throw new \Exception("Stok untuk produk ID {$item['id']} tidak ditemukan.");
                }
                if(!$this->productRepository->checkItem($item['id'])){
                  throw new \Exception("produk ID {$item['id']} tidak ditemukan.");
                }
                $selisih = (int) $currentStock - (int) $item['value'];
    
                $detailOpname = $this->detailOpnameRepository->createDetailOpname([
                    'riwayat_opname_id' => $riwayat->id,
                    'product_id' => $item['id'],
                    'stok_fisik' => $item['value'],
                    'stok_sistem' => $currentStock,
                    'selisih' =>$selisih,
                    'keterangan' => $selisih > 0 ? 'Berlebih' : ($selisih < 0 ? 'Kurang' : 'Cocok')
    
                ]);
        
                if (!$detailOpname) {
                    throw new \Exception("Gagal menyimpan detail opname untuk produk ID {$item['id']}.");
                }
            }
            return $riwayat->token;
        }
        
    }

    public function store($data){
        $validator = Validator::make($data, [
            'sku' => 'required|string|exists:products,sku',
            'type' => 'required|in:in,out',
            'quantity' => 'required|numeric',
            'notes' => 'required|string|min:10',
        ], [
            'sku.required' => 'Nama produk wajib diisi.',
            'sku.exists' => 'SKU yang dimasukkan tidak ditemukan.',
            'sku.string' => 'Nama produk harus berupa teks.',
            'type.required' => 'Jenis transaksi (type) wajib diisi.',
            'type.in' => 'Jenis transaksi (type) hanya boleh "in" atau "out".',
            'quantity.required' => 'Jumlah (quantity) wajib diisi.',
            'quantity.numeric' => 'Jumlah (quantity) harus berupa angka.',
            'notes.required' => 'Catatan wajib diisi.',
            'notes.string' => 'Catatan harus berupa teks.',
        ]);

        if ($validator->fails()) {
            return [
                'status' => 'error',
                'message' => $validator->errors()
            ];
        }

        try{
            $result = $this->mainRepository->store($data);
            return [
                'status' => 'success',
                'message' => 'Data berhasil disimpan',
            ];
        }catch(Exception $e){
            return [
                'status' => 'error',
                'message' => $e->getLine() . ' ' . $e->getMessage() . ' ' . $e->getFile()
            ];
        }
    
        return [
            'status' => 'success',
            'message' => 'Data valid!'
        ];
    }
    

    

    // public function getTransactionWithfilter($data){

    //     // Jika 'search' tidak null
    //     if (!empty($data['search'])) {
    //         $search = $data['search'];
    //     }

    //     // Jika 'status' tidak null
    //     if (!empty($data['status']) && is_array($data['status'])) {
    //         $status = $data['status'];
    //     }

    //     // Jika 'type' tidak null
    //     if (!empty($data['type'])) {
    //         $query->where('type', $data['type']);
    //     }

    //     // Jika hanya 'start' dikirim
    //     if (!empty($data['start']) && empty($data['end'])) {
    //         $query->whereDate('created_at', '>=', $data['start']);
    //     }

    //     // Jika hanya 'end' dikirim
    //     if (empty($data['start']) && !empty($data['end'])) {
    //         $query->whereDate('created_at', '<=', $data['end']);
    //     }

    //     // Jika 'start' dan 'end' keduanya dikirim
    //     if (!empty($data['start']) && !empty($data['end'])) {
    //         $query->whereBetween('created_at', [$data['start'], $data['end']]);
    //     }

    //     return $query->get();
    // }
}
