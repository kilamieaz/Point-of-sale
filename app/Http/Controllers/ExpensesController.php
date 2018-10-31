<?php

namespace App\Http\Controllers;

use DataTables;
use App\Expenses;
use Illuminate\Http\Request;

class ExpensesController extends Controller
{
    public function index()
    {
        return view('expenses.index');
    }

    public function listData()
    {
        $expenses = Expenses::orderBy('id_expenses', 'desc')->get();
        $data = [];
        foreach ($expenses as $index => $list) {
            $row = [];
            $row[] = ++$index;
            $row[] = date_indonesia(substr($list->created_at, 0, 10), false);
            $row[] = $list->type_expenses;
            $row[] = 'Rp. ' . format_money($list->nominal);
            $row[] = '<div class="btn-group">
                    <a onclick="editForm(' . $list->id_expenses . ')" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i></a>
                    <a onclick="deleteData(' . $list->id_expenses . ')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a></div>';
            $data[] = $row;
        }

        return DataTables::of($data)->escapeColumns([])->make(true);
    }

    public function store(Request $request)
    {
        Expenses::create($request->all());
    }

    public function edit(Expenses $expense)
    {
        echo json_encode($expense);
    }

    public function update(Request $request, Expenses $expense)
    {
        $expense->update($request->all());
    }

    public function destroy(Expenses $expense)
    {
        $expense->delete();
    }
}
