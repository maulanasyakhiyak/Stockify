<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Repositories\Supplier\SupplierRepository;

use Illuminate\Http\Request;

class SuppliersController extends Controller
{
    protected $supplierRepository;
    public function __construct(SupplierRepository $supplierRepository)
    {
        $this->supplierRepository = $supplierRepository;
    }
    public function index()
    {
        $suppliers = $this->supplierRepository->index(5);
        return view('adminpage.suplier', compact('suppliers'));
    }
}
