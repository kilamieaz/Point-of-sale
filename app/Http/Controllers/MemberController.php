<?php

namespace App\Http\Controllers;

use App\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index()
    {
        return view('member.index');
    }

    public function listData()
    {
        $member = Member::orderBy('id_member', 'desc')->get();
        $data = [];
        foreach ($member as $index => $list) {
            $row = [];
            $row[] = "<input type='checkbox' name='id_member[]'' value='" . $list->id_member . "'>";
            $row[] = ++$index;
            $row[] = $list->code_member;
            $row[] = $list->name_member;
            $row[] = $list->address;
            $row[] = $list->telephone;
            $row[] = '<div class="btn-group">
               <a onclick="editForm(' . $list->id_member . ')" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i></a>
               <a onclick="deleteData(' . $list->id_member . ')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a></div>';
            $data[] = $row;
        }

        $output = ['data' => $data];
        return response()->json($output);
    }

    public function store(Request $request)
    {
        if (!Member::where('code_member', '=', $request['code_member'])->count()) {
            Member::create($request->all());
            echo json_encode(['msg' => 'success']);
        } else {
            echo json_encode(['msg' => 'error']);
        }
    }

    public function edit(Member $member)
    {
        echo json_encode($member);
    }

    public function update(Request $request, Member $member)
    {
        $member->update($request->all());
        echo json_encode(['msg' => 'success']);
    }

    public function destroy(Member $member)
    {
        $member->delete();
    }
}
