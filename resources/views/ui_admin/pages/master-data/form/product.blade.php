<form enctype="multipart/form-data" id="form_product">
    @csrf
    <div class="card-body">

        <div class="alert alert-danger print-error-msg" style="display:none">
            <ul></ul>
        </div>

        <div class="row">
            <div class="col-sm-4">
                <!-- text input -->
                <div class="form-group">
                    <label>Code</label>
                    <input type="text" class="form-control code" placeholder="100.001" name="code">
                </div>
            </div>
            <div class="col-sm-8">
                <div class="form-group">
                    <label>Barcode</label>
                    <input type="text" class="form-control" placeholder="1234567890123" name="barcode" maxlength="13">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <label>Nama Barang</label>
                    <input type="text" class="form-control" placeholder="..." name="nama_barang">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <!-- select -->
                <div class="form-group">
                    <label class="col-form-label" for="satuan_konversi">Satuan Konversi</label>
                    <select class="form-control form-control-sm select2" style="width: 100%" name="satuan_konversi">
                        <option value="" selected>Tidak Ada</option>
                        @foreach ($satuan as $value)
                            @if ($value->konversi == 1)
                                <option value="{{ $value->id }}">{{ $value->tipe }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-sm-6">
                <!-- textarea -->
                <div class="form-group">
                    <label class="col-form-label" for="satuan_konversi">Kategori</label>
                    <select class="form-control form-control-sm select2" style="width: 100%" name="kategori">
                        @foreach ($kategori as $value)
                            <option value="{{ $value->id }}">{{ $value->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <!-- textarea -->
                <div class="form-group">
                    <label>Keterangan</label>
                    <textarea class="form-control" rows="3" placeholder="Keterangan..."></textarea>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                    <label class="col-form-label" for="hrg_beli">Harga Beli</label>
                    <input type="text" class="form-control rupiah" id="hrg_beli" placeholder="0" name="hrg_beli">
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label class="col-form-label" for="hrg_beli">Stock Awal</label>
                    <input type="text" class="form-control rupiah" id="stock_aw" placeholder="0" name="stock_aw">
                </div>
            </div>
            <div class="col-sm-4">
                <!-- select -->
                <div class="form-group">
                    <label class="col-form-label" for="satuan_beli">Satuan Beli</label>
                    <select class="form-control form-control-sm select2" style="width: 100%" name="satuan_beli">
                        @foreach ($satuan as $value)
                            @if ($value->konversi == 0)
                                <option value="{{ $value->id }}">{{ $value->tipe }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                    <label class="col-form-label" for="hrg_jual">Harga Jual (Retail)</label>
                    <input type="text" class="form-control rupiah" id="hrgj_rtl" placeholder="0" name="hrgj_rtl">
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label class="col-form-label" for="hrg_jual">Harga Jual (Grosir)</label>
                    <input type="text" class="form-control rupiah" id="hrgj_gros" placeholder="0" name="hrgj_gros">
                </div>
            </div>
            <div class="col-sm-4">
                <!-- select -->
                <div class="form-group">
                    <label class="col-form-label" for="satuan_jual">Satuan Jual (default)</label>
                    <select class="form-control form-control-sm select2" style="width: 100%" name="satuan_jual">
                        @foreach ($satuan as $value)
                            @if ($value->konversi == 0)
                                <option value="{{ $value->id }}">{{ $value->tipe }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                {{-- <div class="form-group">
                    <label for="image">Gambar Product</label>
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="image" name="gambar">
                            <label class="custom-file-label" for="image">Pilih Gambar</label>
                        </div>
                    </div>
                </div> --}}
                <div class="form-group">
                    <label>Gambar Product:</label>
                    <input type="file" name="gambar" class="form-control" style="height: 36px">
                </div>
            </div>
            {{-- <div class="col-sm-6" id="gambar">
                <div class="card card-deck">
                    <img class="img_product" src="{{ asset('ui_admin/dist/img/prod-1.jpg') }}" alt="img_product">
                </div>
            </div> --}}
        </div>

        <div class="row">
            <div class="print-img" style="display:none">
                <img src="" style="height:200px;width:200px;border-radius: 12px">
            </div>
        </div>

    </div>
    <div class="card-footer text-center">
        <button class="btn btn-sm btn-primary" type="button" id="btn_add">Tambah Data</button>
        <span id="btn_action"></span>
    </div>
</form>
