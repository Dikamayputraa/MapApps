<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Info_location;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(){
        return view('/dashboard.index', [
            'title' => "Dashboard",
            "posts" => Info_location::latest()->paginate(7)->WithQueryString(),
            "no" => 1
        ]);
    }

    public function store(Request $request){
        $dataValid = $request->validate([
            'title'  => 'required',
            'address'=> 'required',
            'coordinate' => 'required',
            'rating'     => 'required',
            'description'=> 'required'
        ]);

        if(Info_location::create($dataValid)){
            return redirect('/dashboard')->with('success', 'Berhasil Menambah Lokasi');
        }
            return redirect('/dashboard')->with('error', 'Gagal Berhasil Menambah Lokasi!');
    }

    public function logout(){ 
        Auth::logout();
        return redirect('/')->with('logout', 'Berhasil Logout!');
    }

    // public function show(Info_location $post){
    //     return view('post', [
    //         "title" => "Single Post",
    //         "act" => "posts",
    //         "post" => $post
    //     ]);
    // }
}
