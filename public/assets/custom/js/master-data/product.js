/**
 * Product Catalog
 */

$(function () {
    ("use strict");

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
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
    $("input[name=code]").inputmask({ alias: "number" });

    // $("input[name=code]").inputmask("9999999999999", {
    //     removeMaskOnSubmit: true,
    //     clearMaskOnLostFocus: true,
    // });

    const rupiah = new Intl.NumberFormat("en-US", {
        // style: "currency",
        // currency: "IDR",
        minimumFractionDigits: 0,
    });

    let aksi, urlx, method, id, row;
    let sat_jual = sat_beli = null;
    let sat_multi = "";
    let cols = [];
    let hrg_dasar = 0

    let formProduct = $("form#form_product");
    let btn_action_form = $("#btn_action");
    let btn_tambah = $("button#btn_add_data");
    let btn_reload = $("button#btn_reload");
    let btn_EditData = $("button#btn_edit")
    let btn_HapusData = $("button#btn_hapus")

    let oldCode = "";
    let hrg_beli = $("input#hrg_beli");
    let hrg_modal = $("input#hrg_modal");
    let nilai_konv = $("input#nilai_konversi");
    let beratSatuan = $("input#berat_satuan");
    let berat_dasar = 1;

    let selectKonv = $("select[name=satuan_konversi]");
    let selectbeli = $("select[name=satuan_beli]");
    let selectjual = $("select[name=satuan_jual]");
    let selectKategori = $("select[name=kategori]");
    let selectbeli_lama = $("select[name=satuan_beli]").prop("innerHTML");

    let image_input = $("input#inputFile");
    let getFile;

    formProduct.enterAsTab({ allowSubmit: false });

    let tabeldata = $("table#tabel_products tbody");

    let tabel_products = $("#tabel_products");
    let currRow = tabel_products.find("tbody tr").first();
    let currCell = tabel_products.find("tbody td").first();
    let data_backup;

    let btn_group = $('#btn_group')
    let input_filter = $('#filter_product')

    let options = {
        // url: "products",
        // type: "POST",
        dataType: "json",
        clearForm: true,
        resetForm: true,
        // complete: function (resp) {}
        // target: "#output1", // target element(s) to be updated with server response
        // beforeSubmit: validate,
        // beforeSubmit: showRequest, // pre-submit callback

        success: function (resp) {
            console.log(resp);
            // return false;

            let info = resp.pesan;
            let isi_pesan = info.ket;
            let teks = "";
            let data = resp.data;

            isi_pesan.forEach(elm => {
                teks = teks + `<li>`+elm+`</li>`
            });
            teks = `<ol class="pl-3">`+teks+`</ol>`

            if (info.status == "error") {
                $(document).Toasts('create', {
                    class: 'bg-danger',
                    title: 'Ada Kesalahan',
                    position: 'bottomLeft',
                    subtitle: 'Simpan Data',
                    icon: 'fas fa-frown',
                    body: teks,
                })
            } else {
                //success
                $(document).Toasts('create', {
                    class: 'bg-success',
                    icon: 'fas fa-grin',
                    title: 'Sukses',
                    subtitle: 'Simpan Data',
                    position: 'bottomLeft',
                    autohide: true,
                    delay: 8000,
                    body: teks,
                })

                btn_tambah.show();
                btn_action_form.html("");

                formChange();
                modal_form.toggle()

                // save data
                if (cols.length > 1) {
                    // update data only for screen
                    // console.log(currRow);
                    // console.log(cols);

                    let sat_konv = "-"
                    let nil_konv = "-";

                    if (data.sat_konversi != null) {
                        let kv = data.sat_konversi.split('-');
                        sat_konv = kv[0]; //satuan konversi
                        nil_konv = "("+kv[1]+")"; //nilai Konversi
                    }

                    $(cols[1]).text(data.code);
                    $(cols[2]).text(data.name);
                    $(cols[3]).text(data.kategori);
                    $(cols[4]).html(sat_konv + nil_konv);
                    $(cols[5]).html(`<div class="row m-0">
                        <div class="col-7 text-right">`+ rupiah.format(data.harga_beli) +`</div>
                        <div class="col-5 text-nowrap">/`+ data.sat_beli +`</div>
                        </div>`)
                    $(cols[6]).html(`<div class="row m-0">
                        <div class="col-7 text-right">`+ rupiah.format(data.harga_jual) +`</div>
                        <div class="col-5 text-nowrap">/`+ data.sat_jual +`</div>
                        </div>`)
                    $(cols[7]).html(`<div class="row m-0">
                        <div class="col-7 text-right">`+ rupiah.format(data.stock_aw) +`</div>
                        <div class="col-5 text-nowrap">`+ data.sat_beli +`</div>
                        </div>`)
                    $(cols[8]).html(`<div class="row m-0">
                        <div class="col-7 text-right">`+ rupiah.format(data.stock_ak) +`</div>
                        <div class="col-5 text-nowrap">`+ data.sat_beli +`</div>
                        </div>`)

                    cols = [];
                    currRow.removeClass('selected-row')
                    currRow.focus();
                    reload_data(); //re-backup for filter
                } else {
                    // Data Baru
                    let no = toNumber($('#tot_rec').text()) + 1
                    $('#tot_rec').text(rupiah.format(no))

                    let sat_konv = "-"
                    let nil_konv = "-";

                    if (data.sat_konversi != null) {
                        let kv = data.sat_konversi.split('-');
                        sat_konv = kv[0]; //satuan konversi
                        nil_konv = "("+kv[1]+")"; //nilai Konversi
                    }

                    let rowdata =
                    `<tr tabindex="`+no+`" id="`+data.id+`">
                        <td class="text-center">` + no + `</td>
                        <td tabindex="1" class="text-center">` + data.code + `</td>
                        <td tabindex="2">` + data.name + `</td>
                        <td tabindex="3" class="text-center">` + data.kategori + `</td>
                        <td tabindex="4" class="text-center">` + sat_konv + nil_konv + `</td>
                        <td tabindex="5">
                            <div class="row m-0">
                                <div class="col-7 text-right">`+ rupiah.format(data.harga_beli) +`</div>
                                <div class="col-5 text-nowrap">/`+ data.sat_beli +`</div>
                            </div>
                        </td>
                        <td tabindex="6">
                            <div class="row m-0">
                                <div class="col-7 text-right">`+ rupiah.format(data.harga_jual) +`</div>
                                <div class="col-5 text-nowrap">/`+ data.sat_jual +`</div>
                            </div>
                        </td>
                        <td tabindex="7">
                            <div class="row m-0">
                                <div class="col-7 text-right">`+ rupiah.format(data.stock_aw) +`</div>
                                <div class="col-5 text-nowrap">`+ data.sat_beli +`</div>
                            </div>
                        </td>
                        <td tabindex="8">
                            <div class="row m-0">
                                <div class="col-7 text-right">`+ rupiah.format(data.stock_ak) +`</div>
                                <div class="col-5 text-nowrap">`+ data.sat_beli +`</div>
                            </div>
                        </td>
                    </tr>`;
                    // <td class="text-center">
                    //     <button class="btn btn-xs btn-warning" name="btn-edit" data-id="` + data.id + `" >Edit</button>
                    //     <button class="btn btn-xs btn-danger" name="btn-delete" data-id="` + data.id + `">Hapus</button>
                    // </td>

                    // tidak butuh reload data
                    tabeldata.append(rowdata);
                    data_backup.append(rowdata);

                    let cell = currCell.parent().parent().find('tr').last().find("td:eq(" + currCell.index() + ")");
                    currCell = cell;
                    currRow = currCell.closest('tr');
                    currRow.focus();
                }
            }
            return false;
        }, // post-submit callback
    };

    let modal_form = new bootstrap.Modal(
        document.getElementById("modal_form_product"),
        {keyboard: false, backdrop: "static"}
    );

    /**
     * Button Triger
     */

    image_input.on('change', function(){
        previewFile($(this));
    })

    tabel_products
    .on("keydown", navigation)
    .on('click', 'td', function(){
        currCell = $(this);
        currRow = currCell.closest('tr');
        currCell.focus();
    })
    .on('dblclick', 'td', function(){
        currCell = $(this);
        currRow = currCell.closest('tr');
        currCell.focus();
        btn_EditData.trigger('click');
    });

    btn_tambah
    .on("click", function () {
        btn_action_form.html(`
            <button type="submit" class="btn btn-outline-primary btn-xs mr-1" id="btn_simpan"><i class="fas fa-save"></i> Simpan</button></a>
            <button type="button" class="btn btn-outline-danger btn-xs" id="btn_batal"><i class="fas fa-times"></i> Batal</button></a>
        `);
        aksi = "tambah";
        oldCode = "";
        $(".info-aksi").text('Tambah Data');
        $("form#form_product select").trigger("change");
        $("#previewImg").attr("src", '/assets/custom/gambar/gambar_product.png');
        modal_form.toggle();
        formAction(aksi, "");
        formChange(true);

    });

    btn_EditData
    .on("click", function(){
        id = currRow.attr("id");
        cols = currRow.find("td");
        $("tr").removeClass("selected-row");
        currRow.addClass("selected-row");
        aksi = "edit";
        $(".info-aksi").text('Edit Data');
        oldCode = $(cols[1]).text();
        formAction(aksi, id);
        edit_data(id)
    });

    btn_HapusData
    .on("click", function(){
        id = currRow.attr("id");
        let cell = currRow.find("td");
        aksi = "hapus";
        formAction(aksi, id);
        tanya(
            "Product ini di-Hapus?",
            "Isi Content",
            "Code/Barcode : " + "<b>" + $(cell[1]).text() + "</b><br>"+
            "Nama Product : " + "<b>" + $(cell[2]).text() + "</b><br>"+
            "Harga Beli : " + "<b>" + $(cell[5]).text() + "</b><br>"+
            "Harga Jual : " + "<b>" + $(cell[6]).text() + "</b>",
            "warning",
            "Hapus Data" //call function
        );
    });

    btn_action_form
    .on("click", "button#btn_simpan", function () {
        $("form#form_product select").prop('disabled', false);
        formProduct.ajaxForm(options);
    })
    .on("click", "button#btn_batal", function () {
        $("tr").removeClass("selected-row");
        modal_form.toggle()
        formChange();
    });

    btn_reload.on('click', refresh_satuan)

    hrg_beli.on('input', function(){
        if (selectKonv.val() != "") {
            let nil = nilai_konv.val().split(".")[0];
            hrg_dasar = (toNumber($(this).val()) / toNumber(nil));
        } else {
            hrg_dasar = toNumber($(this).val());
            hrg_modal.val(hrg_dasar)
        }
        selectjual.trigger('change')
    })

    selectKonv.on('change', function () {
        // var data = e.params.data;
        let opt = $(this.options[this.selectedIndex]);
        let satkonv = $(this).val();
        let nilkonv = $.trim(opt.attr("data-nilai"));

        nilai_konv.val(nilkonv);

        $(this.options).removeAttr('selected');
        opt.attr('selected', true);

        if (satkonv != "" && satkonv != null) {
            let kvsi = satkonv.split("-")[0];
            let arr_kvsi = kvsi.split(".");

            sat_beli = arr_kvsi[0]
            sat_jual = arr_kvsi[arr_kvsi.length-1]
            sat_multi = satkonv;

            console.log("sat_multi: ", sat_multi)
            console.log("sat_beli: ", sat_beli)
            console.log("sat_jual: ", sat_jual)
            console.log("nilkonv: ", nilkonv)

            let nil = nilkonv.split(".")[0];

            hrg_dasar = (toNumber(hrg_beli.val()) / toNumber(nil));
            // sat_dasar = sat_jual;

            /**ganti select satuan beli dan jual*/
            let c_sat = buatSatuan(
                kvsi,
                nilkonv,
                sat_jual,
            );
            selectbeli.html(c_sat.html());
            selectjual.html(c_sat.html());

            selectbeli.prop("disabled", true);
            selectjual.prop("disabled", true);
        } else {
            selectbeli.prop("disabled", false);
            selectjual.prop("disabled", true);

            hrg_dasar = toNumber(hrg_beli.val());
            // sat_dasar = (sat_beli != "") ? sat_beli : 'CTN';

            /**ganti select satuan beli dan jual no-konversi*/
            selectbeli.html(selectbeli_lama);
            selectjual.html(selectbeli_lama);
            // refresh_satuan();

            /** and reset */
            selectbeli.select2()
            selectjual.select2()
        }

        /**update value sat_jual dan sat_beli */
        selectbeli.val(sat_beli);
        selectjual.val(sat_jual);

        selectbeli.trigger('change');
        selectjual.trigger('change');
    });

    selectbeli.on("change", function (e) {
        // var data = e.params.data;
        let value = $(this).val();

        if (selectKonv.val() == "") {
            sat_jual = value;
            sat_beli = value;
            hrg_dasar = toNumber(hrg_beli.val());

            selectjual.prop("disabled", true);
            selectjual.val(value);
            selectjual.trigger("change");
        }
        $(this).closest('.form-group').find('span.error').remove();
        $('span.hrg_beli').text('/'+value)
        $('span.stock_aw').text(value)
    })

    selectjual.on('change',function(){
        let opt = $(this.options[this.selectedIndex]);
        let sat_jual = $(this).val();
        let nilkonv = $.trim(opt.attr("data-nilai"));

        if (selectKonv.val() != "") {
            hrg_modal.val(hrg_dasar*nilkonv)
            beratSatuan.val(berat_dasar*nilkonv)
        } else {
            hrg_modal.val(hrg_dasar)
            beratSatuan.val(berat_dasar)
        }

        // console.log('Harga Dasar: '+hrg_dasar);

        $(this).closest('.form-group').find('span.error').remove();
        $('span.hrg_jual').text('/'+sat_jual)
        $('span.hrg_modal').text('/'+sat_jual)
        $('span.berat_satuan').text('Kg/'+sat_jual)
    })

    selectKategori.on("select2:select", function (e) {
        // let data = e.params.data;
        // $("input[name=nama_kategori]").val(data.text);
        // console.log(data.text);
        $(this).closest('.form-group').find('span.error').remove();
    });

    beratSatuan.on('input', function(){
        berat_dasar = $(this).val();
    })

    input_filter.on('keydown', function(e){
        if (e.which == 27) {
            filterData("");
        } else if (e.which == 13) {
            filterData($(this).val().toLowerCase());
        }
    })

    btn_group
    .on('click', "button#filter_barang", function(){
        filterData(input_filter.val().toLowerCase());
    })
    .on('click', "button#filter_hapus", function(){
        filterData("");
    })
    .on('click', "button#refresh", loadData)

    let btn_navigate = $('#btn_navigate');
    btn_navigate
    .on('click', 'button#awal', function(){
        // first
        let cell = currCell.parent().parent().find('tr').first().find("td:eq(" + currCell.index() + ")");
        currCell = cell;
        currRow = currCell.closest('tr');
        currRow.focus();
    })
    .on('click', 'button#prev', function(){
        // prev
        let cell = currCell.closest("tr").prev().find("td:eq(" + currCell.index() + ")");
        if (cell.length > 0)
        currCell = cell;
        currRow = currCell.closest('tr');
        currRow.focus();
    })
    .on('click', 'button#next', function(){
        // next
        let cell = currCell.closest("tr").next().find("td:eq(" + currCell.index() + ")");
        if (cell.length > 0)
        currCell = cell;
        currRow = currCell.closest('tr');
        currRow.focus();
    })
    .on('click', 'button#akhir', function(){
        // last
        let cell = currCell.parent().parent().find('tr').last().find("td:eq(" + currCell.index() + ")");
        currCell = cell;
        currRow = currCell.closest('tr');
        currRow.focus();
    });

    // sort each column
    let sort_Table = $('#tabel_products th');
    $(document).ready(function () {
        $('th').each(function (col) {
            $(this).hover(
                function () {
                    $(this).addClass('focus');
                },
                function () {
                    $(this).removeClass('focus');
                }
            );
            $(this).click(function () {
                if ($(this).is('.asc')) {
                    $(this).removeClass('asc');
                    $(this).addClass('desc selected');
                    sortOrder = -1;
                } else {
                    $(this).addClass('asc selected');
                    $(this).removeClass('desc');
                    sortOrder = 1;
                }
                $(this).siblings().removeClass('asc selected');
                $(this).siblings().removeClass('desc selected');
                var arrData = $('table').find('tbody >tr:has(td)').get();
                arrData.sort(function (a, b) {
                    var val1 = $(a).children('td').eq(col).text().toUpperCase();
                    var val2 = $(b).children('td').eq(col).text().toUpperCase();
                    if ($.isNumeric(val1) && $.isNumeric(val2))
                        return sortOrder == 1 ? val1 - val2 : val2 - val1;
                    else
                        return (val1 < val2) ? -sortOrder : (val1 > val2) ? sortOrder : 0;
                });
                $.each(arrData, function (index, row) {
                    $('tbody').append(row);
                });
            });
        });
    });

    /**
     * Function
     */

    // sumber: https://www.posciety.com/cara-membuat-sistem-filter-jquery/
    // filter data
    // $("input[name=table_search]").on("keyup", function () {
    //     var value = $(this).val().toLowerCase();
    //     $("div#data li").filter(function () {
    //         $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
    //     });
    // });
    // clear filter data
    // $("button.clear").on("click", function () {
        // $("input[name=table_search]").val("");
        // $("div#data li").filter(function () {
        //     $(this).toggle($(this).text().toLowerCase().indexOf("") > -1);
        // });
        // $("input[name=table_search]").focus();
        // $("#tabel_products").DataTable().ajax.reload();
    // });

    function filterData(value) {
        input_filter.val(value);

        tabeldata.html(""); //hasil filter

        data_backup.children().filter(function(){
            let hasil = $(this).text().toLowerCase().indexOf(value);
            if (hasil > -1) {
                $(this).clone().appendTo(tabeldata)
            }
        })

        let tot_data = $(tabeldata).children().length;
        if (tot_data == 0) {
            tabeldata.html(
                `<tr><td colspan="10" class="text-center">Product <span class="text-red text-bold"> " `+value+` " </span> Tidak Tersedia</td></tr>`
            );
            input_filter.focus();
        } else {
            currCell = tabel_products.find("tbody td:eq(1)").first();
            currCell.focus()
        }
        $("#tot_rec").text(rupiah.format(tot_data));
    }

    function navigation(e) {
        e.preventDefault();

        let c = "";
        if (e.which == 39) {
            // Right Arrow
            if (currCell.index() < 8) {
                c = currCell.next();
            }
        } else if (e.which == 37) {
            // Left Arrow
            if (currCell.index() > 1) {
                c = currCell.prev();
            }
        } else if (e.which == 38) {
            // Up Arrow
            c = currCell
                .closest("tr")
                .prev()
                .find("td:eq(" + currCell.index() + ")");
        } else if (e.which == 40) {
            // Down Arrow
            c = currCell
                .closest("tr")
                .next()
                .find("td:eq(" + currCell.index() + ")");
        } else if (e.which == 9 && !e.shiftKey) {
            // Tab
            e.preventDefault();
            c = currCell.next();
        } else if (e.which == 9 && e.shiftKey) {
            // Shift + Tab
            e.preventDefault();
            c = currCell.prev();
        } else if (e.which == 36) {
            // home
            c = currCell
                .parent().parent()
                .find('tr')
                .first()
                .find("td:eq(" + currCell.index() + ")");
        } else if (e.which == 35) {
            // End
            c = currCell
                .parent().parent()
                .find('tr')
                .last()
                .find("td:eq(" + currCell.index() + ")");
        } else if (e.which == 33) {
            // pageUp
            let index_row = ((currRow.index()-10) > 0 ) ? currRow.index()-10 : 1;
            let cr = $(this).find("tr:eq(" + index_row + ")");
            c = cr.find("td:eq(" + currCell.index() + ")");
        } else if (e.which == 34) {
            // pageDown
            let cr = $(this).find("tr:eq(" + (currRow.index()+10) + ")");
            c = cr.find("td:eq(" + currCell.index() + ")");
        } else if (e.which == 13) {
            row = currCell.closest("tr");
            id = $(row).attr("id");
            cols = row.find("td");
            $("tr").removeClass("selected-row");
            row.addClass("selected-row");
            aksi = "edit";
            $(".info-aksi").text('Edit Data');
            oldCode = $(cols[1]).text();
            formAction(aksi, id);
            edit_data(id)
        }

        if (c.length > 0) {
            currCell = c;
            currRow = currCell.closest("tr");
            // data_cell = currRow.find("td");
            currCell.focus();
            // currRow.focus();
        }
    };

    /**
     * Buat element dinamis satuan dan opsinya;
     * usage: let contoh = buatSatuan(...);
     * example: contoh.html() -> masukkan ke element select yg dituju;
     * @param {*} p1 harga dasar
     * @param {*} p2 satuan dasar
     * @param {*} p3 satuan konversi
     * @param {*} p4 nilai konversi
     * @param {*} p5 kode konversi
     * @param {*} p6 satuan selected
     */
    function buatSatuan(p3, p4, p6) {
        const kvsi = p3;
        const nl_kvsi = p4;
        const selected = p6;

        let c_select = $("<select/>");

        if (kvsi != null && nl_kvsi != null) {
            let satkonv = kvsi.split("."); //.reverse()
            let nilaikonv = nl_kvsi.split(".");

            if (satkonv.length > 1) {
                /**ganti select satuan*/
                for (let x = 0; x < satkonv.length; x++) {
                    const s = satkonv[x];
                    const n = nilaikonv[x];

                    if (s == selected) {
                        c_select.append(`<option data-nilai="`+n+`" value="`+s+`"selected>`+s+`</option>`)
                    } else {
                        c_select.append(`<option data-nilai="`+n+`" value="`+s+`">`+s+`</option>`)
                    }
                }
            }
        }
        return c_select;
    }

    function reload_data(){
        $.ajax({
            url: "products/load-data",
            type: "GET",
            dataType: "json",
            success: function (res) {
                // console.log(res.data)
                let data = res.data;
                let no = 1;
                if (data.length == 0) {
                    data_backup.html(
                        `<tr><td colspan="10" class="text-center">Data Tidak Tersedia</td></tr>`
                    );
                } else {
                    data_backup.html("");
                    for (let i = 0; i < data.length; i++) {
                        let sat_konv = "-"
                        let nil_konv = "-";

                        if (data[i].sat_konversi != null) {
                            let kv = data[i].sat_konversi.split('-');
                            sat_konv = kv[0]; //satuan konversi
                            nil_konv = "("+kv[1]+")"; //nilai Konversi
                        }

                        let code = data[i].code == null ? "-" : data[i].code;

                        let rowdata =
                            `<tr tabindex="`+no+`" id="`+data[i].id+`">
                                <td class="text-center">` + no + `</td>
                                <td tabindex="1" class="text-center">` + code + `</td>
                                <td tabindex="2">` + data[i].name + `</td>
                                <td tabindex="3" class="text-center">` + data[i].kategori + `</td>
                                <td tabindex="4" class="text-center">` + sat_konv + nil_konv + `</td>
                                <td tabindex="5">
                                    <div class="row m-0">
                                        <div class="col-8 text-right">`+ rupiah.format(data[i].harga_beli) +`</div>
                                        <div class="col-4 text-nowrap">`+ data[i].sat_beli +`</div>
                                    </div>
                                </td>
                                <td tabindex="6">
                                    <div class="row m-0">
                                        <div class="col-8 text-right">`+ rupiah.format(data[i].harga_jual) +`</div>
                                        <div class="col-4 text-nowrap">`+ data[i].sat_jual +`</div>
                                    </div>
                                </td>
                                <td tabindex="7">
                                    <div class="row m-0">
                                        <div class="col-7 text-right">`+ rupiah.format(data[i].stock_aw) +`</div>
                                        <div class="col-5 text-nowrap">`+ data[i].sat_beli +`</div>
                                    </div>
                                </td>
                                <td tabindex="8">
                                    <div class="row m-0">
                                        <div class="col-7 text-right">`+ rupiah.format(data[i].stock_ak) +`</div>
                                        <div class="col-5 text-nowrap">`+ data[i].sat_beli +`</div>
                                    </div>
                                </td>
                            </tr>`;

                        no++;
                        data_backup.append(rowdata);
                    }
                }
                $("#tot_rec").text(rupiah.format(data.length));
            },
        });
        return false;
    }

    function loadData() {
        $.ajax({
            url: "products/load-data",
            type: "GET",
            dataType: "json",
            success: function (res) {
                // console.log(res.data)
                let data = res.data;
                let no = 1;
                if (data.length == 0) {
                    no = 0;
                    tabeldata.html(
                        `<tr><td colspan="10" class="text-center">Data Tidak Tersedia</td></tr>`
                    );
                } else {
                    tabeldata.html("");
                    for (let i = 0; i < data.length; i++) {

                        let sat_konv = "-"
                        let nil_konv = "-";

                        if (data[i].sat_konversi != null) {
                            let kv = data[i].sat_konversi.split('-');
                            sat_konv = kv[0]; //satuan konversi
                            nil_konv = "("+kv[1]+")"; //nilai Konversi
                        }

                        let code = data[i].code == null ? "-" : data[i].code;

                        let rowdata =
                            `<tr tabindex="`+no+`" id="`+data[i].id+`">
                                <td class="text-center">` + no + `</td>
                                <td tabindex="1" class="text-center">` + code + `</td>
                                <td tabindex="2">` + data[i].name + `</td>
                                <td tabindex="3" class="text-center">` + data[i].kategori + `</td>
                                <td tabindex="4" class="text-center">` + sat_konv + nil_konv + `</td>
                                <td tabindex="5">
                                    <div class="row m-0">
                                        <div class="col-7 text-right">`+ rupiah.format(data[i].harga_beli) +`</div>
                                        <div class="col-5 text-nowrap">/`+ data[i].sat_beli +`</div>
                                    </div>
                                </td>
                                <td tabindex="6">
                                    <div class="row m-0">
                                        <div class="col-7 text-right">`+ rupiah.format(data[i].harga_jual) +`</div>
                                        <div class="col-5 text-nowrap">/`+ data[i].sat_jual +`</div>
                                    </div>
                                </td>
                                <td tabindex="7">
                                    <div class="row m-0">
                                        <div class="col-7 text-right">`+ rupiah.format(data[i].stock_aw) +`</div>
                                        <div class="col-5 text-nowrap">`+ data[i].sat_beli +`</div>
                                    </div>
                                </td>
                                <td tabindex="8">
                                    <div class="row m-0">
                                        <div class="col-7 text-right">`+ rupiah.format(data[i].stock_ak) +`</div>
                                        <div class="col-5 text-nowrap">`+ data[i].sat_beli +`</div>
                                    </div>
                                </td>
                            </tr>`;

                        no++;
                        tabeldata.append(rowdata);
                    }
                }

                $("#tot_rec").text(rupiah.format(data.length));

                data_backup = tabeldata.clone();

                currCell = tabeldata.find("td:eq(1)").first();
                currRow = tabeldata.find("tr").first();
                currCell.focus();
            },
        });
    }

    // refresh data satuans
    function refresh_satuan() {
        $.ajax({
            url: "satuans/load-data",
            type: "get",
            dataType: "json",
            success: function(resp){
                // console.log(resp)

                let data = resp.data;
                if (data.length > 0){
                    selectKonv.html("")
                    selectbeli.html('')
                    selectjual.html('')
                    selectKonv.html(`<option data-nilai="" value="" selected>Tidak Ada</option>`)

                    for (let i = 0; i < data.length; i++) {
                        const sat = data[i];
                        if (sat.konversi == 1) {
                            // let satkv = sat.tipe.split('-');

                            selectKonv.append(`
                                <option data-nilai="`+sat.nilai+`"
                                    value="`+sat.tipe+`">`+sat.tipe+`
                                </option>
                            `)

                        } else {
                            selectbeli.append(`<option value="`+sat.tipe+`">`+sat.tipe+`</option>`)
                            selectjual.append(`<option value="`+sat.tipe+`">`+sat.tipe+`</option>`)
                        }
                    }

                    selectKonv.val(sat_multi);
                    selectbeli.val(sat_beli);
                    selectjual.val(sat_jual);

                    selectKonv.trigger('change') // utk. semua select
                }
            }
        });

        $.ajax({
            url: "category/load-kategori",
            type: "get",
            dataType: "json",
            success: function(resp){
                let data = resp.kategori;
                console.log(data)
                if (data.length > 0){
                    selectKategori.html('');
                    for (let k = 0; k < data.length; k++) {
                        const kat = data[k];
                        selectKategori.append(`
                            <option value="`+kat.id+`">`+kat.name+`</option>
                        `)
                    }
                }
            }
        })
    }

    function delete_data() {
        $.ajax({
            url: urlx,
            type: method,
            // data: { id: id },
            dataType: "json",
            success: function (resp) {
                console.log(resp);
                let info = resp.info
                if (info.status == 'success') {
                    mynotife(info.status,"Hapus Product",info.pesan);
                    currRow.remove();
                    reload_data();
                }
            },
            error: function (err) {
                console.log(err);
                mynotife(
                    "error",
                    "Data Product",
                    "Data Gagal di Hapus<br> Data "+err.statusText
                );
            },
        });
        return false;
    }

    function edit_data(id) {
        $.ajax({
            url: "products/" + id + "/edit",
            type: "get",
            dataType: "json",
            success: function (resp) {
                // console.log(resp)
                // return false;

                let data = resp.data;

                // if (data.sat_konversi != null){
                //     let satkonv = data.sat_konversi.split('-');
                //     sat_multi = satkonv[0];
                // } else {
                //     sat_multi = "";
                // }

                sat_multi = (data.sat_konversi != null)
                    ? data.sat_konversi
                    : ""

                sat_jual = data.sat_jual;
                sat_beli = data.sat_beli;
                berat_dasar = data.berat;

                if (data.gambar != null) {
                    $("#previewImg").attr("src", resp.lokasi+'/'+data.gambar);
                    // $("#previewImg").attr("src", '/images/products/'+data.gambar);
                } else {
                    $("#previewImg").attr("src", '/assets/custom/gambar/gambar_product.png');
                }

                $("input[name=code]").val(data.code);
                $("input[name=nama_barang]").val(data.name);

                $("textarea[name=keterangan]").val(data.description);
                $("input[name=hrg_beli]").val(data.harga_beli);
                $("input[name=hrg_jual]").val(data.harga_jual);
                $("input[name=stock_aw]").val(data.stock_aw);
                $("input[name=stock_ak]").val(data.stock_ak);

                formProduct.find('span.error').remove();

                selectKategori.val(data.kategory_id);
                selectKonv.val(sat_multi);

                selectKonv.trigger("change");
                selectKategori.trigger("change");

                btn_action_form.html(`
                    <button type="submit" class="btn btn-outline-primary btn-xs mr-1" id="btn_simpan"><i class="fas fa-save"></i> Simpan</button></a>
                    <button type="button" class="btn btn-outline-danger btn-xs" id="btn_batal"><i class="fas fa-times"></i> Batal</button></a>
                `);

                modal_form.toggle();
                formChange(true);
            },
            error: function (err) {
                console.log(err);
            },
        });
    }

    function formAction(aksi, id) {
        switch (aksi) {
            case "tambah":
                urlx = "products";
                method = "POST";
                $("#method").replaceWith(`<div id="method"></div>`);
                break;
            case "edit":
                urlx = "products/" + id;
                method = "POST";
                $("#method").replaceWith(
                    `<input type="hidden" name="_method" value="PUT" id="method">`
                );
                break;
            case "hapus":
                urlx = "products/" + id;
                method = "DELETE";
                break;
        }
        formProduct.attr("action", urlx);
        formProduct.attr("method", method);
    }

    function formChange(xform) {
        if (xform) {
            $("form#form_product input").removeAttr("disabled");
            $("form#form_product select").removeAttr("disabled");
            $("form#form_product textarea").removeAttr("disabled");
            btn_action_form.show()
            selectKonv.trigger('change');
        } else {
            form_validate.resetForm();
            btn_action_form.empty()
            $("form#form_product input").attr("disabled", "disabled");
            $("form#form_product select").attr("disabled", "disabled");
            $("form#form_product textarea").attr("disabled", "disabled");
            $("#method").replaceWith(`<div id="method"></div>`);

            // clear form from error validator
            formProduct.find(".is-invalid").removeClass("is-invalid");
            formProduct.find("span.error").remove();
            aksi = "";
            formProduct.removeAttr('method')
            formProduct.removeAttr('action')
        }
        hrg_modal.prop('readonly', true);
        nilai_konv.prop('readonly', true);
        $('#code').focus();
    }

    function mynotife(tipe, judul, pesan) {
        toastr[tipe](pesan, judul);
        toastr.options = {
            closeButton: true,
            onclick: null,
            debug: false,
            newestOnTop: true,
            progressBar: true,
            positionClass: "toast-top-right",
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

    function previewFile(filex){
        getFile = filex.get(0).files[0];
        if (getFile){
            let reader = new FileReader();
            reader.onload = function(){
                $("#previewImg").attr("src", reader.result);
            }
            reader.readAsDataURL(getFile);
        }
    }

    // Convertion string to Number/Double(float)
    function toNumber(string) {
        return parseInt(string.split(",").join(""));
    }

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
                    case "Hapus Data":
                        delete_data();
                        break;
                    default:
                        mynotife(
                            "error",
                            "Ada Kesalahan System",
                            "Confirm [" + switchConfirm + "] - Tidak Tersedia"
                        );
                }
            } else {
                currRow.focus();
            }
        });
    }

    /**Validation form */
    $.validator.addMethod("lebihBesar", function (value, element, param) {
        // console.log(toNumber(value)); //value pembanding
        // console.log(element); //element yg diuji
        // console.log(param); //param yg diuji
        // return this.optional(element) || toNumber(value) > toNumber(param);
        return toNumber(value) > toNumber(param);
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

    let form_validate = formProduct.validate({
        ignore: ".ignore",
        rules: {
            code: {
                required: true,
                maxlength: 13,
                minlength: 5,
                number: true,
                remote: {
                    url: "products/cekCode",
                    type: "post",
                    dataType: "json",
                    data: {
                        opr: function() {return aksi},
                        oldCode: function() {return oldCode},
                    }
                    // success: function(resp){
                    //     console.log(resp);
                    //     return resp;
                    // }
                },

            },
            nama_barang: { required: true },
            satuan_beli: { required: true },
            satuan_jual: { required: true },
            kategori: { required: true },
            hrg_beli: { required: true },
            hrg_jual: {
                required: true,
                number: true,
                lebihBesar: function(){
                    return hrg_modal.val()
                }
            },
            // gambar: { required: true },
        },
        messages: {
            code: {
                required: "code/barcode wajib diisi",
                minlength: "Min. {0} Karakter",
                maxlength: "Max. {0} Karakter",
                remote: "Code/Barcode ini sudah ada"
            },
            nama_barang: { required: "Nama Barang wajib diisi" },
            satuan_beli: { required: "Wajib di-pilih" },
            satuan_jual: { required: "Wajib di-pilih" },
            kategori: { required: "Wajib di-pilih" },
            hrg_beli: { required: "Wajib di-Isi" },
            hrg_jual: {
                required: "Harga wajib di-isi",
                lebihBesar: "Harga lebih kecil/sama dari Harga Modal",
            },
            // gambar: { required: "Gambar wajib di pilih" },
        }
    });

    /**
     * Run Start
     */
    formChange();
    loadData();
});
