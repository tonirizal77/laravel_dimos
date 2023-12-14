<?php

namespace App\Http\Controllers;

use App\Models\Category;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /** load data ajax */
    public function loadDataAjax(){
        $px = Auth::user()->access_key."_";
         // group total
        $groupKategori = DB::table($px.'products')
            ->orderBy('kategory_id', 'asc')
            ->whereNull('deleted_at')
            ->select('kategory_id', DB::raw('COUNT("kategory_id") as totprod'))
            ->groupBy('kategory_id')
            ->get();

        $kategori = Category::from($px.'categories')
            ->orderBy('name','asc')
            ->whereNull('deleted_at')
            ->get();

        return Response()->json([
            'group' => $groupKategori,
            'kategori' => $kategori
        ]);
    }

    /** load kategori */
    public function loadDataKategori()
    {
        $px = Auth::user()->access_key."_";
        $kategori = DB::table($px.'categories')
            ->orderBy('name','asc')->where('active', true)
            ->select($px.'categories.id', $px.'categories.name')
            ->get();

        return Response()->json(['kategori' => $kategori]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('ui_admin.pages.master-data.category_list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request;
        // validation image
        // $request->validate([
        //     'iconfile' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        // ]);

        // menyimpan data file yang diupload ke variabel $file
        // $file     = $request->file("iconfile");
        // $fileName = $file->getClientOriginalName();
        // $fileExt  = $file->getClientOriginalExtension();
        // $filePath = $file->getRealPath();
        // $fileSize = $file->getSize();
        // $fileMime = $file->getMimeType();
        // $tujuan_upload = 'images';

        // $category->icons = $fileName;

        // if($request->hasFile('iconfile')){
        //     $file->move(public_path($tujuan_upload), $fileName);
        //     // $file->move(public_path('images'), $fileName);
        // }

        $px = Auth::user()->access_key.'_';

        $kategori = Category::from($px.'categories')
        ->insert([
            'name' => $request->name,
            'active' => ($request->active === "true") ? 1 : 0,
        ]);

        if($kategori) {
            $info = [
                'pesan' => 'success',
                'isi_pesan' => 'Data Category berhasil di-Tambahkan',
            ];
        } else {
            $info = [
                'pesan' => 'error',
                'isi_pesan' => 'Data Category Gagal di-Tambahkan',
            ];
        }

        return response()->json(['info' => $info]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return response()->json(['data' => $category]) ;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $px = Auth::user()->access_key.'_';

        // if ($request->iconfile != null) {
        //     //Change file name with time() and get extention file
        //     $imageName = time().'.'.$request->iconfile->extension();
        //     $request->iconfile->move(public_path('images'), $imageName);
        //     $category->icons = $imageName;
        // }

        // validation image
        // $request->validate([
        //     'iconfile' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        // ]);

        // menyimpan data file yang diupload ke variabel $file
        // $file     = $request->file("iconfile");
        // $fileName = $file->getClientOriginalName();
        // $fileExt  = $file->getClientOriginalExtension();
        // $filePath = $file->getRealPath();
        // $fileSize = $file->getSize();
        // $fileMime = $file->getMimeType();
        // $tujuan_upload = 'images';

        // if($request->hasFile('iconfile')){
        //     $file->move(public_path($tujuan_upload), $fileName);
        // }


        $update = Category::from($px.'categories')->where('id', $category->id)
                ->update([
                    'name'      => $request->nama,
                    'active'    => $request->status,
                    // 'icons'     => $fileName,
                    // 'usaha_id'  => Auth::user()->usaha_id
                ]);

        return response()->json(
            [
                'pesan' => 'Data Category berhasil di-Update',
                'updated' => $update,
            ]
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        // Category::destroy($category->id);

        $px = Auth::user()->access_key.'_';

        $today = \Carbon\Carbon::now();

        // Category::from($px.'categories')->where('id', $category->id)->delete();
        Category::from($px.'categories')->where('id', $category->id)->update(['deleted_at' => $today]);
        return response()->json(
            [
                'success' => 'Data category berhasil di-Hapus',
            ]
        );
    }

    public function multidelete(Request $request) {
        $idx = explode(",", $request->id);
        $px = Auth::user()->access_key.'_';
        $today = \Carbon\Carbon::now();

        // Category::from($px.'categories')->whereIn('id',$idx)->delete();
        Category::from($px.'categories')->whereIn('id', $idx)->update(['deleted_at' => $today]);

        $info = [
            'pesan' => 'success',
            'isi_pesan' => 'Kategori berhasil di-Hapus',
        ];

        return response()->json(['info' => $info]);
    }

    public function updateStatus(Request $request) {
        $px = Auth::user()->access_key.'_';
        $id = $request->id;
        $status = ($request->status === "true") ? 1 : 0;

        Category::from($px.'categories')->where('id',$id)->update(['active' => $status]);

        $info = [
            'pesan' => 'success',
            'isi_pesan' => 'Status Kategori berhasil di-Update',
        ];

        return response()->json(['info' => $info]);
    }

    public function updateName(Request $request) {
        $px = Auth::user()->access_key . '_';
        $nama = $request->nama;

        $kategori = Category::from($px.'categories')->where('id', $request->id)->update(['name' => $nama]);
        $info = [
            'pesan' => 'success',
            'isi_pesan' => 'Nama Kategori berhasil di-Update',
        ];
        return response()->json(['info' => $info, 'data' => $nama]);
    }
}


/**
 * Store Image in Storage Folder
 * $request->image->storeAs('images', $imageName);
 * storage/app/images/file.png
 */

/**
 * Store Image in Public Folder
 * $request->image->move(public_path('images'), $imageName);
 * public/images/file.png
 */
