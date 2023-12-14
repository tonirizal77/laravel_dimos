<section>
    <ol class="collection collection-container">
        <!-- The first list item is the header of the table -->
        <li class="item item-container">
            {{-- <div class="attribute"></div> --}}
            <div class="attribute" data-name="#No">#No</div>
            <!-- Enclose semantically similar attributes as a div hierarchy -->
            <div class="attribute colmin-10">Gambar</div>
            <div class="attribute-container part-information">
                <div class="attribute-container part-id">
                    <div class="attribute" data-name="Part Number">Code / Barcode</div>
                    <div class="attribute" data-name="Part Description">Nama Barang</div>
                </div>
                <div class="attribute-container vendor-information">
                    <div class="attribute">Kategori</div>
                    <div class="attribute">Konversi</div>
                </div>
            </div>
            <div class="attribute-container quantity">
                <div class="attribute">Satuan Beli</div>
                <div class="attribute">Satuan Jual</div>
            </div>
            <div class="attribute-container cost">
                <div class="attribute">Harga Beli</div>
                <div class="attribute">Harga Jual Grosir</div>
            </div>
            <div class="attribute-container duty">
                <div class="attribute">Harga Jual Retail</div>
                <div class="attribute">Duty</div>
            </div>
            <div class="attribute-container freight">
                <div class="attribute">Stock Awal</div>
                <div class="attribute">Stock Akhir</div>
            </div>
            <div class="attribute attribute-button text-center d-block">Aksi</div>
        </li>

        <!-- The rest of the items in the list are the actual data -->
        <li class="item item-container">
            {{-- <div class="attribute text-center" data-name="Select">
                <input type="checkbox" name="" id="">
            </div> --}}
            <div class="attribute text-center" data-name="#">1</div>
            <div class="attribute colmin-10 text-center" data-name="Gambar">
                <img class="gambar" src="{{ url('images/1625141314.jpg') }}" alt="Gambar-Product"/>
            </div>
            <div class="attribute-container part-information">
                <div class="attribute-container part-id">
                    <div class="attribute" data-name="Part Number">100-10001</div>
                    <div class="attribute" data-name="Part Description">Description of part</div>
                </div>
                <div class="attribute-container vendor-information">
                    <div class="attribute" data-name="Vendor Number">001</div>
                    <div class="attribute" data-name="Vendor Name">Vendor Name A</div>
                </div>
            </div>
            <div class="attribute-container quantity">
                <div class="attribute" data-name="Order Qty">10</div>
                <div class="attribute" data-name="Receive Qty">20</div>
            </div>
            <div class="attribute-container cost">
                <div class="attribute" data-name="Cost">$5.00</div>
                <div class="attribute" data-name="Extended Cost">$2.00</div>
            </div>
            <div class="attribute-container duty">
                <div class="attribute" data-name="Duty %">3.0%</div>
                <div class="attribute" data-name="Duty">$0.15</div>
            </div>
            <div class="attribute-container freight">
                <div class="attribute" data-name="Freight %">3.0%</div>
                <div class="attribute" data-name="Freight">$0.15</div>
            </div>
            <div class="attribute attribute-button text-center d-block" data-name="Aksi">
                <button class="btn btn-xs btn-warning " name="btn-edit">Edit</button>
                <button class="btn btn-xs btn-danger" name="btn-delete">Hapus</button>
            </div>
        </li>

        <li class="item item-container">
            {{-- <div class="attribute text-center" data-name="Select">
                <input type="checkbox" name="" id="">
            </div> --}}
            <div class="attribute text-center" data-name="#">2</div>
            <div class="attribute colmin-10" data-name="Gambar">EA</div>
            <div class="attribute-container part-information">
                <div class="attribute-container part-id">
                    <div class="attribute" data-name="Part Number">100-10002</div>
                    <div class="attribute" data-name="Part Description">
                        A long description of part. This description may overflow.
                    </div>
                </div>
                <div class="attribute-container vendor-information">
                    <div class="attribute" data-name="Vendor Number">002</div>
                    <div class="attribute" data-name="Vendor Name">Vendor Name B</div>
                </div>
            </div>
            <div class="attribute-container quantity">
                <div class="attribute" data-name="Order Qty">10</div>
                <div class="attribute" data-name="Receive Qty">20</div>
            </div>
            <div class="attribute-container cost">
                <div class="attribute" data-name="Cost">$5.00</div>
                <div class="attribute" data-name="Extended Cost">$2.00</div>
            </div>
            <div class="attribute-container duty">
                <div class="attribute" data-name="Duty %">3.0%</div>
                <div class="attribute" data-name="Duty">$0.15</div>
            </div>
            <div class="attribute-container freight">
                <div class="attribute" data-name="Freight %">3.0%</div>
                <div class="attribute" data-name="Freight">$0.15</div>
            </div>
            <div class="attribute attribute-button text-center d-block" data-name="Aksi">
                <button class="btn btn-xs btn-warning " name="btn-edit">Edit</button>
                <button class="btn btn-xs btn-danger" name="btn-delete">Hapus</button>
            </div>
        </li>

    </ol>
</section>
