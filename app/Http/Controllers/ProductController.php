<?php

namespace App\Http\Controllers;

use PDF;
use App\Product;
use App\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('product.index', compact('categories'));
    }

    public function listData()
    {
        $products = Product::with('category')->get();
        $data = [];
        foreach ($products as $index => $list) {
            $row = [];
            $row[] = "<input type='checkbox' name='id_product[]'' value='" . $list->id_product . "'>";
            $row[] = ++$index;
            $row[] = $list->code_product;
            $row[] = $list->name_product;
            $row[] = $list->category->name_category;
            $row[] = $list->brand;
            $row[] = 'Rp. ' . format_money($list->purchase_price);
            $row[] = 'Rp. ' . format_money($list->selling_price);
            $row[] = $list->discount . '%';
            $row[] = $list->stock;
            $row[] = "<div class='btn-group'>
                   <a onclick='editForm(" . $list->id_product . ")' class='btn btn-primary btn-sm'><i class='fa fa-pencil'></i></a>
                  <a onclick='deleteData(" . $list->id_product . ")' class='btn btn-danger btn-sm'><i class='fa fa-trash'></i></a></div>";
            $data[] = $row;
        }

        return DataTables::of($data)->escapeColumns([])->make(true);
    }

    public function store(Request $request)
    {
        if (!Product::where('code_product', '=', $request['code_product'])->count()) {
            $product = Product::create($request->all());
            echo json_encode(['msg' => 'success']);
        } else {
            echo json_encode(['msg' => 'error']);
        }
    }

    public function edit(Product $product)
    {
        echo json_encode($product);
    }

    public function update(Request $request, Product $product)
    {
        $product->update($request->all());
        echo json_encode(['msg' => 'success']);
    }

    public function destroy(Product $product)
    {
        $product->delete();
    }

    public function deleteSelected(Request $request)
    {
        foreach ($request['id_product'] as $id) {
            $product = Product::find($id);
            $product->delete();
        }
    }

    public function printBarcode(Request $request)
    {
        $dataProduct = [];
        foreach ($request['id_product'] as $id) {
            $product = Product::find($id);
            $dataProduct[] = $product;
        }
        $no = 1;
        $pdf = PDF::loadView('product.barcode', compact('dataProduct', 'no'));
        $pdf->setPaper('a4', 'potrait');
        return $pdf->stream();
    }
}
