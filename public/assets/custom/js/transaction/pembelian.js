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
    const int2string_number = new Intl.NumberFormat("en-US", {
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
    });

    $(".select2").select2();
    $(".rupiah").inputmask({ alias: "angka" });
    $("#tempo").inputmask({ alias: "numeric", placeholder: "" });
    $(".currency").inputmask("currency", { rightAlign: true });

    /**
     * Variabel Data Nota
     */
    let nomor_nota = $("input[name=nomor_nota]");
    let tgl_nota = $("input[name=tanggal]");
    let selectSupplier = $("select#supplier");
    let alamat = $("span#alamat");
    let telpon = $("td#telpon");
    let kota = $("td#kota");

    /**
     * Vairabel Foam
     */
    let urlx, method;

    let no_item = 0;
    let tot_item = 0;
    let opt_rinci = ""; //update or add

    /**
     * variabel Form Tabel
     */
    let form_Beli = $("form#form_isian");
    let kode_Brg = $("input[name=code_item]");
    let nama_Brg = $("input[name=nama_item]");
    let hrg_beli = $("input[name=hrg_beli]");
    let satuan = $("select[name=satuan]");
    let qty_item = $("input[name=qty]");
    let tot_harga = $("input[name=total_harga]");

    /**
     * variabel Tabel, Rincian Tabel
     */
    let form_Nota = $("form#nota_pembelian");
    let bayar_Tunai = $("input[name=byrCash]");
    let bayar_Kartu = $("input[name=byrCard]");
    let bayar_Kredit = $("input[name=byrKredit]");
    let jatuh_Tempo = $("input[name=lamaTempo]");
    let sub_Total = $("input[name=subTotal]");
    let total_Disc = $("input[name=discount]");
    let total_Nota = $("input[name=grandTotal]");

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

    let tgl_periode = $("input#tgl_periode");

    /**
     * Global Variable
     */
    let editing = false;
    let isTrash = false;
    let isShow = "false";
    let target = "";

    let tgl_aw =  moment().startOf("month").format('YYYY-MM-DD');
    let tgl_ak = moment().endOf("month").format('YYYY-MM-DD');

    // utk singleDatePicker
    // $(".datemask").inputmask("99-99-9999", {
    //     alias: "date",
    //     insertMode: "true",
    //     yearrange: { minyear: 1000, maxyear: 3000 },
    // });

    $(".datemask").daterangepicker(
        {
            singleDatePicker: true,
            showDropdowns: true,
            autoApply: true,
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
        // callback
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

    tgl_periode.daterangepicker(
        {
            singleDatePicker: false,
            showDropdowns: true,
            // autoApply: true,
            // timePicker: true,
            // timePicker24Hour: true,
            autoUpdateInput: true,
            ranges: {
                Today: [moment(), moment()],
                Yesterday: [
                    moment().subtract(1, "days"),
                    moment().subtract(1, "days"),
                ],
                "Last 7 Days": [moment().subtract(6, "days"), moment()],
                "Last 30 Days": [moment().subtract(29, "days"), moment()],
                "This Month": [
                    moment().startOf("month"),
                    moment().endOf("month"),
                ],
                "Last Month": [
                    moment().subtract(1, "month").startOf("month"),
                    moment().subtract(1, "month").endOf("month"),
                ],
            },
            locale: {
                format: "DD-MM-YYYY",
                separator: " s/d ",
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
            startDate: moment().startOf("month"),
            endDate: moment().endOf("month"),
        },
        /**
         * Function Callback
         * @param {start} start tanggal awal
         * @param {awal} end tanggal akhir
         * @param {label} label Informasi Label Range
         */
        function (start, end, label) {
            $('#label_range').text(label)
            // console.log(
            //     "New date range selected: " +
            //         start.format("DD-MM-YYYY") +
            //         " to " +
            //         end.format("DD-MM-YYYY") +
            //         " (predefined range: " +
            //         label +
            //         ")"
            // );
        },
    );

    tgl_periode.on('apply.daterangepicker', function(ev, picker) {
        tgl_aw = picker.startDate.format('YYYY-MM-DD');
        tgl_ak = picker.endDate.format('YYYY-MM-DD');
        daftar_nota(isShow, tgl_aw, tgl_ak)
    });

    /**
     * Enter as Tab
     */
    // form_Nota.enterAsTab({ allowSubmit: false });
    $("div#inputBayar").enterAsTab({ allowSubmit: false });
    form_Beli.enterAsTab({ allowSubmit: false });


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
        }
    });

    // // User clicks on a cell (global)
    // $("#tabel_barang, #tabel_nota, #tabel_rinci").on(
    //     "click",
    //     "tr, td",
    //     function () {
    //         currCell = $(this);

    //         // let col = $(this).parent().children().index($(this)) + 1;
    //         // let row = $(this).parent().parent().children().index($(this).parent()) + 1;

    //         currRow = currCell.closest("tr");
    //         data_cell = currRow.find("td");
    //         id = currRow.attr("data-id"); //element <tr data-id>

    //         // console.log(
    //         //     "Row: " + row,
    //         //     "Col: " + col,
    //         //     "Value: " + currCell.html()
    //         // );

    //         // let qty = data_cell.find("input.qty_beli").val();
    //         // console.log(qty);

    //         // console.log(id);

    //         // currCell.focus();
    //         currRow.focus();

    //         isTrash = currRow.attr("class") == "trashed" ? true : false;

    //         return false;
    //     }
    // );

    // $("table").on("keydown", function (e) {
    //     // navigation for all table (global)
    //     var c = "";
    //     if (e.which == 39) {
    //         // Right Arrow
    //         c = currCell.next();
    //     } else if (e.which == 37) {
    //         // Left Arrow
    //         c = currCell.prev();
    //     } else if (e.which == 38) {
    //         // Up Arrow
    //         c = currCell
    //             .closest("tr")
    //             .prev()
    //             .find("td:eq(" + currCell.index() + ")");
    //     } else if (e.which == 40) {
    //         // Down Arrow
    //         c = currCell
    //             .closest("tr")
    //             .next()
    //             .find("td:eq(" + currCell.index() + ")");
    //     } else if (!editing && e.which == 9 && !e.shiftKey) {
    //         // Tab
    //         e.preventDefault();
    //         c = currCell.next();
    //     } else if (!editing && e.which == 9 && e.shiftKey) {
    //         // Shift + Tab
    //         e.preventDefault();
    //         c = currCell.prev();
    //     }

    //     if (c.length > 0) {
    //         currCell = c;
    //         currRow = currCell.closest("tr");
    //         data_cell = currRow.find("td");

    //         // currCell.focus();
    //         currRow.focus();

    //         isTrash = currRow.attr("class") == "trashed" ? true : false;
    //     }
    // });

    /**
     * 1. Tabel Data Barang Navigation Keyboard
     */
    /**
     * table key navigate
     * td dikasih tabindex jika ingin di navigate berdasarkan cell dan row
     * tr dikasih tabindex jika ingin di navigate berdasarkan row
     */
    let tabel_barang = $("#tabel_barang");
    let tabel_filter_body = $("#tabel_barang tbody");
    let btn_refresh = $("button#refresh");
    let btn_cariItem = $("button[name=cari_barang]");
    let currRow = tabel_barang.find("tbody tr").first();
    let data_backup;
    let elm_help_barang = document.getElementById("code_item");

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
        });

    // load data barang
    btn_refresh.on("click", loadDataBarang);

    /**End 1. Tabel Barang */

    /**
     * 2. Tabel Rincian Nota
     */
    let edit_rinci = false; // edit data di tabel_rinci
    let tabel_rinci = $("table#tabel_rinci");
    let rincian_Data = $("table#tabel_rinci tbody");
    let currRow1 = rincian_Data.find("tr").first();

    tabel_rinci
        .on("keydown", 'tr', function (e) {
            currRow1 = $(this);
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
                isTrash = currRow1.attr("class") == "trashed" ? true : false;
            }
        })
        .on("click", "tr", function(){
            currRow1 = $(this);
            isTrash = currRow1.attr("class") == "trashed" ? true : false;
        }).on("dblclick", "td input.editable", function () {
            $(this).inputmask({ alias: "angka" });
            edit_rinci = true;
            $(this).prop("readonly", false);
            $(this).focus();
        })
        .on("keydown input", "td input.editable", function (e) {
            let row = $(this).closest("tr"); //elements
            let qty = row.find("input.qty_beli").val();
            let hrg = row.find("input.harga_brg").val();
            let jmlhrg = qty * toNumber(hrg);
            row.find("input.jml_harga").val(int2string_number.format(jmlhrg)); //update jumlah harga
            totalForm();
            if (e.keyCode == 13) {
                edit_rinci = false;
                $(this).prop("readonly", true);
                return false;
            }
        });

    /**
     * 3. Tabel Daftar Transaksi Nota
     */
    let id_nota="";
    let tabel_nota = $("table#tabel_nota");
    let currRow2 = tabel_nota.find("tbody tr").first();
    let swith_nota = $("input#customSwitch1");

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
        .on('dblclick', "tr", function(e) {
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

    swith_nota.on("click", function () {
        isShow = $(this).prop("checked") ? "true" : "false";
        daftar_nota(isShow, tgl_aw, tgl_ak);
    });

    /**
     * Form Isian
     */

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
                tabel_filter_body.html("");
                data_backup.children().filter(function(){
                    let hasil = $(this).text().toLowerCase().indexOf(value);
                    if (hasil > -1) {
                        $(this).clone().appendTo(tabel_filter_body)
                    }
                })
                currRow = tabel_barang.find("tbody tr").first();
                $("div#note_cari").html("Gunakan Mouse Klik / Tombol Enter utk ambil barang, seleksi item gunakan panah atas bawah");
            } else {
                // esc key
                if (value == "") {
                    tutupLayarBarang();
                }
            }
        });

    /**
     * Button Trigger function
     */

    // Update Item
    btn_ActionForm
        .on("click", "button#btn-update", function () {
            opt_rinci = "UPDATE";
            // di handle submitHandler by button click
            form_Beli.submit();
        })
        .on("click", "button#btn-cancel", function () {
            //reset
            opt_rinci = "ADD";

            resetform_beli();
            form_Beli.trigger("reset");

            btn_TambahItem.show();
            btn_ActionForm.html("");
            $("tr").removeClass("selected-row");
        });

    // Nota Baru
    btn_NotaBaru.on("click", function () {
        if (toNumber(sub_Total.val()) > 0) {
            tanya(
                "Buat Nota Baru?",
                "Transaksi saat ini akan di-Batalkan jika Nota Baru di-Buat.",
                "",
                "warning",
                "Nota Baru" //call function
            );
        } else {
            nota_baru(); // call function
        }
    });

    // Daftar Transaksi
    btn_DaftarNota.on("click", function () {
        daftar_nota(isShow, tgl_aw, tgl_ak);
    });

    // Tambah Item Baru
    btn_TambahItem.on("click", function () {
        opt_rinci = "ADD";
        // di-handle oleh submit by button
        form_Beli.submit();
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
            toastr.error(
                "Pembayaran Masih ada Selisih atau belum di-isi",
                "Simpan Transaksi"
            );
        }
        return false;
    });

    // Input Bayar Nota
    btn_Bayar.on("click", function (e) {
        e.preventDefault();
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

    selectSupplier
        .on("change", function () {
            let opt = $(this.options[this.selectedIndex]);
            let getAlamat = $.trim(opt.attr("data-alamat"));
            let getTelp = $.trim(opt.attr("data-telp"));
            let getKota = $.trim(opt.attr("data-kota"));
            let getId = opt.attr("value"); // same --> id = $(this).val();

            alamat.html(getAlamat);
            telpon.html(getTelp);
            kota.html(getKota);
        })
        .change();

    $("div#inputBayar").on("input", function (e) {
        e.preventDefault();
        totalForm();
        input_bayar();
    });

    /**
     * Function
     */

    /**
     * form Aksi Submit Nota Pembelian
     * @param {*} action string (Tambah, Edit, Hapus)
     * @param {*} idx string (nomor nota)
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
            if (currRow.length > 0) {
                currRow.focus();
            }
        }
    }

    function tutupLayarBarang() {
        $("div#popup-item").hide();
        kode_Brg.focus();
    }

    function cari_barang_onkey(code) {
        $.ajax({
            url: "/cari-barang/" + code,
            method: "post",
            data: { code: code },
            success: function (resp) {
                let data = resp.data;
                if (data != null) {
                    // console.log(data);
                    nama_Brg.val(data.name);
                    hrg_beli.val(data.harga_beli);
                    satuan.val(data.sat_beli);

                    satuan.trigger("change");
                    satuan.prop("disabled", true);

                    $("div#popup-item").hide();
                    $("span#label_satuan").text(data.sat_beli);

                    hrg_beli.prop("disabled", false);
                    qty_item.prop("disabled", false);
                    hrg_beli.focus();
                }
            },
            error: function (err) {
                console.log(err);
            },
        });
        return false;
    }

    function cari_barang(code) {
        $.ajax({
            url: "/cari-barang/" + code,
            method: "post",
            data: { code: code },
            success: function (resp) {
                let data = resp.data;
                if (data != null) {
                    // console.log(data[0]);
                    nama_Brg.val(data.name);
                    hrg_beli.val(data.harga_beli);
                    satuan.val(data.sat_beli);

                    satuan.trigger("change");
                    satuan.prop("disabled", true);

                    $("div#popup-item").hide();
                    $("span#label_satuan").text(data.sat_beli);

                    hrg_beli.prop("disabled", false);
                    qty_item.prop("disabled", false);
                    hrg_beli.focus();
                } else {
                    toastr.error(
                        "<b>Data Tidak Di-Temukan</b>",
                        "Cari Barang : " + code
                    );
                    resetform_beli();
                    // toni
                }
            },
            error: function (err) {
                console.log(err);
            },
        });
        return false;
    }

    // load data barang
    function loadDataBarang() {
        let daftar_barang = $("table#tabel_barang tbody");
        $.ajax({
            url: "/master-data/products/load-data",
            type: "GET",
            dataType: "json",
            beforeSend: function() {
                // setting a timeout
                $("#loading").show();
            },
            complete: function() {
                $("#loading").hide();
            },
            success: function (resp) {
                let data = resp.data;
                daftar_barang.html("");
                if (data.length == 0) {
                    daftar_barang.html(
                        `<tr><td colspan="4" class="text-center">Data Tidak Tersedia</td></tr>`
                    );
                } else {
                    for (let i = 0; i < data.length; i++) {
                        let rowdata =
                            `<tr tabindex="` +data[i].id +`" data-id="` +data[i].id +`">
                                <td>` +data[i].code +`</td>
                                <td>` +data[i].name +`</td>
                                <td>` +data[i].sat_beli +`</td>
                                <td>` +int2string_number.format(data[i].harga_beli) +`</td>
                            </tr>`;
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
        return false;
    }

    function formAction(action, idx) {
        switch (action) {
            case "Tambah":
                urlx = "nota-pembelian";
                method = "POST";
                break;
            case "Edit":
                urlx = "nota-pembelian/" + idx;
                method = "PUT";
                /**
                 * method untuk ajaxForm
                 */
                // method = "POST";
                // $("#method").replaceWith(
                //     `<input type="hidden" name="_method" value="PUT">`
                // );
                break;
            case "Hapus":
                urlx = "nota-pembelian/" + idx;
                method = "DELETE";
                break;
        }
        // form_Nota.attr("action", urlx);
        // form_Nota.attr("method", method);
    }

    function resetform_beli() {
        form_Nota.trigger("reset");
        form_Beli.trigger("reset");

        kode_Brg.val("");
        nama_Brg.val("");
        satuan.val("");
        satuan.trigger("change");
        qty_item.val("0");
        hrg_beli.val("0");
        tot_harga.val("0");
        // jatuh_Tempo.val("14");

        nama_Brg.prop("disabled", true);
        hrg_beli.prop("disabled", true);
        satuan.prop("disabled", true);
        qty_item.prop("disabled", true);
        tot_harga.prop("disabled", true);

        $("span#label_satuan").text("?");
        $("input").removeClass("is-invalid");
        $("span.error").remove();

        btn_TambahItem.show();
        kode_Brg.focus();
    }

    function showButtonAction() {
        btn_ActionForm.html(
            `<button class="btn btn-sm btn-info" type="button" id="btn-update">Simpan</button>` +
                " " +
                `<button class="btn btn-sm btn-warning" type="button" id="btn-cancel">Batal</button>`
        );
    }

    function formChange(xform) {
        resetform_beli();

        if (xform == "aktif") {
            btn_TambahItem.prop("disabled", false);
            btn_cariItem.prop("disabled", false);

            btn_Batal.prop("disabled", false);
            btn_Simpan.prop("disabled", true);

            kode_Brg.prop("disabled", false);
            selectSupplier.prop("disabled", false);
            tgl_nota.prop("readonly", false);

            kode_Brg.focus();
        } else {
            btn_TambahItem.prop("disabled", true);
            btn_cariItem.prop("disabled", true);

            kode_Brg.prop("disabled", true);
            selectSupplier.prop("disabled", true);
            tgl_nota.prop("readonly", true);

            btn_ActionForm.empty();

            btn_Batal.prop("disabled", true);
            btn_Simpan.prop("disabled", true);
            btn_Bayar.prop("disabled", true);

            btn_editItem.prop("disabled", true);
            btn_hapusItem.prop("disabled", true);

            //reset
            no_item = 0;
            tot_item = 0;
            $("span#total_item").text(no_item);

            $("div.card-footer.nota input").prop("readonly", true);
            $("div.card-footer.nota input").prop("value", "0");

            //reset
            editing = false;
            rincian_Data.html("");
        }
        return false;
    }

    let data_nota = $("table#tabel_nota tbody");
    function daftar_nota(isTrashed, tgl1, tgl2) {
        $.ajax({
            url: "load-nota-pembelian/" + isTrashed,
            method: "post",
            data: {
                tgl_aw: tgl1,
                tgl_ak: tgl2
            },
            success: function (resp) {
                console.log(resp);
                // return false;

                let nota = resp.data;

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

                        rowdata =
                            `<tr tabindex="` +nobrs +`" data-id="` +nota[x].id +`" class="` +trash +`">
                                <td tabindex="1" class="text-center">` +nobrs +`</td>
                                <td tabindex="2" class="text-center">` +nota[x].no_nota +`</td>
                                <td tabindex="3" class="text-center">` +dateIndo(nota[x].tanggal) +`</td>
                                <td tabindex="4" class="text-right">` +int2string_number.format(nota[x].total) +`</td>
                                <td tabindex="5">` +nota[x].nama_supplier +`</td>
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
                $("#byr_tunai_info").text(int2string_number.format(tot_tunai))
                $("#byr_kartu_info").text(int2string_number.format(tot_kartu))
                $("#byr_kredit_info").text(int2string_number.format(tot_kredit))
                $("#pot_disc_info").text(int2string_number.format(tot_disc))
                $("#total_nota_info").text(int2string_number.format(total_all))

                // tampilkan daftar nota
                $("#daftar-nota").modal("show");
                data_nota.find("tr").first().focus();
            },
        });
    }

    function nota_baru() {
        formChange("aktif");
        rincian_Data.html(
            `<tr id="no-data"><td colspan="7" class="text-center">Data Barang Masih Kosong</td></tr>`
        );
        opt_rinci = "ADD";
        /**
         * get no nota terakhir
         */
        $.ajax({
            url: "getnotrx",
            type: "post",
            dataType: "json",
            success: function (data) {
                console.log(data);
                nomor_nota.val(data.no_trx);
                kode_Brg.focus();
            },
            error: function (err) {
                console.log(err);
            },
        });
    }

    function batal_nota() {
        formChange();
        rincian_Data.html("");
    }

    function bayar_nota() {
        $("div.card-footer.nota input").prop("readonly", false);
        sub_Total.prop("readonly", true);
        total_Nota.prop("readonly", true);
        jatuh_Tempo.prop("readonly", true);
        bayar_Tunai.focus();
        input_bayar();
        totalForm();
    }

    function simpan_nota() {
        // cek tempo
        if (toNumber(bayar_Kredit.val()) > 0 && jatuh_Tempo.val() == 0) {
            toastr.error(
                "Tempo Pembayaran Kredit Belum di-Masukkan",
                "Tempo Kredit"
            );
            jatuh_Tempo.focus();
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

    function edit_nota(id) {
        editing = true;
        /**
         * get rincian nota from database
         */
        $.ajax({
            url: "load-data-nota/" + id,
            type: "get",
            dataType: "json",
            success: function (resp) {
                let nota = resp.nota;
                let rinci = resp.data;

                // console.log(resp);

                if (rinci.length > 0) {
                    formChange("aktif");
                    opt_rinci = "ADD";
                    rincian_Data.html("");

                    //--update layar tabel nota pembelian & rincian
                    nomor_nota.val(nota.no_nota);
                    tgl_nota.val(dateIndo(nota.tanggal));
                    selectSupplier.val(nota.supplier_id);
                    selectSupplier.trigger("change");

                    bayar_Tunai.val(int2string_number.format(nota.tunai));
                    bayar_Kartu.val(int2string_number.format(nota.kartu));
                    bayar_Kredit.val(int2string_number.format(nota.kredit));
                    jatuh_Tempo.val(nota.tempo);
                    sub_Total.val(int2string_number.format(nota.brutto));
                    total_Disc.val(int2string_number.format(nota.disc));
                    total_Nota.val(int2string_number.format(nota.total));

                    //--update layar tabel rincian
                    no_item = tot_item = 0;
                    for (let i = 0; i < rinci.length; i++) {
                        no_item++;
                        tot_item++;
                        rincian_Data.append(
                            `<tr tabindex="` +no_item +`" data-id="` +no_item +`">
                                <td class="text-center no_urut">` +tot_item +`</td>
                                <td>
                                    <input type="text" name="kode_brg[]" value="` + $.trim(rinci[i].code) +`" class="kode_brg form-control form-control-sm text-center " readonly>
                                </td>
                                <td>
                                    <input type="text" name="nama_brg[]" value="` + rinci[i].nama_barang +`" class="nama_brg form-control form-control-sm" disabled>
                                </td>
                                <td>
                                    <input type="text" name="harga_brg[]" value="` + int2string_number.format(rinci[i].harga_beli) +`" class="harga_brg form-control form-control-sm text-right editable rupiah" readonly>
                                </td>
                                <td>
                                    <div class="form-group row">
                                        <div class="col-sm-7 qty">
                                            <input type="number" name="qty_beli[]" value="` + rinci[i].qty +`" class="qty_beli form-control form-control-sm editable text-right" readonly>
                                        </div>
                                        <div class="col-sm-5 satuan">
                                            <input type="text" name="satuan[]" value="` + rinci[i].satuan +`" class="satuan form-control form-control-sm " readonly>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <input type="text" name="jml_harga[]" value="` + int2string_number.format(rinci[i].harga_beli * rinci[i].qty) +`" class="jml_harga form-control form-control-sm text-right rupiah" disabled>
                                </td>
                            </tr>
                            `
                        );
                    }

                    $("span#total_item").text(tot_item);
                    kode_Brg.focus();
                    btn_Bayar.prop("disabled", false);
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

    function hapus_nota(id) {
        formAction("Hapus", id);
        $.ajax({
            url: urlx,
            type: method,
            success: function (resp) {
                console.log(resp);
                mynotife("success", "Hapus Nota", resp.success);
                daftar_nota(isShow, tgl_aw, tgl_ak);
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
        }

        let harga = toDouble(hrg_beli.val());
        let jumlah = qty_item.val() * harga;

        if (jumlah > 0) {
            no_item++;
            tot_item++;
            $("span#total_item").text(tot_item);

            //cari item yg sama kode dan harga
            let cari_kode = rincian_Data.find('tr').children().find(":input.kode_brg[value="+kode_Brg.val()+"]");
            let ada = false;

            if (cari_kode.length > 0) {
                let cari_row = cari_kode.closest('tr');
                let e_harga = cari_row.find('td input.harga_brg');
                let e_qty = cari_row.find('td input.qty_beli');
                let e_jmlhrg = cari_row.find('td input.jml_harga');

                // update Qty item lama
                if ( e_harga.val() == hrg_beli.val() ) {
                    let tot_qty = toNumber(e_qty.val()) + toNumber(qty_item.val());
                    let tot_hrg = tot_qty * toNumber(hrg_beli.val());

                    e_qty.val(tot_qty);
                    e_jmlhrg.val(int2string_number.format(tot_hrg));
                    ada = true;
                    tambah_item_respon('Item Lama','Sukses Tambah Qty')
                }
            }
            if (ada == false) {
                rincian_Data.append(
                    `<tr tabindex="` +
                        no_item +`" data-id="` +no_item +`">
                        <td class="text-center no_urut">` +tot_item +`</td>
                        <td>
                            <input type="text" name="kode_brg[]" value="` +$.trim(kode_Brg.val()) +`" class="kode_brg form-control form-control-sm text-center " readonly>
                        </td>
                        <td>
                            <input type="text" name="nama_brg[]" value="` +nama_Brg.val() +`" class="nama_brg form-control form-control-sm" disabled>
                        </td>
                        <td>
                            <input type="text" name="harga_brg[]" value="` +int2string_number.format(harga) +`" class="harga_brg form-control form-control-sm text-right editable rupiah" readonly>
                        </td>
                        <td>
                            <div class="form-group row">
                                <div class="col-sm-7 qty ">
                                    <input type="number" name="qty_beli[]" value="` +toNumber(qty_item.val()) +`" class="qty_beli form-control form-control-sm editable text-right" readonly>
                                </div>
                                <div class="col-sm-5 satuan">
                                    <input type="text" name="satuan[]" value="` +satuan.val() +`" class="satuan form-control form-control-sm " readonly>
                                </div>
                            </div>
                        </td>
                        <td>
                            <input type="text" name="jml_harga[]" value="` +int2string_number.format(jumlah) +`" class="jml_harga form-control form-control-sm text-right rupiah" disabled>
                        </td>
                    </tr>`
                );
                tambah_item_respon('Item Baru','Sukses di-Tambahkan');
            }
            totalForm();
        } else {
            toastr.error(
                "Total Harga Salah / Masih Kosong",
                "Form Input Salah"
            );
            qty_item.focus();
        }
    }

    function tambah_item_respon(ket, info) {
        toastr.success(nama_Brg.val() + "<br>" + info, ket);
         // reset form isian manual
        kode_Brg.val("");
        nama_Brg.val("");
        hrg_beli.val(0);
        satuan.val("BALL");
        satuan.trigger("change");
        qty_item.val(0);
        tot_harga.val(0);

        kode_Brg.focus();
        hrg_beli.prop("disabled", true);
        qty_item.prop("disabled", true);
    }

    // function Updated Item
    function updated_Item(target) {
        target.find("input.kode_brg").val(kode_Brg.val());
        target.find("input.nama_brg").val(nama_Brg.val());
        target.find("input.satuan").val(satuan.val());
        target.find("input.qty_beli").val(qty_item.val());
        target.find("input.harga_brg").val(hrg_beli.val());
        target.find("input.jml_harga").val(tot_harga.val());

        //reset
        opt_rinci = "ADD";
        btn_TambahItem.show();
        btn_ActionForm.html("");
        // btn_TambahItem.attr("type", "submit");

        resetform_beli();

        hrg_beli.prop("disabled", true);
        qty_item.prop("disabled", true);

        kode_Brg.focus();
        $("tr").removeClass("selected-row");

        totalForm();
        input_bayar();

        toastr.success("<b>Sukses di-Update</b>", "Update Item");
    }

    function edit_Item(target) {
        opt_rinci = "UPDATE";

        // with direct val() to get value input
        let kode = target.find("input.kode_brg").val();
        let nama = target.find("input.nama_brg").val();
        let sat = target.find("input.satuan").val();
        let qty = target.find("input.qty_beli").val();
        let hrg = target.find("input.harga_brg").val();

        //update layar isian form data
        kode_Brg.val(kode);
        nama_Brg.val(nama);
        hrg_beli.val(hrg);
        satuan.val(sat);
        satuan.trigger("change");
        qty_item.val(qty);
        tot_harga.val(qty * toNumber(hrg));
        $("span#label_satuan").text(sat);

        $("tr").removeClass("selected-row");
        target.addClass("selected-row");

        showButtonAction();
        btn_TambahItem.hide();
        hrg_beli.prop("disabled", false);
        qty_item.prop("disabled", false);

        qty_item.focus();
    }

    function hapus_Item(target) {
        let nou = target.find("td.no_urut").text();
        let kode = target.find("input.kode_brg").val();
        let nama = target.find("input.nama_brg").val();
        let sat = target.find("input.satuan").val();
        let qty = target.find("input.qty_beli").val();
        let hrg = target.find("input.harga_brg").val();

        Swal.fire({
            icon: "warning",
            title: "Hapus Item Barang?",
            html:
                "Item No. : <b>" +
                nou +
                "</b> - Kode : <b>" +
                kode +
                "</b><br>Nama : <b>" +
                nama +
                "</b><br>Qty : <b>" +
                qty +
                " " +
                sat +
                "  x (Rp. " +
                int2string_number.format(toNumber(hrg)) +
                ")",
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
                input_bayar();
                toastr.success("<b>Sukses di-Hapus</b>", "Hapus Item");
                kode_Brg.focus();
            }
        });
    }

    // function hitung total form
    function totalForm() {
        let v_subTotal = 0;
        let grand_total = 0;

        // input dalam rincian tabel nota
        let s_harga = $("input.harga_brg");
        let s_qty = $("input.qty_beli");
        let s_jumlah = $("input.jml_harga");
        tot_item = 0;

        for (let i = 0; i < s_jumlah.length; i++) {
            const xhrg = toNumber(s_harga[i].value);
            const xqty = s_qty[i].value;
            const xjmlhrg = xhrg * xqty;
            if (!isNaN(xjmlhrg)) {
                v_subTotal += parseInt(xjmlhrg);
            }
            tot_item++;
        }

        // input form isian
        let qty = qty_item.val();
        let jml = toDouble(hrg_beli.val());

        // update nilai total harga per Item
        tot_harga.val(qty * jml);

        let disc = toNumber(total_Disc.val());
        if (disc > v_subTotal) {
            total_Disc.val(0);
            disc = 0;
        }

        grand_total = v_subTotal - disc;

        // update nilai total nota
        sub_Total.val(v_subTotal);
        total_Nota.val(grand_total);

        if (v_subTotal > 0) {
            btn_Bayar.prop("disabled", false);
        } else {
            btn_Bayar.prop("disabled", true);
        }
        // update total item
        $("span#total_item").text(tot_item);
    }

    function input_bayar() {
        let grand_total =
            toNumber(sub_Total.val()) - toNumber(total_Disc.val());
        // input pembayaran
        let total_bayar =
            toNumber(bayar_Tunai.val()) +
            toNumber(bayar_Kartu.val()) +
            toNumber(bayar_Kredit.val());

        let sisa_bayar = grand_total - total_bayar;

        $("span#total_selisih").text(
            "Rp. " + int2string_number.format(sisa_bayar * -1)
        );

        if (toNumber(bayar_Kredit.val()) > 0) {
            jatuh_Tempo.prop("readonly", false);
        } else {
            jatuh_Tempo.val(0);
            jatuh_Tempo.prop("readonly", true);
        }

        if (sisa_bayar > 0) {
            // toastr.error("Pembayaran masih ada selisih", "Pembayaran");
            btn_Simpan.prop("disabled", true);
            $("span#total_selisih").css("color", "red");
            $("div#selisih_ket").html("Kurang Bayar :");
        } else if (sisa_bayar < 0) {
            btn_Simpan.prop("disabled", true);
            $("span#total_selisih").css("color", "blue");
            $("div#selisih_ket").html("Lebih Bayar :");
        } else if (sisa_bayar == 0) {
            $("span#total_selisih").css("color", "black");
            $("span#total_selisih").text("OK - Pass");
            $("div#selisih_ket").html("Sisa Bayar :");
            btn_Simpan.prop("disabled", false);
        }
    }

    // ambil data dari tabel bantu barang
    function getProduct(data) {
        kode_Brg.val(data[0].innerHTML);
        nama_Brg.val(data[1].innerHTML);
        satuan.val(data[2].innerHTML);
        hrg_beli.val(data[3].innerHTML);

        satuan.trigger("change");
        satuan.prop("disabled", true);

        let qty = qty_item.val();
        let jml = toDouble(hrg_beli.val());
        tot_harga.val(qty * jml);

        $("span#label_satuan").text(satuan.val());
        $("div#popup-item").hide();

        hrg_beli.prop("disabled", false);
        qty_item.prop("disabled", false);

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
            top: rect.top + window.scrollY - 20,
        };
    }

    // Convertion date (yyyy-mm-dd) to dd-mm-yyyy
    function dateIndo(tanggal) {
        let cTgl = new Date(tanggal); //new Date(2021,11,01) -- year, month(0-11), and day
        let dd = String(cTgl.getDate()).padStart(2, "0");
        let mm = String(cTgl.getMonth() + 1).padStart(2, "0"); //January is 0!
        let yyyy = cTgl.getFullYear();
        cTgl = dd + "-" + mm + "-" + yyyy;

        return cTgl;
    }

    // Convertion string to Number/Double(float)
    function toNumber(string) {
        return parseInt(string.split(",").join(""));
    }
    function toDouble(string) {
        return parseFloat(string.split(",").join(""));
    }

    /**
     * Validation Foam
     */
    $.validator.addMethod("lebihBesar", function (value, element, param) {
        // console.log(toNumber(value));
        // console.log(element);
        // console.log(param);
        return this.optional(element) || toNumber(value) > param;
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

    form_Beli.on("input", function () {
        // hitung total item
        let qty = qty_item.val();
        let jml = toDouble(hrg_beli.val());
        tot_harga.val(qty * jml);
    });

    form_Beli.validate({
        ignore: ".ignore",
        rules: {
            code_item: { required: true, minlength: 5, maxlength: 13 },
            nama_item: { required: true },
            hrg_beli: { required: true, lebihBesar: "100", number: true },
            satuan: { required: true },
            qty: { required: true, min: 1, number: true },
        },

        messages: {
            code_item: {
                required: "Kode Wajib di-isi",
                minlength: $.validator.format("Min. {0} karakter"),
                maxlength: $.validator.format("Min. {0} karakter"),
            },
            nama_item: { required: "Nama Wajib di-isi" },
            hrg_beli: {
                required: "Harga wajib di-isi",
                lebihBesar: "Harga Diatas {0}",
            },
            satuan: { required: "satuan wajib di-isi" },
            qty: {
                required: "Qty wajib di-isi",
                min: "Qty Salah, Min. 1",
            },
        },

        submitHandler: function () {
            if (opt_rinci == "UPDATE") {
                // saved item update to tabel_rinci
                updated_Item(target);
            } else if (opt_rinci == "ADD") {
                // saved item baru to tabel_rinci
                tambah_Item();
            }
        },
    });

    form_Nota.validate({
        submitHandler: function (form) {
            //ajax nota
            $.ajax({
                url: urlx,
                method: method,
                dataType: "json",
                data: $(form).serialize(),
                success: function (resp) {
                    console.log(resp);

                    // reset
                    formChange();

                    toastr.success(
                        "Transaksi Nota Sukses Di-Simpan",
                        "Simpan Transaksi"
                    );
                },
            });
        },
    });

    /**
     * Sweetalert custom
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
                        nota_baru();
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
                    default:
                        mynotife(
                            "error",
                            "Ada Kesalahan System",
                            "Confirm [" + switchConfirm + "] - Tidak Tersedia"
                        );
                }
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

    /**
     * run start js
     */
    formChange();
    loadDataBarang();
});
