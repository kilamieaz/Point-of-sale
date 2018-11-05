<?php

namespace App\Http\Controllers;

use App\Purchase;
use Illuminate\Http\Request;
use App\Supplier;
use Illuminate\Support\Facades\Redirect;
use App\PurchaseDetail;
use App\Product;

class PurchaseController extends Controller
{
    public function index()
    {
        $supplier = Supplier::all();
        return view('purchase.index', compact('supplier'));
    }

    public function listData()
    {
        // $purchase = Purchase::leftJoin('suppliers', 'suppliers.id_supplier', '=', 'purchases.id_supplier')
        // ->orderBy('purchases.id_purchase', 'desc')
        // ->get();
        $purchase = Purchase::with('supplier')->orderBy('purchases.id_purchase', 'desc')->get();
        $data = [];
        foreach ($purchase as $index => $list) {
            $row = [];
            $row[] = ++$index;
            $row[] = date_indonesia($list->created_at);
            $row[] = $list->supplier->name_supplier;
            $row[] = $list->total_item;
            $row[] = 'Rp. ' . format_money($list->total_price);
            $row[] = $list->discount . '%';
            $row[] = 'Rp. ' . format_money($list->pay);
            $row[] = '<div class="btn-group">
               <a onclick="showDetail(' . $list->id_purchase . ')" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>
               <a onclick="deleteData(' . $list->id_purchase . ')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
              </div>';
            $data[] = $row;
        }

        $output = ['data' => $data];
        return response()->json($output);
    }

    public function create($id)
    {
        $purchase = new Purchase();
        $supplier = Supplier::find($id);
        // purchase belongsTo supplier
        $purchase->supplier()->associate($supplier)->save();
        session(['idPurchase' => $purchase->id_purchase]);
        session(['idSupplier' => $id]);

        return Redirect::route('purchase_detail.index');
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        $purchaseDetail = PurchaseDetail::with('product')->where('id_purchase', '=', $id)->get();
        $data = [];
        foreach ($purchaseDetail as $index => $list) {
            $row = [];
            $row[] = ++$index;
            $row[] = $list->product->first()->code_product;
            $row[] = $list->product->first()->name_product;
            $row[] = 'Rp. ' . format_money($list->product->first()->purchase_price);
            $row[] = $list->jumlah;
            $row[] = 'Rp. ' . format_money($list->product->first()->purchase_price * $list->total);
            $data[] = $row;
        }

        $output = ['data' => $data];
        return response()->json($output);
    }

    public function edit(Purchase $purchase)
    {
        //
    }

    public function update(Request $request, Purchase $purchase)
    {
        //
    }

    public function destroy(Purchase $purchase)
    {
        $purchase->delete();

        $purchaseDetail = PurchaseDetail::where('id_purchase', '=', $purchase->id_purchase)->get();
        foreach ($purchaseDetail as $data) {
            $product = Product::where('code_product', '=', $data->code_product)->first();
            $product->stock -= $data->total;
            $product->update();
            $data->delete();
        }
    }
}
