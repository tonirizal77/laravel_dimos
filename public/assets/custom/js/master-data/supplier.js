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



    var aksi, urlx, method, id, row, table;
    var cols = [];
    let hapus_baris;

    let formSupplier = $("form#form_supplier");

    let btnActionForm = $("span#btn_action");
    let btnTambah = $("button#btn_add");

    let tabelData = $("table#tabel_supplier tbody");
    let tabel_supplier = $("#tabel_supplier");
    let currRow = tabel_supplier.find("tbody tr").first();
    let currCell = tabel_supplier.find("tbody td").first();
    let supplier_id = "";
    let data_backup;

    let input_filter = $('#filter_data')
    let btn_group = $('#btn_group')

    let provinsi = $('#provinsi');
    let kota = $('#kota');
    let kota_id;

    $("input[name=telpon]").inputmask("9999999999999", {
        removeMaskOnSubmit: true,
        placeholder: "",
        clearMaskOnLostFocus: true,
    });

    $('.select2').select2()
    const number = new Intl.NumberFormat("en-US", {
        minimumFractionDigits: 0,
    });

    var options = {
        // other available options:
        // url: "products", // override for form's 'action' attribute
        // type: "POST", // 'get' or 'post', override for form's 'method' attribute
        dataType: "json", // 'xml', 'script', or 'json' (expected server response type)
        clearForm: false, // clear all form fields after successful submit
        resetForm: true, // reset the form after successful submit
        // complete: function (response) {
        //     if ($.isEmptyObject(response.responseJSON.error)) {
        //         console.log(response.responseJSON);
        //     } else {
        //         printErrorMsg(response.responseJSON.error);
        //     }
        // },

        // target: "#output1", // target element(s) to be updated with server response
        // beforeSubmit: validate,
        // beforeSubmit: showRequest, // pre-submit callback

        success: function (resp) {
            let info = resp.info;
            let data = resp.data;

            console.log(resp);

            mynotife(info.status, "Simpan Data", info.pesan);

            if (info.status == 'success') {
                btnTambah.show();
                btnActionForm.empty();
                formChange("disabled");

                let ket = data.status == 0 ? "Non-Active" : "Active";

                //update data only for screen
                if (cols.length > 1) {
                    cols[1].innerText = data.nama;
                    cols[2].innerText = data.alamat;
                    cols[3].innerText = data.kota.name+ ', ' +data.provinsi.name,
                    cols[4].innerText = data.telpon;
                    cols[5].innerHTML = `<center>`+ket+`</center>`;

                    $("tbody tr").removeClass("selected-row");
                    cols = [];
                } else {
                    // Data Baru

                    loadData(); //sementara

                    // let totData = table.rows().count() + 1;

                    // let rowdata = [
                    //     `<center>`+totData+`</center>`,
                    //     data.nama,
                    //     data.alamat,
                    //     data.kota.name+ '/' +data.provinsi.name,
                    //     data.telpon,
                    //     `<center>`+ket+`</center>`,
                    //     `<center>
                    //         <button class="btn btn-xs btn-warning" name="btn-edit" data-id="` +data.id +`">Edit</button>` +" " +
                    //        `<button class="btn btn-xs btn-danger" name="btn-delete" data-id="` +data.id +`">Hapus</button>`+
                    //     `</center>`,
                    // ];
                    // table.row.add(rowdata).draw();
                }
            }
            return false;
        }, // post-submit callback
    };

    /**
     * Keyboard Navigation Table
     */
     tabel_supplier
     .on("keydown", navigation)
     .on('click', 'td', function(){
         currCell = $(this);
         currRow = currCell.closest('tr');
         supplier_id = currRow.attr('data-id');
         currCell.focus();
     })
     .on("dblclick", "td", function () {
         currCell = $(this);
         currRow = currCell.closest('tr');
         supplier_id = currRow.attr('data-id');
         $("tr").removeClass("selected-row");
         currRow.addClass("selected-row");
         currCell.focus();
         getSupplier(supplier_id);
     });

     /**
      * Button Navigation Table
      */
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
     })

    /**
     * Button Triger
     */
    tabelData
    .on("click", "button[name='btn-edit']", function () {
        id = $(this).attr("data-id");
        row = $(this).closest("tr");
        cols = row.find("td");          // Finds all children <td> elements (array)

        $("tr").removeClass("selected-row");
        row.addClass("selected-row");

        aksi = "edit";
        formAction(aksi, id);
        $.ajax({
            url: "suppliers/" + id + "/edit",
            type: "get",
            dataType: "json",
            success: function (resp) {
                let data = resp.data;

                console.log(data);

                $("input[name=nama]").val(data.nama);
                $("textarea[name=alamat]").val(data.alamat);
                $("input[name=telpon]").val(data.telpon);
                kota_id = data.kota_id
                provinsi.val(data.prov_id);
                provinsi.trigger('change')

                switch (data.status) {
                    case 1:
                        $("#status_active").iCheck("check");
                        break;
                    default:
                        $("#status_non").iCheck("check");
                }

                formChange("enabled");
            },
            error: function (err) {
                console.log(err);
            },
        });
    })
    .on("click", "button[name='btn-delete']", function () {
        id = $(this).attr("data-id");
        hapus_baris = $(this).parents("tr"); // hapus baris and redraw
        aksi = "hapus";
        formAction(aksi, id);
        deleteFunc(id);
    });

    btnTambah.on("click", function () {
        aksi = "tambah";
        formAction(aksi, "");
        formChange("enabled");
    });

    btnActionForm
    .on("click", "button#btn_save", function () {
        formSupplier.ajaxForm(options);
    })
    .on("click", "button#btn_cancel", function () {
        $("tbody tr").removeClass("selected-row");
        formChange("disabled");
    });

    provinsi.on("change", function(){
        // get data kota
        let idc = $(this).val();

        $.ajax({
            url: "/load-kota",
            method: "post",
            data: {id: idc},
            success: function(resp){
                let data = resp.kota;
                kota.html("");

                if (data.length != 0) {
                    data.forEach(e => {
                        kota.append(
                            `<option value="`+e.id+`">`+e.name+`</option>`
                        );
                    });
                    kota.val(kota_id)
                    kota.trigger("change");
                }
            }
        })
    }).change();

    input_filter.on('keydown', function(e){
        if (e.which == 27) {
            filterData("");
        } else if (e.which == 13) {
            filterData($(this).val().toLowerCase());
        }
    })

    btn_group
    .on('click', "button#filter_action", function(){
        filterData(input_filter.val().toLowerCase());
    })
    .on('click', "button#filter_hapus", function(){
        filterData("");
    })
    .on('click', "button#refresh", loadData)

    function filterData(value) {
        input_filter.val(value);

        tabelData.html(""); //hasil filter

        data_backup.children().filter(function(){
            let hasil = $(this).text().toLowerCase().indexOf(value);
            if (hasil > -1) {
                $(this).clone().appendTo(tabelData)
            }
        })

        let tot_data = $(tabelData).children().length;
        if (tot_data == 0) {
            tabelData.html(
                `<tr><td colspan="9" class="text-center">Data <span class="text-red text-bold"> " `+value+` " </span> Tidak Tersedia</td></tr>`
            );
            input_filter.focus();
        } else {
            currCell = tabelData.find("tbody td:eq(1)").first();
            currCell.focus()
        }
        $("#tot_rec").text(number.format(tot_data));
    }

    function navigation(e) {
        e.preventDefault();

        let c = "";
        if (e.which == 39) {
            // Right Arrow
            if (currCell.index() < 5) {
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
            //Enter Key
            currRow = currCell.closest("tr");
            supplier_id = $(currRow).attr("data-id");
            $("tr").removeClass("selected-row");
            currRow.addClass("selected-row");
            getSupplier(supplier_id);
        }

        if (c.length > 0) {
            currCell = c;
            currRow = currCell.closest("tr");
            currCell.focus();
            supplier_id = currRow.attr("data-id");
            // currRow.focus();
            // data_cell = currRow.find("td");
        }
    };

    function getSupplier(id){
        $.ajax({
            url: "suppliers/"+id+"/edit",
            method: "get",
            success: function(resp){
                let data = resp.data;
                $("input[name=nama]").val(data.nama);
                $("textarea[name=alamat]").val(data.alamat);
                $("input[name=telpon]").val(data.telpon);
                kota_id = data.kota_id
                provinsi.val(data.prov_id);
                provinsi.trigger('change')

                switch (data.status) {
                    case 1:
                        $("#status_active").iCheck("check");
                        break;
                    default:
                        $("#status_non").iCheck("check");
                }

                formChange("enabled");

            },
            error: function(err){
                console.log(err);
            }
        })
    }

    function deleteFunc(id) {
        if (confirm("Hapus Data Supplier?") == true) {
            $.ajax({
                url: urlx,
                type: method,
                data: { id: id },
                dataType: "json",
                success: function (ress) {
                    hapus_baris.remove();
                    mynotife(
                        "success",
                        "Data Supplier",
                        ress.pesan
                    );
                },
                error: function (err) {
                    console.log(err);
                },
            });
        }
    }

    function loadData() {
        $.ajax({
            url: "suppliers/load-data",
            type: "GET",
            dataType: "json",
            success: function (res) {
                console.log(res)
                // return false;
                let data = res.data.supplier;
                tabelData.html("");
                let no = 1;
                if (data.length == 0) {
                    tabelData.html(
                        `<tr><td colspan="7" class="text-center">Data Tidak Tersedia</td></tr>`
                    );
                } else {
                    for (let i = 0; i < data.length; i++) {
                        let ket = (data[i].status == 0) ? "Non-Active" : "Active";
                        let rowdata =
                            `<tr tabindex="`+no+`" data-id="`+data[i].id+`">
                                <td class="text-center">`+no+`</td>
                                <td tabindex="1">`+data[i].nama+`</td>
                                <td tabindex="2">`+data[i].alamat+`</td>
                                <td tabindex="3"> Kota `+data[i].kota.name+', Provinsi '+data[i].provinsi.name+`</td>
                                <td tabindex="4">`+data[i].telpon+`</td>
                                <td tabindex="5" class="text-center">`+ket+`</td>
                                <td class="text-center">
                                    <button class="btn btn-xs btn-warning" name="btn-edit" data-id="`+data[i].id+`" >Edit</button>
                                    <button class="btn btn-xs btn-danger" name="btn-delete" data-id="`+data[i].id+`">Hapus</button>
                                </td>
                            </tr>`;
                        no++;
                        tabelData.append(rowdata);
                    }
                }

                $("#tot_rec").text(data.length);
                data_backup = tabelData.clone();
                currCell = tabelData.find("td:eq(1)").first();
                currRow = tabelData.find("tr").first();
                currCell.focus();
            },
        });
    }

    function formAction(aksi, id) {
        switch (aksi) {
            case "tambah":
                urlx = "suppliers";
                method = "POST";
                break;
            case "edit":
                urlx = "suppliers/" + id;
                method = "POST";
                $("#method").replaceWith(
                    `<input type="hidden" name="_method" value="PUT">`
                );
                break;
            case "hapus":
                urlx = "suppliers/" + id;
                method = "DELETE";
                break;
        }
        formSupplier.attr("action", urlx);
        formSupplier.attr("method", method);
    }

    function showButtonAction() {
        btnActionForm.html(
            `<button class="btn btn-sm btn-info" type="submit" id="btn_save">Simpan</button>` +
                " " +
            `<button class="btn btn-sm btn-warning" type="button" id="btn_cancel">Batal</button>`
        );

        $("input[name=nama]").focus();
    }

    function formChange(xform) {
        if (xform == "enabled") {
            $("form input.form-control").removeAttr("disabled");
            $("form select").removeAttr("disabled");
            $("form textarea").removeAttr("disabled");

            btnTambah.hide();
            showButtonAction();
        } else {
            $("form input.form-control").attr("disabled", "disabled");
            $("form select").attr("disabled", "disabled");
            $("form textarea").attr("disabled", "disabled");

            $("form input").removeClass("is-invalid");

            formSupplier.trigger("reset");
            btnTambah.show();
            btnActionForm.empty();

            $("input[name=_method]").replaceWith(`<div id="method"></div>`);
        }
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

    /**
     * Validation form
     *
     * */

     formSupplier.validate({
        rules: {
            nama: { required: true },
            alamat: { required: true },
            kota: { required: true },
            // telpon: { required: true },
            status: { required: true },
        },
        messages: {
            nama: { required: "Nama wajib diisi" },
            alamat: { required: "Wajib di-pilih" },
            kota: { required: "Wajib di-pilih" },
            // telpon: { required: "Telpon Wajib diisi" },
            status: { required: "Wajib di-pilih" },
        },
        errorElement: "span",
        errorPlacement: function (error, element) {
            error.addClass("invalid-feedback");
            element.closest(".form-group").append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass("is-invalid");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass("is-invalid");
        },
    });

    formChange();
    loadData();


});
