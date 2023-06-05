<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function postLogin(Request $request)
    {

        if(User::where('email',$request->email)->first())
        {

            if(Auth::attempt($request->only('email','password')))
            {
                return redirect('/');
            } else {
                return redirect()->back()->with('warning','Password Not Found!');
            }
        } else {
            return redirect()->back()->with('warning','This email is not register!');
        }
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function postRegister(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'email'=>'required',
            'password'=>'required',
            'image'=>'required',
        ]);

        $file=$request->file('image');
        $file_name=uniqid(time()). $file->getClientOriginalName();
        $full_path='image/'.$file_name;
        $file->storeAs('image',$file_name);

        $user=User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'image'=> $full_path,
        ]);

        return redirect(url('login'))->with('success','Welcome '.$user->name.'. Please,Login!');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
