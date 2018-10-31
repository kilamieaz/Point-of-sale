<?php

namespace App\Http\Controllers;

use App\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        return view('supplier.index');
    }

    public function listData()
    {
        $supplier = Supplier::orderBy('id_supplier', 'desc')->get();
        $data = [];
        foreach ($supplier as $index => $list) {
            $row = [];
            $row[] = ++$index;
            $row[] = $list->name_supplier;
            $row[] = $list->address;
            $row[] = $list->telephone;
            $row[] = '<div class="btn-group">
               <a onclick="editForm(' . $list->id_supplier . ')" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i></a>
               <a onclick="deleteData(' . $list->id_supplier . ')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a></div>';
            $data[] = $row;
        }

        $output = ['data' => $data];
        return response()->json($output);
    }

    public function store(Request $request)
    {
        Supplier::create($request->all());
    }

    public function edit(Supplier $supplier)
    {
        echo json_encode($supplier);
    }

    public function update(Request $request, Supplier $supplier)
    {
        $supplier->update($request->all());
    }

    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
    }
}
