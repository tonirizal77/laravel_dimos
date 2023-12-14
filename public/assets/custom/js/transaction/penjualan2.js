/**
 * Penulisan multi event "keydown keyup ..."
 * Penulisan multi element "td, tr, dll..."
 */

 $(function () {
    ("use strict");

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    /**
     * setting UI
     */
    //"en-US"
    //"id-ID"
    //format utk convert string to number
    const int2rupiah = new Intl.NumberFormat("en-US", {
        // style: "currency",
        // currency: "IDR",
        minimumFractionDigits: 0,
    });

    Inputmask.extendAliases({
        rupiah: {
            prefix: "Rp ",
            groupSeparator: ",",
            digits: 2, // decimal
            alias: "numeric",
            placeholder: "0",
            autoGroup: true,
            digitsOptional: false,
            clearMaskOnLostFocus: false,
            rightAlign: true,
        },
        angka: {
            groupSeparator: ",",
            digits: 0, // decimal
            alias: "numeric",
            placeholder: "0",
            autoGroup: true,
            digitsOptional: false,
            clearMaskOnLostFocus: false,
            rightAlign: true,
        },
        number: {
            groupSeparator: "",
            digits: 0, // decimal
            alias: "numeric",
            placeholder: "",
            autoGroup: true,
            digitsOptional: false,
            clearMaskOnLostFocus: false,
            rightAlign: false,
        },
        double: {
            groupSeparator: ",",
            digits: 2, // decimal
            alias: "numeric",
            placeholder: "0",
            autoGroup: true,
            digitsOptional: false,
            clearMaskOnLostFocus: false,
            rightAlign: false,
        },
    });

    $(".select2").select2();
    $(".rupiah").inputmask({ alias: "angka" });
    $(".decimal").inputmask({ alias: "double" });
    $("#tempo").inputmask({ alias: "numeric", placeholder: "" });
    $(".currency").inputmask("currency", { rightAlign: true });
    $(".datemask").daterangepicker(
        {
            singleDatePicker: true,
            showDropdowns: true,
            autoApply: true,
            // timePicker: true,
            // timePicker24Hour: true,
            // ranges: {
            //     Today: [moment(), moment()],
            //     Yesterday: [
            //         moment().subtract(1, "days"),
            //         moment().subtract(1, "days"),
            //     ],
            //     "Last 7 Days": [moment().subtract(6, "days"), moment()],
            //     "Last 30 Days": [moment().subtract(29, "days"), moment()],
            //     "This Month": [
            //         moment().startOf("month"),
            //         moment().endOf("month"),
            //     ],
            //     "Last Month": [
            //         moment().subtract(1, "month").startOf("month"),
            //         moment().subtract(1, "month").endOf("month"),
            //     ],
            // },
            locale: {
                format: "DD-MM-YYYY",
                separator: " - ",
                applyLabel: "OK",
                cancelLabel: "Cancel",
                fromLabel: "From",
                toLabel: "To",
                customRangeLabel: "Custom",
                weekLabel: "W",
                daysOfWeek: ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"],
                monthNames: [
                    "January",
                    "February",
                    "March",
                    "April",
                    "May",
                    "June",
                    "July",
                    "August",
                    "September",
                    "October",
                    "November",
                    "December",
                ],
                firstDay: 1,
            },
            linkedCalendars: false,
            showCustomRangeLabel: true,
            alwaysShowCalendars: true,
            // startDate: "07-05-2021",
            // endDate: "14-05-2021",
        },
        function (start, end, label) {
            console.log(
                "New date range selected: " +
                    start.format("YYYY-MM-DD") +
                    " to " +
                    end.format("YYYY-MM-DD") +
                    " (predefined range: " +
                    label +
                    ")"
            );
            console.log(tgl_nota.val());
        }
    );

    /**
     * Variabel Data Nota
     */
    let nomor_nota = $("input[name=nomor_nota]");
    let tgl_nota = $("input[name=tanggal]");
    let petugas = $("input[name=kasir_now]");

    let selectCustomer = $("select#customer");
    let alamat = $("#alamat");
    let telpon = $("#telpon");
    let kota = $("#kota");
    let piutang = $("#piutang");
    let reloadCustomer = $("#re_customer");
    let addCustomer = $("#add_customer");

    /**
     * Vairabel Foam
     */
    let urlx, method, id_nota;

    let no_item = 0;
    let tot_item = 0;
    let grand_total = 0;
    let opt_rinci = "";

    /**
     * variabel Form Tabel
     */
    let form_Jual = $("form#form_isian");
    let form_Nota = $("form#nota_penjualan");

    let kode_Brg = $("input#code_item");
    let nama_Brg = $("input#nama_item");
    let hrg_jual = $("input#hrg_jual");
    let satuan   = $("select#satuan");
    let qty_item = $("input#qty");
    let disc_item = $("input#disc_item");
    let tot_harga = $("input#total_harga");
    let hrg_modal = $("input#hrg_modal");

    let jml_berat = $("input#jml_berat");
    let total_berat = $(".total_berat");
    let tot_berat = 0;

    /**
     * variabel Tabel, Rincian Tabel
     */
    let bayar_Tunai = $("input#byrCash");
    let bayar_Kartu = $("input#byrCard");
    let bayar_Kredit = $("input#byrKredit");
    let jatuh_Tempo = $("input#tempo");
    let sub_Total = $("input#subTotal");
    let total_Disc = $("input#discount");
    let total_Nota = $("input#grandTotal");
    let setting = $("#setting");

    /**
     * Variabel Button
     */
    let btn_ActionForm = $("span#btn_action"); // Update Item dan Batal
    let btn_NotaBaru = $("button[name=btn-nota-baru]");
    let btn_DaftarNota = $("button[name=btn-list-nota]");
    let btn_TambahItem = $("#tambah_item");
    let btn_Simpan = $("button[name=btn-simpan]");
    let btn_Batal = $("button[name=btn-batal]");
    let btn_Bayar = $("button[name=btn-bayar]");

    let btn_pilihNota = $("button#pilih_nota");
    let btn_editItem = $("button[name=btn-edit]");
    let btn_hapusItem = $("button[name=btn-delete]");
    let btn_sesiOut = $("button[name=btn-sesi-out]");

    let swith_nota = $("input#customSwitch1");

    /**
     * Enter as Tab
     */
    // form_Nota.enterAsTab({ allowSubmit: false });
    form_Jual.enterAsTab({ allowSubmit: true });
    form_Nota.enterAsTab({ allowSubmit: true });

    let editing = false; //edit nota
    let isTrash = false;
    let isShow = "false";
    let target = "";

    /**
     * navigation key onbody
     */
    $("body").on("keydown", function (e) {
        if (e.which == 113) {
            //F2-Nota Baru
            btn_NotaBaru.trigger("click");
        } else if (e.which == 115) {
            //F4-Daftar Nota
            btn_DaftarNota.trigger("click");
        } else if (e.which == 116) {
            //F5-(default: reload page)
            // belum siap
            if (tot_item > 0) {
                toastr.error(
                    "Sedang ada transaksi, tidak bisa muat ulang halaman ini!!!",
                    "Keluar dari Halaman Transaksi"
                );
                return false; // stop reload page
            }
        } else if (e.which == 117) {
            //   alert("F6");
            return false;
        } else if (e.keyCode == 119) {
            //F8-119 Bayar Nota
            btn_Bayar.trigger("click");
        } else if (e.keyCode == 120) {
            //F9-120 Simpan Nota
            e.preventDefault();
            btn_Simpan.trigger("click");
        } else if (e.which == 121) {
            //F10-121 Batal Nota
            e.preventDefault();
            btn_Batal.trigger("click");
        } else if (e.which == 123) {
            //F12-123 Sesi Out
            e.preventDefault();
            btn_sesiOut.trigger("click");
        }
    });

    /**
     * Sesi penjualan
     */
    let sesijual = false;
    let inp_kodesesi = $("input#kode_sesi");
    var kode_sesi = "";

    let btn_SesiBaru = $("button#sesi_baru");
    let btn_BuatSesi = $("button#buat_sesi");
    let btn_PilihSesi = $("button#pilih_sesi");
    let form_SesiBaru = $("form#sesi_baru");

    let shift = $("select#shift");
    let kassa = $("select#kassa");
    let tgl = $("input#tgl_sesi");

    form_SesiBaru
    .on("change", (shift, kassa, tgl), function () {
        let stgl = tgl.val().split("-");
        let jtgl = stgl[0] + stgl[1] + stgl[2].substr(-2);
        let c_kodesesi = shift.val() + kassa.val() + "-" + jtgl;

        //  console.log("Kode: "+c_kodesesi);

        inp_kodesesi.val(c_kodesesi); //rangkai kode sisi
    })
    .change();

    let modal_sesijual = new bootstrap.Modal(
        document.getElementById("modal_sesijual"),
        { keyboard: false, backdrop: "static"}
    );

    let modal_SesiBaru = new bootstrap.Modal(
        document.getElementById("modal-sesi-baru"),
        {keyboard: false,backdrop: "static"}
    );

    let modal_preview = new bootstrap.Modal(
        document.getElementById("modal-struk"),
        {keyboard: false,backdrop: "static"}
    );

    // Button Function Modal Buat Sesi Baru
    btn_SesiBaru.on("click", function () {
        modal_SesiBaru.toggle();
    });

    btn_BuatSesi.on("click", function () {
        form_SesiBaru.submit();
    });

    $("#btn-preview").on("click", function () {
        modal_preview.toggle();
    });

    let tabel_SesiJual = $("#tabel_sesijual");
    let currRow3 = tabel_SesiJual.find("tbody tr").first();
    tabel_SesiJual
    .on("keydown", "tr", function (e) {
        currRow3 = $(this);

        e.preventDefault();

        let cr = "";
        if (e.which == 38) {
            //Up Arrow
            cr = currRow3.prev();
        } else if (e.which == 40) {
            // Down Arrow
            cr = currRow3.next();
        } else if (e.which == 13) {
            //Enter Key
            e.preventDefault();
            currRow3 = $(this); //tr
            kode_sesi = $(this).attr("data-sesi");
            getSesiJual(kode_sesi);
        }
        if (cr.length > 0) {
            currRow3 = cr;
            currRow3.focus();
        }
    })
    .on("dblclick", "tr", function () {
        currRow3 = $(this);
        kode_sesi = $(this).attr("data-sesi");
        getSesiJual(kode_sesi);
    })
    .on("click", "tr", function () {
        currRow3 = $(this);
    });

    // button pilih nota click
    btn_PilihSesi.on("click", function () {
        kode_sesi = currRow3.attr("data-sesi");
        getSesiJual(kode_sesi);
    });

    btn_sesiOut.on("click", function(){
        if (sesijual) {
            if (toNumber(sub_Total.val()) > 0) {
                tanya(
                    "Keluar dari Sesi Saat Ini?",
                    "Transaksi saat ini akan di-Batalkan jika Keluar dari Sesi Saat ini",
                    "",
                    "question",
                    "Sesi Out" //call function
                );
            } else {
                sesi_out(true); // call function
            }
        } else {
            cek_sesijual();
        }
    })

    function sesi_out(params) {
        if (params) {
            sesijual = false;
            kode_sesi = "";
            formChange();
            cek_sesijual();
            btn_sesiOut.hide();
        }
    }

    // tampilkan modal sesijual
    function cek_sesijual() {
        loadSesiJual();
    }

    function loadSesiJual() {
        $.ajax({
            url: "sesi-penjualan",
            method: "get",
            success: function (resp) {
                let data = resp.data;

                // console.log(resp);
                // return false;

                let data_sesi = tabel_SesiJual.find("tbody");
                data_sesi.html("");

                if (data.length == 0) {
                    data_sesi.html(
                        `<tr><td colspan="6" class="text-center">Belum Ada Sesi Penjualan</td></tr>`
                    );
                } else {
                    let nobrs = 0;
                    for (let x = 0; x < data.length; x++) {
                        nobrs++;
                        let sw1 = "";
                        switch (data[x].kode_sesi.substring(0, 1)) {
                            case "P":
                                sw1 = "Pagi";
                                break;
                            case "S":
                                sw1 = "Siang";
                                break;
                            case "M":
                                sw1 = "Malam";
                                break;
                        }
                        let rowdata =
                            `<tr tabindex="` +nobrs +`" data-sesi="` +data[x].kode_sesi +`" class="text-center">
                                <td>` +nobrs +`</td>
                                <td>` +data[x].kode_sesi +`</td>
                                <td>` +dateIndo(data[x].tanggal) +`</td>
                                <td> #` +data[x].kode_sesi.substring(1, 2) +" - " +sw1 +`</td>
                                <td>` +data[x].user.name+`</td>
                                <td>` +int2rupiah.format(data[x].no_trx) +`</td>
                            </tr>`;

                        data_sesi.append(rowdata);
                    }
                }
                modal_sesijual.toggle();
            },
        });
    }

    function getSesiJual(kode) {
        $.ajax({
            url: "getSesiJual",
            type: "post",
            dataType: "json",
            data: { kode_sesi: kode },
            success: function (resp) {
                // console.log(resp);
                // return false;

                let sw1 = "";
                switch (resp.no_trx.substring(0, 1)) {
                    case "P":
                        sw1 = "Pagi";
                        break;
                    case "S":
                        sw1 = "Siang";
                        break;
                    case "M":
                        sw1 = "Malam";
                        break;
                }

                if (resp.data != null) {
                    nomor_nota.val(resp.no_trx);
                    tgl_nota.val(dateIndo(resp.data.tanggal));

                    $("#kassa_aktif").text(resp.no_trx.substring(2, 1));
                    $("#shift_aktif").text(sw1);

                    petugas.val(resp.data.user.name);

                    sesijual = true;
                    modal_sesijual.toggle();
                    btn_NotaBaru.trigger("click");
                    btn_sesiOut.show();
                } else {
                    // sesi jual tidak ditemukan
                    mynotife(
                        "error",
                        "Sesi Penjualan",
                        "Nomor Sesi Penjualan ini tidak tersedia"
                    );
                }
            },
            error: function (err) {
                console.log(err);
            },
        });
    }

    // end sesi jual

    /**
     * table Stock Barang key navigate
     * td dikasih tabindex jika ingin di navigate berdasarkan cell dan row
     * tr dikasih tabindex jika ingin di navigate berdasarkan row
     */
    let btn_refresh = $("button#refresh");
    let btn_cariItem = $("button[name=cari_barang]");
    let tabel_barang = $("#tabel_barang");
    let tabel_filter = $("#tabel_barang tbody");
    let currRow = tabel_barang.find("tbody tr").first();
    let data_backup;
    let elm_help_barang = document.getElementById("code_item");

    // load data barang
    btn_refresh.on("click", loadDataBarang);

    tabel_barang
    .on("keydown", "tr", function (e) {
        currRow = $(this);
        e.preventDefault();
        let cr = "";
        if (e.which == 38) {
            //Up Arrow
            cr = currRow.prev();
        } else if (e.which == 40) {
            // Down Arrow
            cr = currRow.next();
        } else if (e.which == 13) {
            //Enter Key
            currRow = $(this); //tr
            getProduct($(this).find("td"));
        } else if (e.which == 36) {
            cr = tabel_barang.find("tbody tr").first();
        } else if (e.which == 35) {
            cr = tabel_barang.find("tbody tr").last();
        } else if (e.which == 33) {
            // pageUp
            for (let n = 0; n < 10; n++) {
                cr = currRow.prev();
                if (cr.length > 0) {
                    currRow = cr;
                    currRow.focus();
                }
            }
        } else if (e.which == 34) {
            // pageDown
            for (let n = 0; n < 10; n++) {
                cr = currRow.next();
                if (cr.length > 0) {
                    currRow = cr;
                    currRow.focus();
                }
            }
        } else if (e.which == 27) {
            // esc key
            tutupLayarBarang();
        }

        if (cr.length > 0) {
            currRow = cr;
            currRow.focus();
        }
    })
    .on("dblclick", "tr", function () {
        currRow = $(this);
        getProduct($(this).find("td"));
    })
    .on("click", "tr", function () {
        currRow = $(this);
    })
    .on("change", "td select.select-in", function () {
        let rowselected = $(this).closest("tr");
        let harga = rowselected.find("td.harga");

        let opt = $(this.options[this.selectedIndex]);
        let getNilai = $.trim(opt.attr("data-nilai"));
        let getHarga = $.trim(opt.attr("data-dasar"));
        let getOpr = $.trim(opt.attr("data-opr"));

        $(this.options).removeAttr('selected');
        opt.attr('selected', true);
        if (getNilai >= 1) {
            // console.log("Lakukan Proses Konversi Harga Jual");
            let hrgj = (getOpr == "*") ? getHarga * getNilai : getHarga / getNilai;
            harga.text(int2rupiah.format(hrgj));
        }
    });

    // button cari barang
    btn_cariItem.on("click", function () {
        let kode_c = $.trim(kode_Brg.val());
        if (kode_c == "") {
            tampilLayarBarang(true);
        } else {
            cari_barang(kode_c);
        }
    });

    kode_Brg
    .on("keydown", function (e) {
        let kode_c = $.trim($(this).val());

        if (e.which == 40) {
            // arrow down
            if (currRow.length == 0 ){
                currRow = tabel_barang.find("tbody tr").first();
            }
            tampilLayarBarang(true);
        } else if (e.which == 27) {
            // esc key
            tutupLayarBarang();
        } else if (e.which == 13) {
            // enter
            e.preventDefault();
            if (kode_c == "" && toNumber(total_Nota.val()) > 0) {
                // btn_Bayar.trigger("click");
                // tanya(
                //     "Masukkan Pembayaran",
                //     `Jika semua data sudah dimasukkan,
                //     silahkan masukkan pembayaran untuk melanjutkannya.`,
                //     "",
                //     "warning",
                //     "Proses Bayar"
                // )
                return false;
            } else if (kode_c !== "") {
                cari_barang(kode_c);
            }
        }
    })
    .on("keyup", function (e) {
        let value = $(this).val().toLowerCase();
        if (e.which != 27) {
            // Cari kode langsung saat diketik
            if (value != "") {
                cari_barang_onkey(value);
            }

            tampilLayarBarang();
            tabel_filter.html("");
            data_backup.children().filter(function(){
                let hasil = $(this).text().toLowerCase().indexOf(value);
                if (hasil > -1) {
                    $(this).clone().appendTo(tabel_filter)
                }
            })
            currRow = tabel_barang.find("tbody tr").first();
            $("div#note_cari").html("Gunakan Mouse Klik, panah atas/bawah dan enter dan utk ambil barang");
        } else {
            // esc key
            if (value == "") {
                tutupLayarBarang();
            }
        }
    })
    .on("focus", function () {
        $("#nama_x").text("Total Belanja");
        $("#qty_x").text(tot_item + " item");
        $("#harga_x").text("");
        $("#jml_x").text(int2rupiah.format(grand_total));
    });

    qty_item.on("keydown", function(e){
        if (e.which == 13){
            e.preventDefault();
            // enter
            $('button#btn-update').focus();
            btn_TambahItem.focus();
        } else if (e.which == 9 && !e.shiftKey){
            e.preventDefault()
            // tab
            disc_item.focus()
        }
    })

    /**
     * Tabel Rincian Nota Navigation
     */
    let edit_rinci = false; // edit data di tabel_rinci
    let tabel_rinci = $("table#tabel_rinci");
    let rincian_Data = $("table#tabel_rinci tbody");
    let currRow1 = tabel_rinci.find("tbody tr").first();

    tabel_rinci
    .on("keydown", "tr", function (e) {
        currRow1 = $(this).closest("tr");
        let cr1 = "";

        if (e.which == 38 && !edit_rinci) {
            //Up Arrow
            cr1 = currRow1.prev();
        } else if (e.which == 40 && !edit_rinci) {
            // Down Arrow
            cr1 = currRow1.next();
        } else if (e.which == 13 && !edit_rinci) {
            // enter
            e.preventDefault();
            target = currRow1;
            edit_Item(target);
        } else if (e.which == 46 && !edit_rinci) {
            // delete
            e.preventDefault();
            hapus_Item(currRow1);
        }

        if (cr1.length > 0) {
            currRow1 = cr1;
            currRow1.focus();
            layar(currRow1.find("td"));
            isTrash = currRow1.attr("class") == "trashed" ? true : false;
        }
    })
    .on("click", "tr", function () {
        currRow1 = $(this);
        isTrash = currRow1.attr("class") == "trashed" ? true : false;
        layar(currRow1.find("td"));
    })
    .on("dblclick", "td input.editable", function () {
        $(this).inputmask({ alias: "angka" });
        edit_rinci = true;
        $(this).prop("readonly", false);
        $(this).focus();
    })
    .on("blur", "td input.editable", function(){
        edit_rinci = false;
        $(this).prop("readonly", true);
    })
    .on("keydown input", "td input.editable", function (e) {
        let row = $(this).closest("tr"); //elements
        let qty = row.find("input.qty_jual").val();
        let hrg = row.find("input.harga_brg").val();
        let disc = row.find("input.disc").val();

        let jmlhrg = (qty * toNumber(hrg)) - toNumber(disc);

        //update jumlah harga (total/item)
        row.find("input.jml_harga").val(int2rupiah.format(jmlhrg));

        totalForm();

        if (e.keyCode == 13) {
            e.preventDefault()
            edit_rinci = false;
            $(this).prop("readonly", true);
            return false;
        }
    })
    .on("change", "td select.select-in2", function () {
        let row = $(this).closest("tr");
        let harga = row.find("input.harga_brg"); //harga jual manual
        let jumlah = row.find("input.jml_harga");
        let qty_jual = row.find("input.qty_jual");
        let disc = row.find("input.disc").val();
        let berat = row.find("input.item_berat");

        let opt = $(this.options[this.selectedIndex]);
        let getNilai = $.trim(opt.attr("data-nilai"));
        let getHarga = $.trim(opt.attr("data-dasar")); //harga acuan
        let getBerat = $.trim(opt.attr("data-berat")); //berat acuan
        let getOpr = $.trim(opt.attr("data-opr"));

        let hrg_dasar = (getOpr == "*") ? getHarga * getNilai : getHarga / getNilai;
        let dasar_berat = (getOpr == "*") ? getBerat * getNilai : getBerat / getNilai;

        $(this.options).removeAttr('selected');
        opt.attr('selected', true);

        // update harga, jumlah dan dasar berat di tabel_rinci
        harga.val(int2rupiah.format(hrg_dasar));
        jumlah.val(int2rupiah.format( (hrg_dasar*qty_jual.val()) - toNumber(disc) ))
        berat.val(dasar_berat);

        totalForm();

        //update value form jika opt_rinci = "UPDATE"
        if (opt_rinci == "UPDATE" && row.hasClass("selected-row")) {
            hrg_jual.val(int2rupiah.format(hrg_dasar))
            satuan.val($(this).val())
            satuan.trigger("change")
            $("span#label_satuan").text($(this).val());
            tot_harga.val(int2rupiah.format( (hrg_dasar*qty_jual.val()) - toNumber(disc) ))
        }

    });

    /**
     * Tabel Daftar Nota (view modal)
     */
    let tabel_nota = $("table#tabel_nota");
    let currRow2 = tabel_nota.find("tbody tr").first();
    tabel_nota
    .on("keydown", "tr", function (e) {
        currRow2 = $(this);
        let cr2 = "";
        if (e.which == 38) {
            //Up Arrow
            cr2 = currRow2.prev();
        } else if (e.which == 40) {
            // Down Arrow
            cr2 = currRow2.next();
        }
        if (cr2.length > 0) {
            currRow2 = cr2;
            isTrash = currRow2.attr("class") == "trashed" ? true : false;
            currRow2.focus();
        }
        if (!isTrash) {
            if (e.which == 13) {
                e.preventDefault();
                //Enter Key
                currRow2 = $(this);
                isTrash = currRow2.attr("class") == "trashed" ? true : false;
                currRow2.focus();
                btn_pilihNota.trigger("click");
            } else if (e.which == 46) {
                //Delete Key
                e.preventDefault();
                id_nota = $(this).attr("data-id");
                tanya(
                    "Yakin Hapus Nota ?",
                    "Seluruh Data yang terkait (data hutang jika ada) akan terhapus juga.",
                    "",
                    "warning",
                    "Hapus Nota" // call function hapus_nota()
                );
            }
        }
    })
    .on("click", "tr", function () {
        currRow2 = $(this);
        isTrash = currRow2.attr("class") == "trashed" ? true : false;
        currRow2.focus();
    })
    .on("dblclick", "tr", function () {
        currRow2 = $(this);
        isTrash = currRow2.attr("class") == "trashed" ? true : false;
        currRow2.focus();
        btn_pilihNota.trigger("click");
    });

    // button pilih nota click
    btn_pilihNota.on("click", function () {
        if (!isTrash) {
            id_nota = currRow2.attr("data-id"); //element <tr data-id>
            $("#daftar-nota").modal("hide");

            if (no_item == 0) {
                edit_nota(id_nota);
            } else {
                tanya(
                    "Yakin Edit Nota ?",
                    "Sedang ada transaksi nota, yakin transaksi-nya dibatalkan?",
                    "",
                    "warning",
                    "Edit Nota" // call function edit_nota()
                );
            }
        }
    });

    /**
     * Button Trigger Click
     */
    // Nota Baru
    btn_NotaBaru.on("click", function () {
        if (sesijual) {
            if (toNumber(sub_Total.val()) > 0) {
                tanya(
                    "Buat Nota Baru?",
                    "Transaksi saat ini akan di-Batalkan jika Nota Baru di-Buat.",
                    "",
                    "warning",
                    "Nota Baru" //call function
                );
            } else {
                nota_baru(kode_sesi); // call function
            }
        } else {
            cek_sesijual();
        }
    });

    // Daftar Transaksi
    btn_DaftarNota.on("click", function () {
        if (sesijual) {
            daftar_nota(isShow, kode_sesi);
        } else {
            cek_sesijual();
        }
    });

    swith_nota.on("click", function () {
        isShow = $(this).prop("checked") ? "true" : "false";
        daftar_nota(isShow, kode_sesi);
    });

    // button Update Item
    btn_ActionForm
    .on("click", "button#btn-update", function () {
        opt_rinci = "UPDATE";
        // di handle submitHandler by button click
        form_Jual.submit();
    })
    .on("click", "button#btn-cancel", function () {
        //reset
        opt_rinci = "ADD";

        resetform_isian();
        form_Jual.trigger("reset");

        btn_TambahItem.show();
        btn_ActionForm.html("");
        $("tr").removeClass("selected-row");
    });

    // Tambah Item Baru
    btn_TambahItem.on("click", function () {
        opt_rinci = "ADD";
        // di-handle oleh submit by button
        form_Jual.submit();
    });

    // Simpan Nota
    btn_Simpan.on("click", function (e) {
        if (btn_Simpan.is(":enabled")) {
            tanya(
                "Simpan Data",
                "Simpan Data Transaksi saat ini",
                "",
                "info",
                "Simpan Transaksi"
            );
        } else {
            if (tot_item > 0) {
                toastr.error(
                    "Pembayaran Masih ada Selisih atau belum di-isi",
                    "Simpan Transaksi"
                );
            }
        }
        return false;
    });

    // Input Bayar Nota
    btn_Bayar.on("click", function () {
        // e.preventDefault();
        if (btn_Bayar.is(":enabled")) {
            bayar_nota();
        }
        return false;
    });

    // Batal Transaksi
    btn_Batal.on("click", function () {
        if (toNumber(sub_Total.val()) > 0) {
            tanya(
                "Transaksi Di-Batalkan?",
                "Batalkan Transaksi saat ini",
                "",
                "warning",
                "Batal Transaksi"
            );
        } else {
            formChange();
            rincian_Data.html("");
        }
    });

    // Tutup Layar Barang
    $("button#tutup").on("click", function () {
        kode_Brg.focus();
    });

    selectCustomer
    .on("change", function () {
        let opt = $(this.options[this.selectedIndex]);
        let getAlamat = $.trim(opt.attr("data-alamat"));
        let getTelp = $.trim(opt.attr("data-telp"));
        let getKota = $.trim(opt.attr("data-kota"));
        let getPiutang = $.trim(opt.attr("data-piutang"));
        // let getId = opt.attr("value"); // same --> id = $(this).val();

        alamat.text(getAlamat);
        telpon.text(getTelp);
        kota.text(getKota);
        piutang.text(getPiutang);
    }).change();

    reloadCustomer.on('click', loadCustomer);

    satuan
    .on("change", function () {
        let opt = $(this.options[this.selectedIndex]);
        let getNilai = $.trim(opt.attr("data-nilai"));
        let getHarga = $.trim(opt.attr("data-dasar"));
        let getModal = $.trim(opt.attr("data-modal"));
        let getBerat = $.trim(opt.attr("data-berat"));
        let getOpr = $.trim(opt.attr("data-opr"));

        $(this.options).removeAttr('selected');
        opt.attr('selected', true);

        let hrgj = (getOpr == "*") ? getHarga * getNilai : getHarga / getNilai;
        let hrgb = (getOpr == "*") ? getModal * getNilai : getModal / getNilai;
        let berat = (getOpr == "*") ? getBerat * getNilai : getBerat / getNilai;

        hrg_jual.val(hrgj);
        hrg_modal.val(hrgb);
        jml_berat.val(berat);
        tot_harga.val((qty_item.val() * hrgj) - toNumber(disc_item.val()));

        $("span#label_satuan").text($(this).val());
    }).change();

    /**
     * Button Function
     */

    function tampilLayarBarang(isFocus) {
        let top = getOffset(elm_help_barang).top;
        let left = getOffset(elm_help_barang).left;

        let elm = $("div#popup-item");

        elm.css("top", top);
        elm.css("left", left);

        $("div#popup-item div.card").css("display", "inherit");
        elm.show();
        if (isFocus) {
            if (currRow.length == 0) {
                currRow = tabel_barang.find("tbody tr").first();
            }
            currRow.focus();
        }
    }

    function tutupLayarBarang() {
        $("div#popup-item").hide();
        kode_Brg.focus();
    }

    function loadCustomer() {
        $.ajax({
            url: "load-data-customer",
            method: 'get',
            success: function(resp){
                let cust = resp;
                console.log(cust);

                if (resp.length != null) {
                    for (let c = 0; c < cust.length; c++) {
                        const elm = cust[c];
                        selectCustomer.append(`
                            <option
                                data-alamat="`+elm.alamat+`"
                                data-kota="`+elm.kota+`"
                                data-telp="`+elm.telpon+`"
                                data-piutang="`+int2rupiah.format(elm.total)+`"
                                value="`+elm.id+`">
                                `+elm.name+`
                            </option>
                        `)
                    }
                } else {
                    selectCustomer.html(`
                    <option
                        data-alamat=""
                        data-kota=""
                        data-telp=""
                        data-piutang=""
                        value="">
                        Belum Ada Data
                    </option>
                    `);
                }
            }
        });
        return false;
    }

    // hitung berat dari trigger satuan
    function cari_barang_onkey(code) {
        $.ajax({
            url: "/cari-barang/" + code,
            method: "post",
            data: { code: code },
            success: function (resp) {
                let data = resp.data;
                // console.log(data)
                // return false
                if (data != null) {

                    let c_sat = buatSatuan(
                        data.harga_modal,
                        data.harga_jual,
                        data.sat_jual,
                        data.sat_konversi,
                        data.nilai_konv,
                        data.kode_konv,
                        data.sat_jual,
                        data.berat
                    );

                    nama_Brg.val(data.name);
                    satuan.html(c_sat.html());
                    satuan.trigger("change"); //update harga jual, modal dan berat

                    $("div#popup-item").hide();
                    $("span#label_satuan").text(data.sat_jual);

                    hrg_jual.prop("disabled", false);
                    qty_item.prop("disabled", false);

                    if(data.sat_konversi != null)
                        satuan.prop("disabled", false);
                    else {
                        satuan.prop("disabled", true);
                    }

                    qty_item.focus();
                }
            },
            error: function (err) {
                console.log(err);
            },
        });
        return false;
    }

    // hitung berat dari trigger satuan
    function cari_barang(code) {
        $.ajax({
            url: "/cari-barang/" + code,
            method: "post",
            data: { code: code },
            success: function (resp) {
                let data = resp.data;
                if (data != null) {

                    let c_sat = buatSatuan(
                        data.harga_modal,
                        data.harga_jual,
                        data.sat_jual,
                        data.sat_konversi,
                        data.nilai_konv,
                        data.kode_konv,
                        data.sat_jual,
                        data.berat
                    );

                    nama_Brg.val(data.name);
                    satuan.html(c_sat.html());
                    satuan.trigger("change"); //update harga jual, modal dan berat

                    $("div#popup-item").hide();
                    $("span#label_satuan").text(data.sat_jual);

                    hrg_jual.prop("disabled", false);
                    qty_item.prop("disabled", false);

                    if(data.sat_konversi != null)
                        satuan.prop("disabled", false);
                    else {
                        satuan.prop("disabled", true);
                    }

                    qty_item.focus();
                } else {
                    toastr.error(
                        "<b>Data Tidak Di-Temukan</b>",
                        "Cari Barang : " + code
                    );
                    resetform_isian();
                }
            },
            error: function (err) {
                console.log(err);
            },
        });
        return false;
    }

    function loadDataBarang() {
        $.ajax({
            url: "load-data-barang",
            method: "GET",
            dataType: "json",
            beforeSend: function() {
                // setting a timeout
                $("#loading").show();
            },
            complete: function() {
                $("#loading").hide();
            },
            success: function (resp) {
                console.log(resp);

                let data = resp.data;
                let daftar_barang = $("table#tabel_barang tbody");
                if (data.length == 0) {
                    daftar_barang.html(
                        `<tr><td colspan="4" class="text-center">Data Tidak Tersedia</td></tr>`
                    );
                } else {
                    daftar_barang.html("");
                    for (let i = 0; i < data.length; i++) {

                        // buat satuan
                        let c_sat = buatSatuan(
                            data[i].harga_modal,
                            data[i].harga_jual,
                            data[i].sat_jual,
                            data[i].sat_konversi,
                            data[i].nilai_konv,
                            data[i].kode_konv,
                            data[i].sat_jual,
                            data[i].berat
                        );

                        // filter select disable or enabled
                        let satuan;
                        if (data[i].sat_konversi != null) {
                            satuan = `<select class="select-in form-control form-control-sm text-sm">`+c_sat.html()+`</select>`;
                        } else {
                            satuan = `<select class="select-in form-control form-control-sm text-sm" disabled>`+c_sat.html()+`</select>`;
                        }

                        // insert data
                        let rowdata =
                            `<tr tabindex="` +data[i].id +`" data-id="` +data[i].id +`">`+
                                `<td>` +data[i].code +`</td>`+
                                `<td>` +data[i].name +`</td>`+
                                `<td> `+ satuan + `</td>`+
                                `<td class="harga text-right">` +int2rupiah.format(data[i].harga_jual) +`</td>`+
                            `</tr>`;

                        daftar_barang.append(rowdata);
                    }
                }
                data_backup = daftar_barang.clone();
            },
            error: function(err){
                console.log(err)
                $("#loading").hide();
            }
        });
    }

    /**
     * Buat element dinamis satuan dan opsinya;
     * usage: let contoh = buatSatuan(...);
     * example: contoh.html() -> masukkan ke element select yg dituju;
     * @param {*} p0 harga modal
     * @param {*} p1 harga dasar
     * @param {*} p2 satuan dasar
     * @param {*} p3 satuan konversi
     * @param {*} p4 nilai konversi
     * @param {*} p5 kode konversi
     * @param {*} p6 satuan selected
     * @param {*} p7 dasar berat
     */
    function buatSatuan(p0, p1, p2, p3, p4, p5, p6, p7) {
        const h_modal = p0;
        const h_dasar = p1;
        const s_dasar = p2;
        const kvsi = p3;
        const nl_kvsi = p4;
        const kd_kvsi = p5;
        const s_jual = p6;
        const d_berat = p7;

        let c_select = $("<select/>");

        if (kvsi != null && nl_kvsi != null) {
            let sat = kvsi.split("-")[0]; //pisahkan BOX.PCS - 10.1
            let satkonv = sat.split(".");

            if (satkonv.length > 1) {
                let nilaikonv = nl_kvsi.split(".");
                let kodekonv = kd_kvsi.split(".");

                /**
                 * cari opr, jika satuan besar/sedang = bagi
                 * jika satuan kecil = kali
                 */
                let opr = "";
                for (let x = 0; x < satkonv.length; x++) {
                    const s = satkonv[x];
                    const k = kodekonv[x];
                    if (s == s_dasar) {
                        opr = (k == "B" || k == "S") ? "/" : "*";
                    }
                }

                /**ganti select satuan jual*/
                for (let x = 0; x < satkonv.length; x++) {
                    const s = satkonv[x];
                    const n = nilaikonv[x];
                    const k = kodekonv[x];

                    if (s == s_jual) {
                        c_select.append(`
                            <option data-modal="`+h_modal+
                                `" data-dasar="`+h_dasar+
                                `" data-berat="`+d_berat+
                                `" data-opr="`+opr+
                                `" data-nilai="`+n+
                                `" data-kode="`+k+
                                `" value="`+s+
                                `" selected>`+s+
                                // `">`+s+
                            `</option>`)
                    } else {
                        c_select.append(`
                            <option data-modal="`+h_modal+
                                `" data-dasar="`+h_dasar+
                                `" data-berat="`+d_berat+
                                `" data-opr="`+opr+
                                `" data-nilai="`+n+
                                `" data-kode="`+k+
                                `" value="`+s+`">`+s+
                            `</option>`)
                    }
                }
            } else {
                c_select.append(`
                    <option data-modal="`+h_modal+`"
                        data-dasar="`+h_dasar+`"
                        data-berat="`+d_berat+`"
                        data-opr="*"
                        data-nilai="1"
                        data-kode="`+s_dasar+
                        `" value="`+s_dasar+`">`+s_dasar+
                    `</option>`);
            }
        } else {
            c_select.append(`
                <option data-modal="`+h_modal+`"
                    data-dasar="`+h_dasar+`"
                    data-berat="`+d_berat+`"
                    data-opr="*"
                    data-nilai="1"
                    data-kode="`+s_dasar+
                    `" value="`+s_dasar+`">`+s_dasar+
                `</option>`);
        }

        // console.log(c_select);

        return c_select;
    }

    // ambil data dari tabel bantu barang
    function getProduct(data) {
        kode_Brg.val(data[0].innerHTML);
        nama_Brg.val(data[1].innerHTML);
        satuan.html(data[2].innerHTML);
        hrg_jual.val(data[3].innerHTML);

        // update value satuan
        // satuan.val(data[2].children[0].value);
        satuan.trigger("change");

        let qty = qty_item.val();
        let jml = toDouble(hrg_jual.val());
        tot_harga.val(qty * jml);

        $("span#label_satuan").text(satuan.val());

        $("div#popup-item").hide();

        hrg_jual.prop("disabled", false);
        qty_item.prop("disabled", false);
        satuan.prop("disabled", false);
        disc_item.prop("disabled", false);

        kode_Brg.focus();
        qty_item.focus();
    }

    /**
     * usage : getOffset(element).left / getOffset(element).top
     * @param {*} el
     * @returns left, top position element
     *
     */
    function getOffset(el) {
        const rect = el.getBoundingClientRect();
        // console.log(rect);
        return {
            left: rect.left + window.scrollX,
            top: rect.top + window.scrollY - 24,
        };
    }

    /**
     * switch form Aksi Submit Nota Pembelian
     * @param {*} action string (Tambah, Edit, Hapus)
     * @param {*} idx string (nomor nota)
     */
    function formAction(action, idx) {
        switch (action) {
            case "Tambah":
                urlx = "pos-kasir";
                method = "POST";
                break;
            case "Edit":
                urlx = "pos-kasir/" + idx;
                method = "PUT";
                break;
            case "Hapus":
                urlx = "pos-kasir/" + idx;
                method = "DELETE";
                break;
        }
    }

    // Function layar Bantu Item Detail
    function layar(dc) {
        let kode = dc.find("input.kode_brg").val();
        let nama = dc.find("input.nama_brg").val();
        let sat = dc.find("select.satuan").val();
        let qty = dc.find("input.qty_jual").val();
        let hrg = dc.find("input.harga_brg").val();
        let jml = dc.find("input.jml_harga").val();

        $("#nama_x").text(nama);
        $("#qty_x").text(qty + " " + sat + " x ");
        $("#harga_x").text(hrg);
        $("#jml_x").text(jml);
    }

    function showButtonAction() {
        btn_ActionForm.html(
            `<button class="btn btn-sm btn-info" type="button" id="btn-update">Simpan</button>` +
                " " +
            `<button class="btn btn-sm btn-warning" type="button" id="btn-cancel">Batal</button>`
        );
    }

    function formChange(xform) {
        resetform_isian();

        if (xform == "aktif") {
            btn_TambahItem.prop("disabled", false);
            btn_cariItem.prop("disabled", false);

            btn_Batal.prop("disabled", false);
            btn_Simpan.prop("disabled", true);

            kode_Brg.prop("disabled", false);
            selectCustomer.prop("disabled", false);
            tgl_nota.prop("readonly", true);

            // $("#struk").prop("disabled", false);
            // $("#delivery").prop("disabled", false);
            $("#setting").prop("disabled", false);
            $("#btn-preview").prop("disabled", false);

            kode_Brg.focus();
            $("#marquee").hide();

            $("#nama_x").show();
            $("#qty_x").show();

            $("#jml_x").show();
            $("#harga_x").show();
        } else {
            btn_TambahItem.prop("disabled", true);
            btn_cariItem.prop("disabled", true);

            kode_Brg.prop("disabled", true);
            selectCustomer.prop("disabled", true);
            tgl_nota.prop("readonly", true);

            btn_ActionForm.empty();

            btn_Batal.prop("disabled", true);
            btn_Simpan.prop("disabled", true);
            btn_Bayar.prop("disabled", true);

            btn_editItem.prop("disabled", true);
            btn_hapusItem.prop("disabled", true);

            $("#btn-preview").prop("disabled", true);

            //reset
            grand_total = 0;
            no_item = 0;
            tot_item = 0;
            $("span#total_item").text(no_item);

            $(".inputBayar input").prop("readonly", true);
            $(".inputBayar input").prop("value", "0");

            //reset
            editing = false;
            rincian_Data.html("");
            $("#marquee").show();

            $("#nama_x").hide();
            $("#qty_x").hide();

            $("#jml_x").hide();
            $("#harga_x").hide();
        }
        // return false;
    }

    function resetform_isian() {
        form_Nota.trigger("reset");
        form_Jual.trigger("reset");

        kode_Brg.val("");
        nama_Brg.val("");
        satuan.val("");
        satuan.trigger("change");
        qty_item.val("0");
        disc_item.val("0");
        hrg_jual.val("0");
        tot_harga.val("0");
        // jatuh_Tempo.val("14");

        nama_Brg.prop("disabled", true);
        hrg_jual.prop("disabled", true);
        satuan.prop("disabled", true);
        qty_item.prop("disabled", true);
        disc_item.prop("disabled", true);
        tot_harga.prop("disabled", true);

        $("span#label_satuan").text("?");
        $("input").removeClass("is-invalid");
        $("span.error").remove();

        btn_TambahItem.show();
        kode_Brg.focus();
        // grand_total = 0;

        // $("#struk").prop("disabled", true);
        // $("#delivery").prop("disabled", true);
        $("#setting").prop("disabled", true);
    }

    let data_nota = $("table#tabel_nota tbody");
    function daftar_nota(param1, param2) {
        $.ajax({
            url: "load-nota-penjualan",
            method: "post",
            data: {
                'isShow': param1,
                'kode_sesi': param2
            },
            success: function (resp) {
                let nota = resp.data;

                console.log(nota)

                data_nota.html("");
                let total_all = tot_tunai = tot_kredit = tot_kartu = tot_disc = 0;

                if (nota.length == 0) {
                    data_nota.html(
                        `<tr><td colspan="6" class="text-center">Belum Ada Transaksi</td></tr>`
                    );
                } else {
                    let nobrs = 0;
                    for (let x = 0; x < nota.length; x++) {
                        nobrs++;
                        //seleksi nota dihapus
                        let trash = nota[x].deleted_at != null ? "trashed" : "";

                        let rowdata =
                            `<tr tabindex="` +nobrs +`" data-id="` +nota[x].id +`" class="` +trash +`">
                                <td tabindex="1" class="text-center">` +nobrs +`</td>
                                <td tabindex="2" class="text-center">` +nota[x].no_nota +`</td>
                                <td tabindex="3" class="text-center">` +dateIndo(nota[x].tanggal) +`</td>
                                <td tabindex="4" class="text-right">` +int2rupiah.format(nota[x].total) +`</td>
                                <td tabindex="5">` +nota[x].nama_customer +`</td>
                                <td tabindex="6">` +nota[x].nama_user +`</td>
                            </tr>`;
                        data_nota.append(rowdata);

                        tot_tunai += nota[x].tunai
                        tot_kredit += nota[x].kredit
                        tot_kartu += nota[x].kartu
                        tot_disc += nota[x].disc
                        total_all += nota[x].total
                    }
                }

                $("#byr_tunai_info").text(int2rupiah.format(tot_tunai))
                $("#byr_kartu_info").text(int2rupiah.format(tot_kartu))
                $("#byr_kredit_info").text(int2rupiah.format(tot_kredit))
                $("#pot_disc_info").text(int2rupiah.format(tot_disc))
                $("#total_sesi_info").text(int2rupiah.format(total_all))

                // update & tampilkan daftar nota
                $("#tgl_sesi_info").text(tgl_nota.val());
                $("#kasir_sesi_info").text(petugas.val());
                $("#kassa_info").text(kode_sesi.substring(1, 2));

                let shift = "";
                if (kode_sesi.substring(0, 1) == "P") {
                    shift = "Pagi";
                } else if (kode_sesi.substring(0, 1) == "S") {
                    shift = "Siang";
                } else {
                    shift = "Malam";
                }
                $("#shift_info").text(shift);

                $("#daftar-nota").modal("show");
                data_nota.find("tr").first().focus();

                // rekap total penjualan
            },
        });
    }

    function nota_baru(kode_sesi) {
        /** get no nota terakhir */
        $.ajax({
            url: "getnotrx",
            type: "post",
            dataType: "json",
            data: { kode_sesi: kode_sesi },
            success: function (resp) {
                // console.log(resp);
                // return false;

                nomor_nota.val(resp.no_trx);
                editing = false;
                formChange("aktif");
                rincian_Data.html(`<tr id="no-data"><td colspan="7" class="text-center">Data Barang Masih Kosong</td></tr>`);
                opt_rinci = "ADD";
            },
            error: function (err) {
                console.log(err);
            },
        });
        return false;
    }

    function batal_nota() {
        formChange();
        rincian_Data.html("");
    }

    function bayar_nota() {
        $("#pembayaran input").prop("readonly", false);
        sub_Total.prop("readonly", true);
        total_Nota.prop("readonly", true);
        jatuh_Tempo.prop("readonly", true);
        bayar_Tunai.focus();
        bayar_Tunai.val(total_Nota.val())
        hitung_bayar();
        totalForm();
    }

    function simpan_nota() {
        // cek tempo
        if (toNumber(bayar_Kredit.val()) > 0 && jatuh_Tempo.val() == 0) {
            jatuh_Tempo.focus();
            mynotife(
                "error",
                "Jatuh Tempo Kredit",
                "Tempo Pembayaran Kredit Belum di-Masukkan"
            );
        } else {
            if (tot_item == 0 || toNumber(sub_Total.val()) == 0) {
                toastr.error("Belum ada Input Barang", "Kesalahan Proses");
            } else {
                // eksekusi proses
                if (editing) {
                    formAction("Edit", id_nota);
                } else {
                    formAction("Tambah", "");
                }
                form_Nota.submit();
            }
        }
        return false;
    }

    function edit_nota(idx) {
        /**
         * get rincian nota from database
         */
        $.ajax({
            url: "load-data-nota/" + idx,
            type: "get",
            dataType: "json",
            success: function (resp) {
                let nota = resp.nota;
                let rinci = resp.data;

                console.log(resp);

                if (rinci.length > 0) {
                    formChange("aktif");
                    opt_rinci = "ADD";
                    rincian_Data.html("");

                    //--update layar tabel nota pembelian & rincian
                    nomor_nota.val(nota.no_nota);
                    tgl_nota.val(dateIndo(nota.tanggal));
                    selectCustomer.val(nota.customer_id);
                    selectCustomer.trigger("change");

                    bayar_Tunai.val(int2rupiah.format(nota.tunai));
                    bayar_Kartu.val(int2rupiah.format(nota.kartu));
                    bayar_Kredit.val(int2rupiah.format(nota.kredit));
                    jatuh_Tempo.val(nota.tempo);
                    sub_Total.val(int2rupiah.format(nota.brutto));
                    total_Disc.val(int2rupiah.format(nota.disc));
                    total_Nota.val(int2rupiah.format(nota.total));

                    grand_total = nota.total;

                    //--update layar tabel rincian
                    no_item = tot_item = tot_berat = 0;
                    for (let i = 0; i < rinci.length; i++) {
                        no_item++;
                        tot_item++;

                        // buat satuan
                        let cs = buatSatuan(
                            rinci[i].harga_modal,
                            rinci[i].harga_dasar,
                            rinci[i].sat_dasar,
                            rinci[i].konversi,
                            rinci[i].nilai_konv,
                            rinci[i].kode_konv,
                            rinci[i].satuan,
                            rinci[i].berat
                        );

                        // cek berat yg ada konversi
                        let berat = rinci[i].berat; //toni

                        if (rinci[i].konversi != null) {
                            let satkonv = rinci[i].konversi.split("."); // BALL.TIM.KG
                            if (satkonv.length > 1) {
                                let nilaikonv = rinci[i].nilai_konv.split(".");     //10.5.1
                                let kodekonv = rinci[i].kode_konv.split(".");       //B.S.K
                                /**
                                 * cari opr, jika satuan besar/sedang = bagi
                                 * jika satuan kecil = kali
                                 */
                                // let opr = "";
                                let nil = 0;
                                for (let x = 0; x < satkonv.length; x++) {
                                    const s = satkonv[x];
                                    // const k = kodekonv[x];
                                    const n = nilaikonv[x];
                                    if (s == rinci[i].satuan) {
                                        // opr = (k == "B" || k == "S") ? "/" : "*";
                                        nil = n;
                                    }
                                }
                                berat = nil;
                            }
                        }

                        tot_berat += (berat * rinci[i].qty);

                        rincian_Data.append(
                            `<tr tabindex="` +no_item +`" data-id="` +no_item +`">
                                <td class="text-center no_urut">` +tot_item +`</td>
                                <td>
                                    <input type="text" name="kode_brg[]" value="` +$.trim(rinci[i].code) +`" class="kode_brg form-control text-center " readonly>
                                </td>
                                <td>
                                    <input type="text" name="nama_brg[]" value="` +rinci[i].nama_barang +`" class="nama_brg form-control" disabled>
                                </td>
                                <td>
                                    <div class="form-group row m-0 justify-content-between">
                                        <div class="col-sm-5 p-0 qty">
                                            <input type="number" name="qty_jual[]" value="` +rinci[i].qty+`" class="qty_jual form-control text-right editable" readonly>
                                        </div>
                                        <div class="col-sm-6 p-0 satuan">
                                            <select name="satuan[]" class="satuan select-in2 form-control text-sm" readonly>
                                                `+cs.html()+`
                                            </select>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <input type="text" name="harga_brg[]" value="` +int2rupiah.format(rinci[i].harga_jual) +`" class="harga_brg form-control text-right editable rupiah" readonly>
                                </td>
                                <td>
                                    <input type="text" name="disc[]" value="` +int2rupiah.format(rinci[i].disc) +`" class="disc form-control text-right editable rupiah" readonly>
                                </td>
                                <td>
                                    <input type="text" name="jml_harga[]" value="` +int2rupiah.format((rinci[i].harga_jual-rinci[i].disc) * rinci[i].qty) +`" class="jml_harga form-control text-right rupiah" disabled>
                                </td>
                                <input type="hidden" name="hrg_modal[]" value="` +int2rupiah.format(rinci[i].harga_beli) +`" class="hrg_modal rupiah" readonly>
                                <input type="hidden" name="item_berat[]" value="` + berat +`" class="item_berat decimal" disabled>
                            </tr>
                            `
                        );
                    }

                    $("span#total_item").text(tot_item);
                    total_berat.text(int2rupiah.format(tot_berat)+' Kg');

                    kode_Brg.focus();
                    btn_Bayar.prop("disabled", false);
                    editing = true;
                    // setting.prop("disabled", true);
                } else {
                    toastr.error(
                        "Rincian Nota Tidak Tersedia, Data tidak lengkap..!",
                        "Ada Kesalahan Data"
                    );
                }
                return false;
            },
            error: function (err) {
                console.log(err);
            },
        });
    }

    function hapus_nota(idx) {
        formAction("Hapus", idx);
        $.ajax({
            url: urlx,
            type: method,
            success: function (resp) {
                console.log(resp);
                mynotife(resp.pesan, "Hapus Nota", resp.isi_pesan);
                daftar_nota(isShow, kode_sesi);
            },
            error: function (err) {
                console.log(err);
            },
        });
    }

    // Function Tambah Item
    function tambah_Item() {
        if (tot_item == 0) {
            $("tr#no-data").remove();
            setting.prop("disabled", true);
        }

        let kode = $.trim(kode_Brg.val());
        let nama_item = nama_Brg.val();
        let qty = toNumber(qty_item.val());
        let sat = $.trim(satuan.val());
        let disc = toNumber(disc_item.val());
        let harga = toNumber(hrg_jual.val());
        let jumlah = toNumber(tot_harga.val());
        let harga_m = toNumber(hrg_modal.val());
        let berat = toDouble(jml_berat.val());

        if (jumlah > 0) {
            no_item++;
            tot_item++; //no_urut

            $("span#total_item").text(tot_item);

            //cari item yg sama kode (belum di-testing) ***
            let hasAdd = true;
            if ($(setting).is(':checked')) {

                // console.log("setting aktif")

                let elm = rincian_Data.find('tr');
                if (elm.length > 0) {
                    for (let x = 0; x < elm.length; x++) {
                        // const e = $(elm[x]).find('td');
                        //acuan
                        let e_kode = $(elm[x]).find('td input.kode_brg');
                        let e_sat = $(elm[x]).find('td select.satuan');
                        let e_hrg = $(elm[x]).find('td input.harga_brg');

                        let f_qty = $(elm[x]).find('td input.qty_jual');
                        let f_disc = $(elm[x]).find('td input.disc');
                        let f_jmlhrg = $(elm[x]).find('td input.jml_harga');

                        if ( $.trim(e_kode.val()) == kode && $.trim(e_sat.val()) == sat && toNumber(e_hrg.val()) == harga ) {
                            // console.log(e);
                            // update qty dan jumlah
                            $(f_qty).val( toNumber(f_qty.val()) + qty )
                            $(f_disc).val( int2rupiah.format(toNumber(f_disc.val()) + disc) )
                            $(f_jmlhrg).val( int2rupiah.format(toNumber(f_jmlhrg.val()) + jumlah) )

                            hasAdd = false; //jgn tambahkan baris baru
                        }
                    }
                }
            }

            if (hasAdd) {
                rincian_Data.append(
                    `<tr tabindex="` +no_item +`" data-id="` +no_item +`">
                        <td class="text-center no_urut">` +tot_item +`</td>
                        <td>
                            <input type="text" name="kode_brg[]" value="` +kode+`" class="kode_brg form-control text-center " readonly>
                        </td>
                        <td>
                            <input type="text" name="nama_brg[]" value="` + nama_item +`" class="nama_brg form-control" disabled>
                        </td>
                        <td>
                            <div class="form-group row m-0 justify-content-between">
                                <div class="col-sm-5 p-0 qty">
                                    <input type="number" name="qty_jual[]" value="` + qty +`" class="qty_jual form-control text-right editable" readonly>
                                </div>
                                <div class="col-sm-6 p-0 satuan">
                                    <select name="satuan[]" class="satuan select-in2 form-control text-sm" readonly>
                                        `+satuan.html()+`
                                    </select>
                                </div>
                            </div>
                        </td>
                        <td>
                            <input type="text" name="harga_brg[]" value="` +int2rupiah.format(harga) +`" class="harga_brg form-control text-right editable rupiah" readonly>
                        </td>
                        <td>
                            <input type="text" name="disc[]" value="` +int2rupiah.format(disc) +`" class="disc form-control text-right editable rupiah" readonly>
                        </td>
                        <td>
                            <input type="text" name="jml_harga[]" value="` +int2rupiah.format(jumlah) +`" class="jml_harga form-control text-right rupiah" disabled>
                        </td>

                        <input type="hidden" name="hrg_modal[]" value="` +int2rupiah.format(harga_m) +`" class="hrg_modal rupiah" readonly>
                        <input type="hidden" name="item_berat[]" value="` + berat +`" class="item_berat decimal" disabled>
                    </tr>`
                );
            }

            mynotife(
                "success",
                "Sukses Tambah Item",
                nama_item + "<br>Sukses di-tambahkan"
            );

            totalForm();

            // form_Jual.trigger("reset");
            // reset-2 form isian manual
            kode_Brg.val("");
            nama_Brg.val("");
            hrg_jual.val(0);
            satuan.html("");
            satuan.trigger("change");
            qty_item.val(0);
            disc_item.val(0);
            tot_harga.val(0);

            jml_berat.val(0);
            hrg_modal.val(0);

            satuan.prop("disabled", true);
            hrg_jual.prop("disabled", true);
            qty_item.prop("disabled", true);
            disc_item.prop("disabled", true);
            $("input").removeClass("is-invalid");
            $("span.error").remove();

            kode_Brg.focus();
        } else {
            toastr.error(
                "Total Harga Salah / Masih Kosong",
                "Form Input Salah"
            );
            qty_item.focus();
        }
        return false;
    }

    // function Updated Item
    function updated_Item(target) {
        // update tabel_rinci with target=id (button)
        // id = currRow.attr("data-id"); //element <tr data-id>

        // let row_x = currRow.attr("tabindex", target);
        // console.log(target);

        target.find("input.kode_brg").val(kode_Brg.val());
        target.find("input.nama_brg").val(nama_Brg.val());
        let sat = target.find("select.satuan").val(satuan.val());
        target.find("input.qty_jual").val(qty_item.val());
        target.find("input.harga_brg").val(hrg_jual.val());
        target.find("input.disc").val(disc_item.val());
        target.find("input.jml_harga").val(tot_harga.val());

        sat.trigger("change");

        //reset
        opt_rinci = "ADD";
        btn_TambahItem.show();
        btn_ActionForm.html("");

        resetform_isian();

        hrg_jual.prop("disabled", true);
        qty_item.prop("disabled", true);

        kode_Brg.focus();
        $("tr").removeClass("selected-row");

        totalForm();
        hitung_bayar();

        mynotife("success", "Update Item Barang", "<b>Sukses di-Update</b>");
    }

    function edit_Item(target) {
        opt_rinci = "UPDATE";

        // with direct val() to get value input
        let kode = target.find("input.kode_brg").val();
        let nama = target.find("input.nama_brg").val();
        let sat = target.find("select.satuan").html();
        let qty = target.find("input.qty_jual").val();
        let hrg = target.find("input.harga_brg").val();
        let disc = target.find("input.disc").val();

        //update layar isian form data
        kode_Brg.val(kode);
        nama_Brg.val(nama);
        hrg_jual.val(hrg);
        qty_item.val(qty);
        disc_item.val(disc);
        tot_harga.val((qty * toNumber(hrg)) - toNumber(disc));

        satuan.html(sat);
        satuan.trigger("change");
        $("span#label_satuan").text(satuan.val());

        $("tr").removeClass("selected-row");
        target.addClass("selected-row");

        showButtonAction();
        btn_TambahItem.hide();
        hrg_jual.prop("disabled", false);
        qty_item.prop("disabled", false);
        satuan.prop("disabled", false);
        disc_item.prop("disabled", false);

        kode_Brg.focus();
        qty_item.focus();
    }

    function hapus_Item(target) {
        let nou = target.find("td.no_urut").text();
        let kode = target.find("input.kode_brg").val();
        let nama = target.find("input.nama_brg").val();
        let sat = target.find("select.satuan").val();
        let qty = target.find("input.qty_jual").val();
        let hrg = target.find("input.harga_brg").val();
        /**jml_berat */


        Swal.fire({
            icon: "warning",
            title: "Hapus Item Barang?",
            html:
                "Item No. : <b>" + nou + "</b> - Kode : <b>" +
                kode + "</b><br>Nama : <b>" +
                nama + "</b><br>Qty : <b>" +
                qty + " " +
                sat + "  x (Rp. " + int2rupiah.format(toNumber(hrg)) + ")",

            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, Yakin",
            cancelButtonText: "Tidak",
            allowOutsideClick: false,
        }).then((result) => {
            if (result.isConfirmed) {
                target.remove();
                tot_item--;

                let rows = $("table#tabel_rinci tbody tr");
                let no = 1;
                for (let x = 0; x < rows.length; x++) {
                    const el = rows[x];
                    el.children[0].innerHTML = no; //update no urut
                    no++;
                }
                totalForm();
                hitung_bayar();
                toastr.success("<b>Sukses di-Hapus</b>", "Hapus Item");
                kode_Brg.focus();
            }
        });
    }

    //Input Pembayaran
    $("#pembayaran").on("input", function () {
        let byr_tunai = toNumber(bayar_Tunai.val());
        let byr_kartu = toNumber(bayar_Kartu.val());
        let byr_kredit = toNumber(bayar_Kredit.val());
        let pot_disc = toNumber(total_Disc.val());

        if (isNaN(byr_tunai)) bayar_Tunai.val(0);
        if (isNaN(byr_kartu)) bayar_Kartu.val(0);
        if (isNaN(byr_kredit)) bayar_Kredit.val(0);
        if (isNaN(pot_disc)) total_Disc.val(0);

        totalForm();
        hitung_bayar();
    });

    // function hitung total form
    function totalForm() {
        let v_subTotal = 0;
        // proses input dalam rincian tabel nota
        let s_harga = $("input.harga_brg");
        let s_qty = $("input.qty_jual");
        let s_disc = $("input.disc");
        let s_jumlah = $("input.jml_harga");
        let s_berat = $("input.item_berat");

        tot_item = 0;
        tot_berat = 0;

        //re-total rincian data
        for (let i = 0; i < s_jumlah.length; i++) {
            const xhrg = toNumber(s_harga[i].value);
            const xqty = s_qty[i].value;
            const xdisc = toNumber(s_disc[i].value);
            const xberat = (s_berat[i].value * s_qty[i].value);

            const xjmlhrg = (xhrg * xqty) - xdisc;
            if (!isNaN(xjmlhrg)) {
                v_subTotal += parseInt(xjmlhrg);
            }

            tot_item++;
            tot_berat += xberat;
            // console.log(xberat);
        }

        // update value input form isian
        let qty = qty_item.val();
        let jml = toNumber(hrg_jual.val());
        let disc_i = toNumber(disc_item.val());
        tot_harga.val((qty * jml) - disc_i); // update nilai total harga per Item

        let disc_plus = toNumber(total_Disc.val());
        if (disc_plus > v_subTotal) {
            total_Disc.val(0); // update nilai total disc+
            disc_plus = 0;
        }
        grand_total = v_subTotal - disc_plus;

        // update nilai total nota
        sub_Total.val(v_subTotal);
        total_Nota.val(grand_total);

        if (v_subTotal > 0) {
            btn_Bayar.prop("disabled", false);
        } else {
            btn_Bayar.prop("disabled", true);
        }
        // update total item
        $("#total_item").text(tot_item);
        $("#jml_x").text(int2rupiah.format(grand_total));

        // update total berat
        total_berat.text(int2rupiah.format(tot_berat)+' Kg');
    }

    function hitung_bayar() {
        let byr_tunai = toNumber(bayar_Tunai.val());
        let byr_kartu = toNumber(bayar_Kartu.val());
        let byr_kredit = toNumber(bayar_Kredit.val());

        grand_total = toNumber(total_Nota.val()) ;

        // input pembayaran
        let total_bayar = (byr_tunai + byr_kartu + byr_kredit);
        let sisa_bayar = grand_total - total_bayar;

        if (toNumber(sub_Total.val()) > 0) {
            if (total_bayar > grand_total) {
                // lebih bayar

                if (byr_kredit > grand_total){
                    bayar_Kredit.val(grand_total)
                    byr_kredit = grand_total;
                }

                if (byr_kartu > grand_total) {
                    bayar_Kartu.val(grand_total)
                    byr_kartu = grand_total;
                }

                total_bayar = (byr_tunai + byr_kartu + byr_kredit);
                sisa_bayar = grand_total - total_bayar;

                if (byr_tunai >= grand_total) {
                    bayar_Tunai.val(grand_total);
                    btn_Simpan.prop("disabled", false); // lanjut save
                    // btn_Simpan.focus();
                } else {
                    if (total_bayar > grand_total){
                        btn_Simpan.prop("disabled", true); // tahan save
                    } else {
                        btn_Simpan.prop("disabled", false); // tahan save
                    }
                }

                $("#total_selisih").css("color", "blue");
                $("#selisih_ket").html("Lebih Bayar:");
            } else if (total_bayar < grand_total) {
                // kurang bayar
                btn_Simpan.prop("disabled", true);
                $("#total_selisih").css("color", "red");
                $("#selisih_ket").html("Kurang Bayar:");
            } else if (total_bayar == grand_total) {
                // pass bayar
                $("#total_selisih").css("color", "black");
                $("#total_selisih").text("OK - Pass");
                $("#selisih_ket").html("Sisa Bayar:");
                btn_Simpan.prop("disabled", false);
            }
        }

        $("#total_selisih").text(
            "Rp. " + int2rupiah.format(sisa_bayar * -1)
        );

        if (toNumber(bayar_Kredit.val()) > 0) {
            jatuh_Tempo.prop("readonly", false);
        } else {
            jatuh_Tempo.val(0);
            jatuh_Tempo.prop("readonly", true);
        }

    }

    // Convertion date (yyyy-mm-dd) to dd-mm-yyyy
    function dateIndo(tanggal, yearDigits, spr, t) {
        let cTgl = new Date(tanggal); //new Date(2021,11,01) -- year, month(0-11), and day
        let dd = String(cTgl.getDate()).padStart(2, "0");
        let mm = String(cTgl.getMonth() + 1).padStart(2, "0"); //January is 0!
        let yyyy = cTgl.getFullYear();

        let time = cTgl.getHours() + ":" + cTgl.getMinutes(); //+ ":" + cTgl.getSeconds();

        let s = spr != null ? spr : "-";

        if (yearDigits == 2) {
            cTgl = dd + s + mm + s + cTgl.getFullYear().toString().substr(-2);
        } else {
            cTgl = dd + s + mm + s + yyyy;
        }

        if (t != null) {
            cTgl = cTgl + ' - ' +time
        }

        return cTgl;
    }

    // var twoPlacedFloat = parseFloat(yourString).toFixed(2);
    // Convertion string to Number/Double(float)
    function toNumber(string) {
        return parseInt(string.split(",").join(""));
    }
    function toDouble(string) {
        return parseFloat(string.split(",").join(""));
    }

    /**
     * Validation & Foam
     */
    $.validator.addMethod("lebihBesar", function (value, element, param) {
        // console.log(toNumber(value));
        // console.log(element);
        // console.log(param);
        return this.optional(element) || toNumber(value) > toNumber(param);
    });

    $.validator.setDefaults({
        errorElement: "span",
        errorPlacement: function (error, element) {
            $(error).addClass("invalid-feedback");
            $(element).closest(".form-group").find("span.error").remove();
            $(element).closest(".form-group").append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass("is-invalid");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass("is-invalid");
            $(element).closest(".form-group").find("span.error").remove();
        }
    });

    form_Jual
    .on("input", function () {
        // hitung total item
        let qty = qty_item.val();
        let hrgj = toNumber(hrg_jual.val());
        let disc = toNumber(disc_item.val());
        if (isNaN(disc)) {
            disc = 0
            disc_item.val(disc);
        }

        if (disc <= 100) {
            $('#label_disc').text('%')
            disc = ((qty * hrgj) * (disc/100))
        } else {
            $('#label_disc').text('Rp')
            disc = disc
        }
        tot_harga.val((qty * hrgj)-disc);
    })
    .on("blur", "input#disc_item", function(){
        let qty = qty_item.val();
        let hrgj = toNumber(hrg_jual.val());
        let disc = toNumber(disc_item.val());
        if (isNaN(disc)) {
            disc = 0
            disc_item.val(disc);
        }
        if (disc <= 100) {
            // disc = (hrgj*(disc/100))
            disc = ((qty * hrgj) * (disc/100))
            $(this).val(disc);
        }
    });

    form_Jual.validate({
        ignore: ".ignore",
        rules: {
            code_item: { required: true, minlength: 5, maxlength: 13 },
            nama_item: { required: true },
            hrg_jual: {
                required: true,
                number: true,
                lebihBesar: function(){
                    return hrg_modal.val();
                },
            },
            satuan: { required: true },
            qty: { required: true, min: 0, number: true },
        },

        messages: {
            code_item: {
                required: "Kode Wajib di-isi",
                minlength: $.validator.format("Min. {0} karakter"),
                maxlength: $.validator.format("Min. {0} karakter"),
            },
            nama_item: { required: "Nama Wajib di-isi" },
            hrg_jual: {
                required: "Harga wajib di-isi",
                lebihBesar: "Harga Diatas {0}",
            },
            satuan: { required: "satuan wajib di-isi" },
            qty: {
                required: "Qty wajib di-isi",
                min: "Qty Salah, Min. 1",
            },
        },

        submitHandler: function (form) {
            // console.log(form);
            if (opt_rinci == "UPDATE") {
                // saved item update to tabel_rinci
                updated_Item(target);
            } else if (opt_rinci == "ADD") {
                // saved item baru to tabel_rinci
                tambah_Item();
            }
            // $(form).resetForm();
        },
    });

    form_Nota.validate({
        submitHandler: function (form) {
            //ajax nota
            // console.log("url:"+urlx, "type:"+method);
            // console.log(form);
            $.ajax({
                url: urlx,
                method: method,
                dataType: "json",
                data: $(form).serialize(),
                success: function (resp) {
                    console.log(resp);
                    // return false;

                    let pesan = resp.info.pesan;
                    let isi = resp.info.isi_pesan;
                    let teks = "";
                    isi.forEach(elm => {
                        teks = teks + `<li>`+elm+`</li>`
                    });
                    teks = `<ol class="pl-3">`+teks+`</ol>`

                    // reset
                    formChange();
                    $(document).Toasts('create', {
                        class: 'bg-'+(pesan == 'error' ? 'danger' : pesan),
                        icon: 'fas fa-grin',
                        title: pesan,
                        subtitle: 'Simpan Transaksi',
                        position: 'bottomLeft',
                        autohide: true,
                        delay: 10000,
                        body: teks,
                    });

                    let nota = resp.nota;
                    let rinci = resp.data;
                    let usaha = resp.usaha;

                    $('.logo_struk').attr('src','/profile/'+usaha.logo)
                    $('p.jln_usaha').text(usaha.alamat);
                    $('p.kota_usaha').text(usaha.kota.name +'-'+usaha.telpon);
                    $('p.no_struk').text("No.#: "+nota.no_nota)
                    $('p.tgl_struk').text(dateIndo(nota.created_at, 4,"-", true))
                    $('p.nama_cust').text(nota.cust_name)
                    $('p.kota_cust').text(nota.kota)

                    $('.strukTotal').text(int2rupiah.format(nota.brutto))
                    $('.strukDisc').text(int2rupiah.format(nota.disc))
                    $('.strukGTotal').text(int2rupiah.format(nota.brutto-nota.disc))
                    $('.StrukTunai').text(int2rupiah.format(nota.tunai))
                    $('.strukCard').text(int2rupiah.format(nota.kartu))
                    $('.StrukKredit').text(int2rupiah.format(nota.kredit))
                    $('.strukTempo').text(nota.tempo+" Hari")

                    let bodyStruk = $('table#tabel_struk tbody').html("")
                    let bodyDo = $('table#tabel_do tbody').html("")

                    for (let i = 0; i < rinci.length; i++) {
                        const elm = rinci[i];

                        bodyStruk.append(`
                            <tr>
                                <td colspan="2">`+elm.nama_barang+`</td>
                                <td>
                                    <div class="row">
                                        <div class="col-sm-6 pr-0 text-right">`+elm.qty+`</div>
                                        <div class="col-sm-6">`+elm.satuan+`</div>
                                    </div>
                                </td>
                                <td class="text-right">`+int2rupiah.format((elm.harga_jual*elm.qty)-elm.disc)+`</td>
                            </tr>
                        `);

                        bodyDo.append(`
                            <tr>
                                <td colspan="2">`+elm.nama_barang+`</td>
                                <td>
                                    <div class="row">
                                        <div class="col-sm-6 pr-0 text-right">`+elm.qty+`</div>
                                        <div class="col-sm-6">`+elm.satuan+`</div>
                                    </div>
                                </td>
                            </tr>
                        `);

                    }

                    modal_preview.toggle();
                },
            });
        },
    });

    form_SesiBaru.validate({
        rules: {
            kode_sesi: {
                required: true,
                remote: {
                    url: "sesi-penjualan/cekSesi",
                    type: "post",
                    dataType: "json",
                    // success: function(resp){
                    //     console.log("Cek Sesi:",resp);
                    // }
                },
            },
        },
        messages: {
            kode_sesi: {
                required: "Kode Sesi Belum Ada",
                remote: "Sesi ini sudah ada.",
            },
        },

        submitHandler: function (form) {
            //ajax nota
            $.ajax({
                url: "sesi-penjualan",
                method: "post",
                dataType: "json",
                data: $(form).serialize(),
                success: function (resp) {
                    console.log(resp)
                    // return false;

                    let data = resp.data;
                    let pesan = resp.info.pesan;
                    let isi = resp.info.isi_pesan;

                    kode_sesi = data.kode_sesi; //update sesi_kode

                    nomor_nota.val(kode_sesi + "-001");
                    tgl_nota.val(dateIndo(data.tanggal));
                    petugas.val(resp.data.nama_kasir);

                    let shift = "";
                    if (kode_sesi.substring(0, 1) == "P") {
                        shift = "Pagi";
                    } else if (kode_sesi.substring(0, 1) == "S") {
                        shift = "Siang";
                    } else {
                        shift = "Malam";
                    }

                    $("#kassa_aktif").text(kode_sesi.substring(2, 1));
                    $("#shift_aktif").text(shift);

                    // // reset
                    // formChange("aktif");
                    mynotife(pesan, "Sukses Simpan Sesi Jual", isi);

                    modal_SesiBaru.toggle();
                    modal_sesijual.toggle();
                    formChange("aktif");
                    sesijual = true;
                    btn_sesiOut.show();
                },
            });
            return false;
        },
    });

    /**
     * Sweetalert custom notification
     * @param {*} title string
     * @param {*} content string
     * @param {*} icon warning, success, error, info, question
     * @param {*} switchConfirm string,
     *            [Nota Baru, Batal Transaksi, dan lain-lain]
     */
    function tanya(title, content, html, icon, switchConfirm) {
        Swal.fire({
            title: title,
            text: content,
            html: html,
            icon: icon, //warning, success, error, info, question
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, Yakin",
            cancelButtonText: "Tidak",
            allowOutsideClick: false,
        }).then((result) => {
            if (result.isConfirmed) {
                // Swal.fire("Deleted!", "Your file has been deleted.", "success");
                switch (switchConfirm) {
                    case "Nota Baru":
                        nota_baru(kode_sesi);
                        break;
                    case "Batal Transaksi":
                        batal_nota();
                        break;
                    case "Simpan Transaksi":
                        simpan_nota();
                        break;
                    case "Proses Bayar":
                        bayar_nota();
                        break;
                    case "Edit Nota":
                        edit_nota(id_nota);
                        break;
                    case "Hapus Nota":
                        hapus_nota(id_nota);
                        break;
                    case "Sesi Out":
                        sesi_out(true);
                        break;
                    default:
                        mynotife(
                            "error",
                            "Ada Kesalahan System",
                            "Confirm [" + switchConfirm + "] - Tidak Tersedia"
                        );
                }
            } else {
                kode_Brg.focus();
                return false;
            }
        });
    }

    function mynotife(tipe, judul, pesan) {
        toastr[tipe](pesan, judul);
        toastr.options = {
            closeButton: true,
            onclick: null,
            debug: false,
            newestOnTop: true,
            progressBar: true,
            positionClass: "toast-bottom-left",
            preventDuplicates: true,
            showDuration: "300",
            hideDuration: "1000",
            timeOut: "5000",
            extendedTimeOut: "1000",
            showEasing: "swing",
            hideEasing: "linear",
            showMethod: "fadeIn",
            hideMethod: "fadeOut",
        };
    }

    let btn_cetak = $('button#cetak_struk');
    btn_cetak.on('click', function(){

        // var mode = $("input[name='mode']:checked").val();
        // var close = mode == "popup" && $("input#closePop").is(":checked");
        // var extraCss = $("input[name='extraCss']").val();

        // seleksi print
        var print = "";
        $("input.selPA:checked").each(function(){
            print += (print.length > 0 ? "," : "") + "div.PrintArea." + $(this).val();
        });

        // // attr css, id, class
        // var keepAttr = [];
        // $(".chkAttr").each(function(){
        //     if ($(this).is(":checked") == false )
        //         return;

        //     keepAttr.push( $(this).val() );
        // });

        // var headElements = $("input#addElements").is(":checked") ? '<meta charset="utf-8" />,<meta http-equiv="X-UA-Compatible" content="IE=edge"/>' : '';

        var options = {
            mode: "popup", //"iframe",
            popClose: true,
            // mode : mode,
            // popClose : close,
            // extraCss : extraCss,
            // retainAttr : keepAttr,
            // extraHead : headElements
        };

        $( print ).printArea( options );
    })

    /**
     * run start js
     */
    formChange(); // awal
    $("#jml_x").hide();

    cek_sesijual();
    loadDataBarang();
    loadCustomer();
});
