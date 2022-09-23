<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


class RegisterController extends Controller
{
    public function index(){
        return view('register.index', [
            'title' => 'Register'
        ]);
    }

    public function store(Request $request){
        $dataValid = $request-> validate([
            'name'      =>  'required|max:255',
            'username'  =>  ['required', 'min:3', 'max:255', 'unique:users'],
            'email'     =>  'required|email:dns|unique:users',
            'password'  =>  'required|min:6|max:255'
        ]);

        $dataValid['password'] = bcrypt($dataValid['password']);

        if(User::create($dataValid)){
            return redirect('/')->with("success", "Berhasil Membuat Akun!" );
        }else{
            return redirect('/register')->with("error", "Gagal Membuat Akun!");
        }
    }
}
