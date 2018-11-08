<?php

namespace App\Http\Controllers;

use App\SalesDetail;
use Illuminate\Http\Request;
use App\Product;
use App\Member;
use App\Setting;
use Redirect;
use App\Sales;
use Auth;
use PDF;

class SalesDetailController extends Controller
{
    // 2.
    public function index()
    {
        $product = Product::all();
        $member = Member::all();
        $setting = Setting::first();

        if (!empty(session('idSales'))) {
            $idSales = session('idSales');
            return view('sales_detail.index', compact('product', 'member', 'setting', 'idSales'));
        } else {
            return Redirect::route('home');
        }
    }

    // 3.
    public function listData($id)
    {
        $salesDetail = SalesDetail::leftJoin('products', 'products.code_product', '=', 'sales_details.code_product')
        ->where('id_sales', '=', $id)
        ->get();
        $no = 0;
        $data = [];
        $total = 0;
        $total_item = 0;
        foreach ($salesDetail as $list) {
            $no++;
            $row = [];
            $row[] = $no;
            $row[] = $list->code_product;
            $row[] = $list->name_product;
            $row[] = 'Rp. ' . format_money($list->selling_price);
            $row[] = "<input type='number' class='form-control' name='total_$list->id_sales_detail' value='$list->total' onChange='changeCount($list->id_sales_detail)'>";
            $row[] = $list->discount . '%';
            $row[] = 'Rp. ' . format_money($list->sub_total);
            $row[] = '<div class="btn-group">
               <a onclick="deleteItem(' . $list->id_sales_detail . ')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>';
            $data[] = $row;

            $total += $list->sub_total;
            $total_item += $list->total;
        }

        $data[] = ["<span class='hide total_price'>$total</span><span class='hide total_item'>$total_item</span>", '', '', '', '', '', '', ''];

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

        $salesDetail = new SalesDetail;
        $salesDetail->id_sales = $request['idSales'];
        $salesDetail->code_product = $request['code_product'];
        $salesDetail->selling_price = $product->selling_price;
        $salesDetail->total = 1;
        $salesDetail->discount = $product->discount;
        $salesDetail->sub_total = $product->selling_price - ($product->discount / 100 * $product->selling_price);
        $salesDetail->save();
        $salesDetail->product()->attach($product);
    }

    public function show(SalesDetail $transaction)
    {
        //
    }

    public function edit(SalesDetail $transaction)
    {
        //
    }

    public function update(Request $request, SalesDetail $transaction)
    {
        $name_input = 'total_' . $transaction->id_sales_detail; // total_2
        $total_harga = $request[$name_input] * $transaction->selling_price; // 2 x selling price
        $transaction->total = $request[$name_input]; //2
        $transaction->sub_total = $total_harga - ($transaction->discount / 100 * $total_harga); //100000 - 10000
        $transaction->update();
    }

    public function destroy(SalesDetail $transaction)
    {
        $transaction->delete();
    }

    // 1. new transaction
    public function newSession()
    {
        $sales = new Sales();
        $sales->id_user = Auth::user()->id;
        $sales->save();

        session(['idSales' => $sales->id_sales]);

        return Redirect::route('transaction.index');
    }

    public function saveData(Request $request)
    {
        $sales = Sales::find($request['idSales']);
        // $sales->code_member = $request['code_member'];
        // $sales->total_item = $request['total_item'];
        // $sales->total_price = $request['total'];
        // // $sales->discount = $request['discount'];
        // // $sales->pay = $request['pay'];
        // $sales->accepted = $request['accepted'];
        $sales->update($request->except('idSales'));

        $salesDetail = SalesDetail::where('id_sales', '=', $request['idsales'])->get();
        foreach ($salesDetail as $data) {
            $product = Product::where('code_product', '=', $data->kode_product)->first();
            $product->stock -= $data->total;
            $product->update();
        }
        return Redirect::route('transaction.print');
    }

