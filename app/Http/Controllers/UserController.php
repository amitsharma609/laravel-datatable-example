<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use DataTables;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::select('id','name','email')->get();
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function($user){
                    // $btn = '<a href="javascript:void(0)" class="btn btn-primary btn-sm m-1">View</a>';
                    $btn = '<a href="/users/'. $user->id .'/edit" class="btn btn-info btn-sm m-1">Edit</a>';
                    $btn .= '<button class="btn btn-danger btn-sm m-1 delete-button" data-id="'. $user->id .'">Delete</button>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('users.index');
    }

    public function create( Request $request)
    {
        return view( 'users.create');
    }
    public function store( Request $request)
    {
         $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);
        $data = $request->all();
        $check = $this->UserStore($data);
        return redirect()->route('users.index')->with('success', 'User created successfully!');
        // return redirect()->back()->with('success', 'User created successfully!');
    }
    public function UserStore(array $data)
    {
      return User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password'])
      ]);
    }

    public function edit($id)
    {
        $user = User::find($id);
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email,' . $user->id,
    ]);
    $user = User::find($id);
    $user->update($request->all());
    return redirect()->route('users.index')
      ->with('success', 'user updated successfully.');
    }

    public function destroy($id)
    {
        $user = User::find($id);

        if ($user) {
            $user->delete();
            return Response::json(['success' => 'User deleted successfully.']);
        }

        return Response::json(['error' => 'User not found.'], 404);
    }

}
