<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Repositories\Supplier\SupplierRepository;
use App\Services\Supplier\SupplierService;
use Exception;
use Illuminate\Http\Request;

class SuppliersController extends Controller
{
    protected $supplierRepository;
    protected $supplierService;
    public function __construct(SupplierRepository $supplierRepository,
                                SupplierService $supplierService)
    {
        $this->supplierRepository = $supplierRepository;
        $this->supplierService = $supplierService;
    }
    public function index()
    {
        // dd(session());
        $suppliers = $this->supplierRepository->index(5);
        return view('adminpage.suplier', compact('suppliers'));
    }

    public function updateSupplier(Request $r, $id){
        $result = $this->supplierService->updateService( $r->except(['_token', '_method']), $id);
        if ($result['success']) {
            return response()->json([
                'success' => true,
                'id' => $id,
                'data' =>$r->except(['_token', '_method'])
            ]);
        } else {
            return response()->json([
                'success' => false,
                'errors' => $result['message'],
                'id' => $id,
                'data' =>$r->except(['_token', '_method'])
            ]);
        }
    }
}
