<?php

namespace App\Http\Controllers;

use App\PurchaseDetail;
use Illuminate\Http\Request;
use App\Product;
use App\Supplier;

class PurchaseDetailController extends Controller
{
    public function index()
    {
        $product = Product::all();
        $idPurchase = session('idPurchase');
        $supplier = Supplier::find(session('idSupplier'));
        return view('purchase_detail.index', compact('product', 'idPurchase', 'supplier'));
    }

    public function listData($id)
    {
        // $purchaseDetail = PurchaseDetail::leftJoin('products', 'products.code_product', '=', 'purchase_details.code_product')
        // ->where('id_purchase', '=', $id)
        // ->get();
        $purchaseDetail = PurchaseDetail::with('product')->where('id_purchase', '=', $id)->get();
        $data = [];
        $total = 0;
        $total_item = 0;
        foreach ($purchaseDetail as $index => $list) {
            $row = [];
            $row[] = ++$index;
            $row[] = $list->code_product;
            $row[] = $list->product->first()->name_product;
            $row[] = 'Rp. ' . format_money($list->product->first()->selling_price);
            $row[] = "<input type='number' class='form-control' name='total_$list->id_purchase_detail' value='$list->total' onChange='changeCount($list->id_purchase_detail)'>";
            $row[] = 'Rp. ' . format_money($list->sub_total);
            $row[] = '<a onclick="deleteItem(' . $list->id_purchase_detail . ')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>';
            $data[] = $row;

            $total += $list->product->first()->selling_price * $list->total;
            $total_item += $list->total;
        }

        $data[] = ["<span class='hide total'>$total</span><span class='hide totalitem'>$total_item</span>", '', '', '', '', '', '', ''];

        $output = ['data' => $data];
        return response()->json($output);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $product = Product::where('code_product', '=', $request['code_product'])->first();
        $purchaseDetail = PurchaseDetail::create(
            array_merge(
                $request->all(),
                [
                    'purchase_price' => $product->purchase_price,
                    'total' => 1,
                    'sub_total' => $product->purchase_price
                ]
        )
        );
        // many to many
        $purchaseDetail->product()->attach($product);
    }

    public function show(PurchaseDetail $purchaseDetail)
    {
        //
    }

    public function edit(PurchaseDetail $purchaseDetail)
    {
        //
    }

    public function update(Request $request, PurchaseDetail $purchaseDetail)
    {
        $name_input = 'total_' . $purchaseDetail->id_purchase_detail;
        $purchaseDetail->total = $request[$name_input];
        $purchaseDetail->sub_total = $purchaseDetail->purchase_price * $request[$name_input];
        $purchaseDetail->update();
    }

    public function destroy(PurchaseDetail $purchaseDetail)
    {
        $purchaseDetail->delete();
    }

    public function loadForm($diskon, $total)
    {
        $bayar = $total - ($diskon / 100 * $total);
        $data = [
            'totalRp' => format_money($total),
            'pay' => $bayar,
            'payRp' => format_money($bayar),
            'paySpelled' => ucwords(spelled_number($bayar)) . ' Rupiah'
        ];
        return response()->json($data);
    }
}
