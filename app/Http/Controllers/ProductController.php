<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Satuan;
use App\Models\Category;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator; // or use Validator;
use Illuminate\Support\Facades\Storage;
use File;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $px = Auth::user()->access_key."_";

        $satuan = DB::table($px.'satuans')->whereNull("deleted_at")->get();

        $kategori = DB::table($px.'categories')->orderBy('name','asc')
            ->whereNull("deleted_at")
            ->where("active", true)
            ->get();

        $data = ['kategori'=>$kategori , 'satuan'=>$satuan];

        return view('ui_admin.pages.master-data.products_list', $data);
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
        $px = Auth::user()->access_key.'_';

        $harga_beli = (double)implode(preg_split('[,]', $request->hrg_beli));
        $harga_jual = (double)implode(preg_split('[,]', $request->hrg_jual));
        $harga_modal = (double)implode(preg_split('[,]', $request->hrg_modal));
        $stock_awal = (double)implode(preg_split('[,]', $request->stock_aw));
        $berat = (double)implode(preg_split('[,]', $request->berat_satuan));

        $id = Product::from($px.'products')->insertGetId([
            'code'        =>  $request->code,
            'description' =>  $request->keterangan,
            'name'        =>  $request->nama_barang,
            'kategory_id' =>  $request->kategori,
            'sat_beli'    =>  $request->satuan_beli,
            'sat_jual'    =>  $request->satuan_jual,
            'sat_konversi'=>  $request->satuan_konversi,
            'nil_konversi'=>  $request->nilai_konversi,
            'berat'        => $berat,
            'harga_beli'  =>  $harga_beli,
            'harga_jual'  =>  $harga_jual,
            'harga_modal' =>  $harga_modal,
            'stock_aw'    =>  $stock_awal,
            'stock_ak'    =>  $stock_awal,
        ]);

        $info_upload = "Gambar Product Tidak di-Upload";

        if ($id) {

            if($request->hasFile('gambar')){
                // Validator gambar
                $input = $request->all();
                $rules = [
                    'gambar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:1024',
                ];
                $messages = [
                    // 'gambar.required'  => 'Photo Profile Wajib Di-Upload',
                    'gambar.image'     => 'File Product harus File Gambar.',
                    'gambar.mimes'     => 'Tipe File hanya (:values).',
                    'gambar.max'       => 'Ukuran file terlalu besar, Maks. :max Kilobyte.',
                ];

                $validator = Validator::make($input, $rules, $messages);

                if($validator->fails()){
                    return response()->json([
                        'pesan' =>  [
                            'status' => 'error',
                            'info' => $validator->errors()->all(),
                        ],
                    ]);
                }

                // menyimpan data file yang diupload ke variabel $file
                $file     = $request->file("gambar");
                $fileExt  = $file->getClientOriginalExtension();
                $fileName = $id.'-'.$request->code.'.'.$fileExt;
                $lokasi   = 'images/products/'.Auth::user()->access_key;

                // tujuan upload
                // public_html (tidak menggunakan public_path())
                // public (menggunakan public_path()), file berada di luar public_html

                /**
                 * upload ke storage/app/gambar/products
                 * putFile, menghasilkan nama file uniq otomatis dan extentionnya
                 * putFileAs, bisa di tentukan nama filenya
                 * $path = Storage::putFile($lokasi, $file);
                 * akses file storage = $path = Storage::url('gambar/products/image_name.png');
                 * alternative - storeAs // $file->storeAs($lokasi, $filename)
                 * $file->move(public_path($lokasi), $fileName); //upload ke sidimos_apps/public/gambar/products
                 */


                // Storage::putFileAs($lokasi, $file, $fileName); //upload ke storage/app/gambar/products

                // $file->storeAs($lokasi, $fileName, 'public'); //upload ke storage/app/public/products
                // $file->storeAs($lokasi, $fileName, 'local'); //upload ke storage/app/products

                $file->move($lokasi, $fileName); //upload ke public/images/products

                $info_upload = "Gambar Product Berhasil di-Upload";

                Product::from($px.'products')
                    ->where($px.'products.id', $id)
                    ->update([
                        'gambar' => $fileName
                    ]);
            }

            $product = Product::from($px.'products as prod')
                ->where('prod.id', $id)
                ->leftJoin($px.'categories as kate', 'prod.kategory_id','=','kate.id')
                ->select('prod.*', 'kate.name as kategori')
                ->first();

            // response
            return response()->json([
                'pesan' =>  [
                    'status' => 'success',
                    'ket' => [
                        'Product Berhasil di-Simpan',
                        $info_upload,
                    ],
                ],
                'data' => $product
            ]);
        } else {
            // response
            return response()->json([
                'pesan' =>  [
                    'status' => 'error',
                    'ket' => [
                        'Product Gagal di-Simpan',
                        $info_upload,
                    ],
                ],
            ]);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        // return response()->json(['data'=>$product]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $px = Auth::user()->access_key.'_products';
        $product = Product::from($px)->where('id', $id)->first();
        // $lokasi  = Storage::url('products');
        $lokasi  = url('/images/products/'.Auth::user()->access_key);
        return response()->json(['data'=>$product, 'lokasi' => $lokasi]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $px = Auth::user()->access_key.'_';

        $harga_beli = (double)implode(preg_split('[,]', $request->hrg_beli));
        $harga_jual = (double)implode(preg_split('[,]', $request->hrg_jual));
        $harga_modal = (double)implode(preg_split('[,]', $request->hrg_modal));
        $stock_awal = (double)implode(preg_split('[,]', $request->stock_aw));
        $berat = (double)implode(preg_split('[,]', $request->berat_satuan));

        $info_upload = "Gambar Product Tidak di-Upload";

        $product = DB::table($px.'products')->where('id', $id)->first();
        $file_lama = $product->gambar;

        DB::table($px.'products')->where('id', $id)
            ->update([
                'code'          => $request->code,
                'description'   => $request->keterangan,
                'name'          => $request->nama_barang,
                'kategory_id'   => $request->kategori,
                'sat_beli'      => $request->satuan_beli,
                'sat_jual'      => $request->satuan_jual,
                'sat_konversi'  => $request->satuan_konversi,
                'nil_konversi'  => $request->nilai_konversi,
                'berat'         => $berat,
                'harga_beli'    => $harga_beli,
                'harga_jual'    => $harga_jual,
                'harga_modal'   => $harga_modal,
                'stock_aw'      => $stock_awal,
                'stock_ak'      => $stock_awal,
        ]);

        if($request->hasFile('gambar')){
            // Validator gambar
            $input = $request->all();
            $rules = [
                'gambar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:1024',
            ];
            $messages = [
                // 'gambar.required'  => 'Photo Profile Wajib Di-Upload',
                'gambar.image'     => 'File Product harus File Gambar.',
                'gambar.mimes'     => 'Tipe File hanya (:values).',
                'gambar.max'       => 'Ukuran file terlalu besar, Maks. :max Kilobyte.',
            ];

            $validator = Validator::make($input, $rules, $messages);

            if($validator->fails()){
                return response()->json([
                    'pesan' =>  [
                        'status' => 'error',
                        'ket' => $validator->errors()->all(),
                    ],
                ]);
            }

            // menyimpan data file yang diupload ke variabel $file
            $file     = $request->file("gambar");
            $fileExt  = $file->getClientOriginalExtension();
            $fileName = $id.'-'.$request->code.'.'.$fileExt;
            $tujuan_upload = 'images/products/'.Auth::user()->access_key;

            $file->move($tujuan_upload, $fileName);

            $info_upload = "Gambar Product Berhasil di-Upload";

            DB::table($px.'products')->where('id', $id)->update(['gambar' => $fileName ]);

            //hapus gambar lama jika ada perubahan nama file
            if ($file_lama != $fileName) {
                if(File::exists($tujuan_upload.'/'.$file_lama)){
                    File::delete($tujuan_upload.'/'.$file_lama);
                    $info_upload = "Gambar Lama Berhasil di-Hapus";
                }
            }
        }

        $product = Product::from($px.'products as prod')
                ->where('prod.id', $id)
                ->leftJoin($px.'categories as kate', 'prod.kategory_id','=','kate.id')
                ->select('prod.*', 'kate.name as kategori')
                ->first();

        return response()->json([
            'pesan' =>  [
                'status' => 'success',
                'ket' => [
                    'Product Berhasil di-Update',
                    $info_upload,
                ],
            ],
            'data' => $product,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $table = Auth::user()->access_key . "_products";
        $product = DB::table($table)->where('id',$id)->first();

        $info_update = "Product ??? di-Hapus";
        if ($product) {
            $gambar = $product->gambar;
            Product::from($table)->where('id',$id)->update(['deleted_at' => \Carbon\Carbon::now()]);
            // hapus file
            $lokasi = 'images/products/'.Auth::user()->access_key;
            if(File::exists($lokasi.'/'.$gambar)){
                File::delete($lokasi.'/'.$gambar);
                $info_update = "Product & Gambar berhasil di-Hapus";
            } else {
                $info_update = "Product berhasil di-Hapus";
            }
        }

        return response()->json([
            'data'  => $product,
            'info' => [
                'status' => 'success',
                'pesan' => $info_update,
            ],
        ]);
    }

    /** load data ajax */
    public function loadDataAjax(){

        $px = Auth::user()->access_key.'_';

        $product = DB::table($px.'products')->orderBy('name','asc')
            // ->where($px."products.usaha_id", Auth::user()->usaha_id)
            ->whereNull($px.'products.deleted_at')
            ->leftJoin($px.'satuans as sat', $px.'products.sat_konversi','=','sat.tipe')
            ->leftJoin($px.'categories as kate', $px.'products.kategory_id','=','kate.id')
            ->select(
                $px.'products.*',
                'kate.name as kategori',
                'sat.nilai as nilai_konv',
                'sat.kode as kode_konv')
            ->get();

        return Response()->json(['data' => $product]);
    }

    public function caribarang($code){
        $px = Auth::user()->access_key.'_';
        $product = DB::table($px.'products')
            ->orderBy('code','asc')
            ->where('code',$code)
            ->leftJoin($px.'satuans as konv', $px.'products.sat_konversi','=','konv.tipe')
            ->leftJoin($px.'categories as kate', $px.'products.kategory_id','=','kate.id')
            ->select($px.'products.*','kate.name as kategori','konv.nilai as nilai_konv','konv.kode as kode_konv')
            ->first();

        return Response()->json(['data' => $product]);
    }

    public function cekCode(Request $request) {
        $opr  = $request->opr; //edit or tambah
        $lama = $request->oldCode;
        $kode = $request->code;

        $uid = Auth::user()->usaha_id;
        $px = Auth::user()->access_key.'_';

        $cari = DB::table($px.'products')
            // ->where('usaha_id',  $uid)
            ->where('code', $kode)
            ->exists(); // menghasilkan 1 / 0 (true/false)

        if ($cari) {
            if ($opr == 'tambah') {
                return response()->json(false); // invalid
            } else {
                if ($lama ==  $kode) {
                    return response()->json(true); // abaikan (valid)
                } else {
                    return response()->json(false); // invalid
                }
            }
        } else {
            return response()->json(true); // valid
        }
    }

}
