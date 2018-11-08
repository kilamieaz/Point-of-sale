<?php

namespace App\Http\Controllers;

use App\Sales;
use Illuminate\Http\Request;
use App\SalesDetail;

class SalesController extends Controller
{
    public function index()
    {
        return view('sales.index');
    }

    public function listData()
    {
        $sales = Sales::with('user')
        ->orderBy('sales.id_sales', 'desc')
        ->get();
        $data = [];

        foreach ($sales as $index => $list) {
            $row = [];
            $row[] = ++$index;
            $row[] = date_indonesia($list->created_at);
            $row[] = $list->code_member;
            $row[] = $list->total_item;
            $row[] = 'Rp. ' . format_money($list->total_price);
            $row[] = $list->discount . '%';
            $row[] = 'Rp. ' . format_money($list->pay);
            $row[] = $list->user->name;
            $row[] = '<div class="btn-group">
               <a onclick="showDetail(' . $list->id_sales . ')" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>
               <a onclick="deleteData(' . $list->id_sales . ')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
              </div>';
            $data[] = $row;
        }

        $output = ['data' => $data];
        return response()->json($output);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Sales $sales)
    {
        // $salesDetail = SalesDetail::leftJoin('products', 'products.code_product', '=', 'sales_details.code_product')
        $salesDetail = SalesDetail::with('product')
        ->where('id_sales', '=', $sales->id_sales)
        ->get();
        $data = [];
        foreach ($salesDetail as $index => $list) {
            $row = [];
            $row[] = ++$index;
            $row[] = $list->code_product;
            $row[] = $list->name_product;
            $row[] = 'Rp. ' . format_money($list->selling_price);
            $row[] = $list->total;
            $row[] = 'Rp. ' . format_money($list->sub_total);
            $data[] = $row;
        }

        $output = ['data' => $data];
        return response()->json($output);
    }

    public function edit(Sales $sales)
    {
        //
    }

    public function update(Request $request, Sales $sales)
    {
        //
    }

    public function destroy(Sales $sales)
    {
        $sales->delete();

        $salesDetail = SalesDetail::where('id_sales', '=', $sales->id_sales)->get();
        foreach ($salesDetail as $data) {
            $product = Product::where('code_product', '=', $data->code_product)->first();
            $product->stock += $data->total;
            $product->update();
            $data->delete();
        }
    }
}
