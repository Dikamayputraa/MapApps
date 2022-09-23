<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use app\Models\tbl_katalog;

class Barang extends Controller
{
    //
    public function getData(){
        $data = DB::table('tbl_katalog')->get();
        if(count($data) > 0){
            $res['message'] = "Success!";
            $res['value']   = $data;

            return response($res);
        }else{
            $res['message'] = "Data Empty!";
            return response($res);
        }
    }

    public function store(Request $request){
        // validasi
        $this->validate($request, [
            'file' => 'required|max:2048'
        ]);

        //menyimpan data file yang diupload ke variable $file
        $file = $request->file('file');
        $namaFile = time()."_".$file->getClientOriginalName();

        //membuat nama file dimana tujuan file diupload
        $tujuanUpload = 'data_file';

        if ($file->move($tujuanUpload, $namaFile)) {
            $data = tbl_katalog::create([
                'nama_produk' => $request->nama_produk,
                'berat' => $request->berat,
                'harga' => $request->harga,
                'gambar' => $namaFile,
                'keterangan' => $request->keterangan
            ]);

            //respone jika berhasil
            $res['message'] = "Success!";
            //array untuk menampilkan data yang telah disimpan
            $res['value'] = $data;
            return response($res);
        }
    }
}
