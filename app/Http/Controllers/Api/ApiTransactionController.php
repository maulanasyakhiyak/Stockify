<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ProductStockView;
use App\Models\StockTransaction;

class ApiTransactionController extends Controller
{
    public function index(Request $request){
        // $query = StockTransaction::with('product','user');
        // if($request->has('name')){
        //     $query->where('name', 'like', '%' . $request->input('name') . '%');
        // }
        // if ($request->has('purchase_price')) {
        //     $query->where('purchase_price', '>=' , $request->input('purchase_price'));
        // }
        // if ($request->has('paginate')) {
        //     $products = $query->paginate($request->input('paginate'));
        //     return response()->json($products);
        // }
        // $products = $query->get();
        // return response()->json($products);
        return response()->json(ProductStockView::all());
        
    }
}
