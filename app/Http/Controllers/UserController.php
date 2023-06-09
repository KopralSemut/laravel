<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use function GuzzleHttp\Promise\all;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
public function _construct()
{
    $this->middleware(function($request, $next){
if (Gate::allows('manage-books')) return $next($request); 
    abort(403,'Anda tidak memiliki cukup hak akses');

    });
}

    public function index(Request $request)
    {
        $users = User::paginate(10);
        $filterKeyword = $request->get('keyword');
        $status = $request->get('status');
        
        if ($filterKeyword) {
            if ($status){
                $users = User::where('email','LIKE',"%$filterKeyword%")->where('status',$status)->paginate(10);
            }else{
                $users = User::where('email','LIKE',"%$filterKeyword%")->paginate(10);
            }
        }

        return view('users.index', ['users' => $users]);
    }
   
    public function create()
    {
        return view("users.create");
    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(),[
            "name"=>"required|min:5|max:100",
            "username"=>"required|min:5|max:20|unique:users",
            "roles"=>"required",
            "phone"=>"required|digits_between:10,20",
            "address"=>"required|min:20|max:200",
            "avatar"=>"required",
            "email"=>"required|email|unique:users",
            "password"=>"required",
            "password_confirmation"=>"required|same:password",
        ])->validate();

        $new_user = new User;
        $new_user->name = $request->get('name');
        $new_user->username = $request->get('username');
        $new_user->roles = json_encode($request->get('roles'));
        $new_user->address = $request->get('address');
        $new_user->phone = $request->get('phone');
        $new_user->email = $request->get('email');
        $new_user->password = Hash::make($request->get('password'));

        if ($request->file('avatar')) {
            $file = $request->file('avatar')->store('avatars', 'public');
            $new_user->avatar=$file;
        }
        $new_user->save();
        return redirect()->route('users.create')->with('status', 'User successfully created');
    
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', ['user' => $user]);
    }
    public function update(Request $request, $id)
    {
        $validation = Validator::make($request->all(),[
            "name"=>"required|min:5|max:100",
            "roles"=>"required",
            "phone" => "required|digits_between:10,12",
            "address" => "required|min:20|max:200",
        ])->validate();
        $user = User::findOrFail($id);
        $user->name=$request->get('name');
        $user->roles=json_encode($request->get('roles'));
        $user->address=$request->get('address');
        $user->phone=$request->get('phone');
        $user->status = $request->get('status');

        if ($request->file('avatar')) {
            if ($user->avatar&&file_exists(storage_path('app/public/'.$user->avatar))) {
                Storage::delete('public/'.$user->avatar);
            }
            $file=$request->file('avatar')->store('avatars','public');
            $user->avatar=$file;
        }
        $user->save();
        return redirect()->route('users.edit',[$id])->with('status','User succesfully updated');
    
    }
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('users.show',['user'=>$user]);
    }
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if ($user->avatar) {
            Storage::delete('public/'.$user->avatar);
        }
        $user->delete();
        return redirect()->route('users.index')->with('status', 'User successfully deleted');
    }



}
