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
        $suppliers = $this->supplierRepository->index();
        return view('adminpage.suplier', compact('suppliers'));
    }

    public function store(Request $request){
        // dd($request->all());
        $result = $this->supplierService->store($request->except('_token'));
        if(!$result){
            return redirect()->back()->withErrors($result['message']);
        }
        return redirect()->route('admin.supplier.index')->with('success',$result['message']);
    }

    public function destroy($id){
        $result = $this->supplierRepository->destroy($id);
        if(!$result){
            return redirect()->back()->withErrors('Error menghapus data');
        }
        return redirect()->back()->with('success','Berhasil menghapis data');

    }

    public function update(Request $request, $id){
        $result = $this->supplierService->update($request->except('_token','_method'),$id);
        if(!$result){
            return redirect()->back()->withErrors($result['message']);
        }
        return redirect()->route('admin.supplier.index')->with('success',$result['message']);
    }
}
