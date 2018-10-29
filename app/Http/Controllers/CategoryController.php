<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return view('category.index');
    }

    public function listData()
    {
        $category = Category::orderBy('id_category', 'desc')->get();
        $no = 0;
        $data = [];
        foreach ($category as $list) {
            $no++;
            $row = [];
            $row[] = $no;
            $row[] = $list->name_category;
            $row[] = '<div class="btn-group">
               <a onclick="editForm(' . $list->id_category . ')" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i></a>
               <a onclick="deleteData(' . $list->id_category . ')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a></div>';
            $data[] = $row;
        }

        $output = ['data' => $data];
        return response()->json($output);
    }

    public function store(Request $request)
    {
        $category = new Category;
        $category->name_category = $request['name'];
        $category->save();
    }

    public function edit(Category $category)
    {
        echo json_encode($category);
    }

    public function update(Request $request, Category $category)
    {
        $category->name_category = $request['name'];
        $category->update();
    }

    public function destroy(Category $category)
    {
        $category->delete();
    }
}
