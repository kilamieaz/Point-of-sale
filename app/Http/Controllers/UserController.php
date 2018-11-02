<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        return view('user.index');
    }

    public function listData()
    {
        $user = User::where('level', '!=', 1)->orderBy('id', 'desc')->get();
        $data = [];
        foreach ($user as $index => $list) {
            $row = [];
            $row[] = ++$index;
            $row[] = $list->name;
            $row[] = $list->email;
            $row[] = '<div class="btn-group">
               <a onclick="editForm(' . $list->id . ')" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i></a>
               <a onclick="deleteData(' . $list->id . ')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a></div>';
            $data[] = $row;
        }

        $output = ['data' => $data];
        return response()->json($output);
    }

    public function store(Request $request)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    public function edit(User $user)
    {
        echo json_encode($user);
    }

    public function update(Request $request, User $user)
    {
        $user->update($request->except('password'));
        if (!empty($request['password'])) {
            $user->password = bcrypt($request['password']);
        }
    }

    public function destroy(User $user)
    {
        $user->delete();
    }

    public function profile()
    {
        $user = Auth::user();
        return view('user.profile', compact('user'));
    }

    public function changeProfile(Request $request, $id)
    {
        $msg = 'succcess';
        $user = User::find($id);
        if (!empty($request['password'])) {
            if (Hash::check($request['oldPassword'], $user->password)) {
                $user->password = bcrypt($request['password']);
            } else {
                $msg = 'error';
            }
        }

        if ($request->hasFile('photo')) {
            Storage::disk('public')->delete($user->photo);
            $user->update([
                'photo' => $request->file('photo')->store('img', 'public')
            ]);
        }
        echo json_encode(['msg' => $msg, 'url' => Storage::url($user->photo())]);
    }
}
