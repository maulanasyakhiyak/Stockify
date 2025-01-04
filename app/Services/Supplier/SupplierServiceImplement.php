<?php

namespace App\Services\Supplier;

use Exception;
use LaravelEasyRepository\Service;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Repositories\Supplier\SupplierRepository;

class SupplierServiceImplement extends Service implements SupplierService{

     /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
     protected $mainRepository;

    public function __construct(SupplierRepository $mainRepository)
    {
      $this->mainRepository = $mainRepository;
    }

    public function store($data){
      $data['phone'] = preg_replace('/[^\d+]/', '', $data['phone']);
      $validator = Validator::make($data,[
        'name' => 'required|string|max:255',
        'address' => 'required|string|max:500',
        'phone' => 'required',
        'email' => 'required|email|max:255',
      ], [
        'name.required' => 'Nama wajib diisi.',
        'name.string' => 'Nama harus berupa teks.',
        'name.max' => 'Nama tidak boleh lebih dari 255 karakter.',
        
        'email.required' => 'Email wajib diisi.',
        'email.email' => 'Format email tidak valid.',
        'email.max' => 'Email tidak boleh lebih dari 255 karakter.',
        
        'phone.required' => 'Nomor telepon wajib diisi.',
        'phone.numeric' => 'Nomor telepon harus berupa angka.',
        'phone.min' => 'Nomor telepon minimal terdiri dari 10 angka.',
        
        'address.required' => 'Alamat wajib diisi.',
        'address.string' => 'Alamat harus berupa teks.',
        'address.max' => 'Alamat tidak boleh lebih dari 500 karakter.',
      ]);
      if ($validator->fails()) {
        throw new ValidationException($validator);
      }
      try {
        $this->mainRepository->store($data);
        return [
          'status' => true,
          'message' => 'Berhasil menambahkan supplier',
        ];
      } catch (Exception $e) {
        return [
          'status' => false,
          'message' => 'Gagal menambahkan supplier : ' . $e->getMessage(),
        ];
      }
    
    }

    public function update($data, $id){
      $data['phone'] = preg_replace('/[^\d+]/', '', $data['phone']);
      $validator = Validator::make($data,[
        'name' => 'required|string|max:255',
        'address' => 'required|string|max:500',
        'phone' => 'required',
        'email' => 'required|email|max:255',
      ], [
        'name.required' => 'Nama wajib diisi.',
        'name.string' => 'Nama harus berupa teks.',
        'name.max' => 'Nama tidak boleh lebih dari 255 karakter.',
        
        'email.required' => 'Email wajib diisi.',
        'email.email' => 'Format email tidak valid.',
        'email.max' => 'Email tidak boleh lebih dari 255 karakter.',
        
        'phone.required' => 'Nomor telepon wajib diisi.',
        'phone.numeric' => 'Nomor telepon harus berupa angka.',
        'phone.min' => 'Nomor telepon minimal terdiri dari 10 angka.',
        
        'address.required' => 'Alamat wajib diisi.',
        'address.string' => 'Alamat harus berupa teks.',
        'address.max' => 'Alamat tidak boleh lebih dari 500 karakter.',
      ]);
      if ($validator->fails()) {
        throw new ValidationException($validator);
      }
      try {
        $this->mainRepository->update($data,$id);
        return [
          'status' => true,
          'message' => 'Berhasil update supplier',
        ];
      } catch (Exception $e) {
        return [
          'status' => false,
          'message' => 'Gagal update supplier : ' . $e->getMessage(),
        ];
      }
    }

    // Define your custom methods :)
}
