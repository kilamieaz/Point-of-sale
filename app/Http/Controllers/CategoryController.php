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
        $categories = Category::orderBy('id_category', 'desc')->get();
        $data = [];
        foreach ($categories as $index => $list) {
            $row = [];
            $row[] = ++$index;
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
        Category::create($request->all());
    }

    public function edit(Category $category)
    {
        echo json_encode($category);
    }

    public function update(Request $request, Category $category)
    {
        $category->update($request->all());
    }

    public function destroy(Category $category)
    {
        $category->delete();
    }
}
