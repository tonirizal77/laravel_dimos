<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;

use App\Models\Upload_file;

class UploadFileController extends Controller
{
    public function uploadFile()
    {
    	return view('ui_admin.pages.master-data.uploadfile');
    }

    public function StoreUploadFile(Request $request)
    {
      $validator = Validator::make($request->all(), [
        'judul'  => 'required',
        'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
      ]);

      if ($validator->passes()) {
            $input = $request->all();
            $input['gambar'] = time().'.'.$request->gambar->getClientOriginalExtension();
            $request->gambar->move(public_path('gambar'), $input['gambar']);

            Upload_file::create($input);
            return response()->json([
                'success' => 'Berhasil',
                'gambar'  => $input['gambar']
            ]);
      } else {
            return response()->json([
                'error' => $validator->errors()->all()
            ]);
      }

    }
}