    public function loadForm($discount, $total, $accepted)
    {
        $pay = $total - ($discount / 100 * $total);
        $back = ($accepted != 0) ? $accepted - $pay : 0;
        $data = [
            'totalRp' => format_money($total),
            'pay' => $pay,
            'payRp' => format_money($pay),
            'paySpelled' => ucwords(spelled_number($pay)) . ' Rupiah',
            'backRp' => format_money($back),
            'backSpelled' => ucwords(spelled_number($back)) . ' Rupiah'
        ];
        return response()->json($data);
    }

    public function printNota()
    {
        $salesDetail = SalesDetail::leftJoin('products', 'products.code_product', '=', 'sales_details.code_product')
        ->where('id_sales', '=', session('idSales'))
        ->get();

        $sales = Sales::find(session('idSales'));
        $setting = Setting::find(1);

        if ($setting->note_type == 0) {
            $handle = printer_open();
            printer_start_doc($handle, 'Nota');
            printer_start_page($handle);

            $font = printer_create_font('Consolas', 100, 80, 600, false, false, false, 0);
            printer_select_font($handle, $font);

            printer_draw_text($handle, $setting->company_name, 400, 100);

            $font = printer_create_font('Consolas', 72, 48, 400, false, false, false, 0);
            printer_select_font($handle, $font);
            printer_draw_text($handle, $setting->address, 50, 200);

            printer_draw_text($handle, date('Y-m-d'), 0, 400);
            printer_draw_text($handle, substr('             ' . Auth::user()->name, -15), 600, 400);

            printer_draw_text($handle, 'No : ' . substr('00000000' . $sales->id_sales, -8), 0, 500);

            printer_draw_text($handle, '============================', 0, 600);

            $y = 700;

            foreach ($salesDetail as $list) {
                printer_draw_text($handle, $list->code_product . ' ' . $list->name_product, 0, $y += 100);
                printer_draw_text($handle, $list->total . ' x ' . format_uang($list->selling_price), 0, $y += 100);
                printer_draw_text($handle, substr('                ' . format_uang($list->selling_price * $list->total), -10), 850, $y);

                if ($list->diskon != 0) {
                    printer_draw_text($handle, 'Diskon', 0, $y += 100);
                    printer_draw_text($handle, substr('                      -' . format_uang($list->discount / 100 * $list->sub_total), -10), 850, $y);
                }
            }

            printer_draw_text($handle, '----------------------------', 0, $y += 100);

            printer_draw_text($handle, 'Total Harga: ', 0, $y += 100);
            printer_draw_text($handle, substr('           ' . format_uang($sales->total_price), -10), 850, $y);

            printer_draw_text($handle, 'Total Item: ', 0, $y += 100);
            printer_draw_text($handle, substr('           ' . $sales->total_item, -10), 850, $y);

            printer_draw_text($handle, 'Diskon Member: ', 0, $y += 100);
            printer_draw_text($handle, substr('           ' . $sales->discount . '%', -10), 850, $y);

            printer_draw_text($handle, 'Total Bayar: ', 0, $y += 100);
            printer_draw_text($handle, substr('            ' . format_uang($sales->pay), -10), 850, $y);

            printer_draw_text($handle, 'Diterima: ', 0, $y += 100);
            printer_draw_text($handle, substr('            ' . format_uang($sales->accepted), -10), 850, $y);

            printer_draw_text($handle, 'Kembali: ', 0, $y += 100);
            printer_draw_text($handle, substr('            ' . format_uang($sales->accepted - $sales->pay), -10), 850, $y);

            printer_draw_text($handle, '============================', 0, $y += 100);
            printer_draw_text($handle, '-= TERIMA KASIH =-', 250, $y += 100);
            printer_delete_font($font);

            printer_end_page($handle);
            printer_end_doc($handle);
            printer_close($handle);
        }

        return view('sales_detail.finish', compact('setting'));
    }

    public function notaPDF()
    {
        $salesDetail = SalesDetail::leftJoin('products', 'products.code_product', '=', 'sales_details.code_product')
        ->where('id_sales', '=', session('idSales'))
        ->get();

        $sales = Sales::find(session('idSales'));
        $setting = Setting::find(1);

        $pdf = PDF::loadView('sales_detail.notaPdf', compact('salesDetail', 'sales', 'setting'));
        $pdf->setPaper([0, 0, 550, 440], 'potrait');
        return $pdf->stream();
    }
}
