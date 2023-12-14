/**
 * Category Product
 */

 $(function(){
    ("use strict");

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    const rupiah = new Intl.NumberFormat("en-US", {
        // style: "currency",
        // currency: "IDR",
        minimumFractionDigits: 0,
    });

    Inputmask.extendAliases({
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

    $(".rupiah").inputmask({ alias: "angka" });

    let action, urlx, method, id;

    let formSatuan = $("form#form_satuan");
    let tabeldata = $("table#table_satuan tbody");
    let tabelCard = $("#card-satuan");

    let pilihJenisSatuan = $("input[name=jenis_satuan]");
    let checkSatuan = $('input[name="check_satuan[]"]');
    let kodeSatuan = $("input#kode_satuan");

    let nilaiSatuan = $("input#nilai_satuan");

    let selectSatuanB, selectSatuanS, selectSatuanK;
    selectSatuanB = $("select[name=pilih_satuan_b]");
    selectSatuanS = $("select[name=pilih_satuan_s]");
    selectSatuanK = $("select[name=pilih_satuan_k]");

    let inp_nilaiSatuan = $('input[name="inp_nilai[]"]');

    let btnActionForm = $("span#btn_action");
    let btnTambah = $("button#btn_add");
    let btn_view_tabel = $("button#view-tabel")
    let btn_view_card = $("button#view-card")

    let JenisSatuan = 0;
    let target; //selected-card
    let kodelama="";

    let tabelSatuan = $('table#table_satuan');
    let cardSatuan = $('div#card-satuan');

    btn_view_card.on('click', function(){
        cardSatuan.show();
        tabelSatuan.hide();
    })

    btn_view_tabel.on('click', function(){
        cardSatuan.hide();
        tabelSatuan.show();
        tabelSatuan.find('button').removeClass('btn-block');
    })

    $("button#refresh").on("click", loadData);

    /**
     * Button Triger
     */
    checkSatuan.on("click", function () {
        if (JenisSatuan == 0) {
            checkSatuan.prop("checked", false);
            $(this).prop("checked", true);
            single_checkSatuan();
        } else {
            multi_checkSatuan();
        }
    });

    selectSatuanB.on("change", function () {
        if (JenisSatuan == 0) {
            single_checkSatuan();
        } else {
            multi_checkSatuan();
        }
    });
    selectSatuanS.on("change", function () {
        if (JenisSatuan == 0) {
            single_checkSatuan();
        } else {
            multi_checkSatuan();
        }
    });
    selectSatuanK.on("change", function () {
        //toni
        $("span#satuan_kecil").text($(this).val());
        if (JenisSatuan == 0) {
            single_checkSatuan();
        } else {
            multi_checkSatuan();
        }
    });

    btnTambah.on("click", function () {
        action = "tambah";
        kodelama = "";
        formAction(action, "");
        $(this).hide();
        formEnabled();
    });

    btnActionForm.on("click", "button#btn_cancel", function () {
        formDisabled();
        $(this).parent().empty(); // kosongkan button action
        $(".form-control").removeClass("is-invalid");
        $("span.error").hide();
    });

    btnActionForm.on("click", "button#btn_save", function () {
        formSatuan.submit();
    });

    tabeldata
    .on("click", "button.btn-edit", edit_data)
    .on("click", "button.btn-delete", function () {
        let id = $(this).attr("data-id");
        row = $(this).closest("tr"); // Finds the closest row <tr>
        // let tds = row.find("td"); // Finds all children <td> elements
        action = "hapus";
        formAction(action, id);
        deleteFunc(id);
    });

    let remove_card;
    tabelCard
    .on("click", "button.btn-edit", edit_data)
    .on("click", "button.btn-delete", function () {
        let id = $(this).attr("data-id");
        remove_card = $(this).closest("div.box-card"); // Finds the closest row <tr>
        action = "hapus";
        formAction(action, id);
        deleteFunc(id);
    })
    .on("click", "span.no-card", function(){
        target = $(this).closest('div.card.bg-box');
        target.toggleClass('selected-card');
    });

    inp_nilaiSatuan.on("blur", function () {
        if (JenisSatuan == 0) {
            single_checkSatuan();
        } else {
            multi_checkSatuan();
        }
    });

    pilihJenisSatuan.on("click", function () {
        JenisSatuan = $(this).val();

        if (JenisSatuan == 0) {
            checkSatuan.prop("checked", false);

            inp_nilaiSatuan.attr("disabled", "disabled");
            $("span#btn_action button#btn_save").attr("disabled", "disabled");
            $("#satuan_k_check").attr("disabled", false);

            single_checkSatuan();
        } else {

            $("#satuan_k_check").attr("disabled", true);
            $("#satuan_k_check").prop("checked", true);

            multi_checkSatuan();
        }
    });

    /**
     * Function
     */

    function edit_data(){
        id = $(this).attr("data-id");
        JenisSatuan = $(this).attr("data-kv"); // 0 - 1
        let idkode = $(this).attr("data-kode"); // B.S.K
        let kode =  $(this).attr("data-tipe");  // CTN.LSN.PCS
        let nilai =  $(this).attr("data-nilai"); // 50.12.1

        formEnabled();
        action = "edit";
        kodelama = kode;
        formAction(action, id);

        $('div.card.bg-box').removeClass('selected-card');

        target = $(this).closest('div.card.bg-box');
        target.addClass('selected-card');

        switch (JenisSatuan) {
            case "1":
                $("#jenis_konversi").iCheck("check");
                $("#jenis_konversi").trigger("click");
                $("#satuan_k_check").prop("checked", true);
                $("#satuan_k_check").prop("disabled", true);
                break;
            case "0":
                $("#jenis_tunggal").iCheck("check");
                $("#jenis_tunggal").trigger("click");
        }

        let arr_idkode = idkode.split(".");
        let arr_tipe = kode.split("-")[0];
        let arr_kode = arr_tipe.split(".");
        let arr_nilai = nilai.split(".");

        checkSatuan.prop("checked", false);

        for (let i = 0; i < arr_idkode.length; i++) {
            const e = arr_idkode[i];
            // console.log(e);
            // console.log(arr_kode[i]);
            switch (e) {
                case "B":
                    selectSatuanB.val(arr_kode[i]);
                    selectSatuanB.trigger('change');
                    selectSatuanB.removeAttr("disabled");
                    $("#satuan_b_check").prop("checked", true);
                    $("#nil_satuan_b").val(arr_nilai[i]);
                    break;
                case "S":
                    selectSatuanS.val(arr_kode[i]);
                    selectSatuanS.trigger("change");
                    selectSatuanS.removeAttr("disabled");
                    $("#satuan_s_check").prop("checked", true);
                    $("#nil_satuan_s").val(arr_nilai[i]);
                    break;
                case "K":
                    selectSatuanK.val(arr_kode[i]);
                    selectSatuanK.trigger('change');
                    selectSatuanK.removeAttr("disabled");
                    $("#nil_satuan_k").attr("readonly", true);
                    $("#satuan_k_check").prop("checked", true);
                    // $("#nil_satuan_k").val(arr_nilai[i]);
                    $("#nil_satuan_k").val(1);
                    break;
            }
        }

        $("span#btn_action button#btn_save").removeAttr("disabled");

        kodeSatuan.val(kode);
        nilaiSatuan.val(nilai);

    }

    function loadData() {
        $.ajax({
            url: "satuans/load-data",
            type: "GET",
            dataType: "json",
            success: function (resp) {
                let res = resp.data;
                // console.log(res);
                if (res.length != 0) {
                    tabeldata.html("");
                    tabelCard.html("");
                    var no = 1;
                    for (let i = 0; i < res.length; i++) {
                        let arr_tipe2= res[i].tipe.split("-")[0];
                        let arr_tipe = arr_tipe2.split(".");
                        let arr_nilai = res[i].nilai.split(".");

                        let rincian = "";
                        for (let x = 0; x < arr_tipe.length; x++) {
                           const el_k = arr_tipe[x];
                           const el_n = arr_nilai[x];
                           rincian = rincian +
                            `<li class="small">
                                <span class="col-4 d-inline-block p-0 m-0">`+el_k+`</span>:
                                <span class="col-3 d-inline-block p-0 m-0 text-right">`+el_n+`</span>
                                `+arr_tipe[arr_tipe.length-1]+`
                            </li>`
                        }

                        let cek = (res[i].konversi == 0) ? "Tidak": "Ya";

                        // button action
                        let btn_action;

                        if (res[i].deleted_at == null) {
                            btn_action =
                            `<button class="btn btn-xs btn-outline-success btn-block btn-edit"
                                data-id   ="`+res[i].id+`"
                                data-kode ="`+res[i].kode+`"
                                data-kv   ="`+res[i].konversi+`"
                                data-tipe ="`+res[i].tipe+`"
                                data-nilai="`+res[i].nilai+`"
                            ><i class="fas fa-edit"></i> Edit</button>
                            <button class="btn btn-xs btn-outline-danger btn-block btn-delete" data-id="` + res[i].id + `">
                            <i class="fas fa-times"></i> Hapus
                            </button>`
                        } else {
                            btn_action =
                            `<button class="btn btn-xs btn-outline-warning btn-block btn-restore" data-id="` + res[i].id + `">
                                <i class="fas fa-undo"></i> Restore
                            </button>`
                        }

                        let rowTable =
                            `<tr>
                                <td class="text-center">` + no + `</td>
                                <td class="text-center kode" data-kode="`+res[i].kode+`">` + res[i].tipe + `</td>
                                <td class="nilai">` + res[i].nilai + `</td>
                                <td class="text-center konversi" data-kv="`+res[i].konversi+`">` + cek + `</td>
                                <td class="text-center">`+btn_action+`</td>
                            </tr>`;

                        let rowCard =
                            `<div class="col-12 col-md-3 col-sm-4 col-xs-6 box-card">
                                <div class="card bg-box" data-id="` + res[i].id + `" data-kode="`+res[i].kode+`" data-kv="`+res[i].konversi+`" >
                                    <div class="card-header text-center border-bottom-0">
                                        <div class="row justify-content-between">
                                            <span class="tipe text-bold badge-pill bg-info pl-2 pr-2">` + res[i].tipe + `</span>
                                            <span data-toggle="tooltip" data-placement="top" title="Seleksi Satuan"
                                                class="no-card d-flex badge bg-warning badge-pill align-items-center text-sm">
                                                ` + no + `
                                            </span>
                                        </div>
                                    </div>
                                    <div class="card-body pt-0">
                                        <div class="row">
                                            <div class="col-sm-8">
                                                <ul class="ml-0 mb-0 fa-ul text-small rincian">`+rincian+`</ul>
                                            </div>
                                            <div class="col-sm-4 align-self-center">
                                                <div class="text-right">`+btn_action+`</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>`

                        no++;
                        tabelCard.append(rowCard);
                        tabeldata.append(rowTable);
                    }

                } else {
                    tabeldata.html(`<tr><td colspan="5" class="text-center">Data Belum Tersedia</td></tr>`);
                    tabelCard.html(`<div class="text-center text-info">Data Belum Tersedia</div>`);
                }
            },
        });
    }

    function multi_checkSatuan() {
        let kodeDipilih = "";
        let nilaiDipilih = "";

        selectSatuanB.attr("disabled", "disabled");
        selectSatuanS.attr("disabled", "disabled");
        selectSatuanK.attr("disabled", "disabled");
        inp_nilaiSatuan.attr("disabled", "disabled");

        let jmldipilih = 0;

        for (var i = 0; i < checkSatuan.length; i++) {
            if (checkSatuan[i].checked) {

                let swkode;

                switch (checkSatuan[i].value) {
                    case "B":
                        swkode = selectSatuanB.val();
                        selectSatuanB.removeAttr("disabled");
                        $("#nil_satuan_b").removeAttr("disabled");
                        break;
                    case "S":
                        swkode = selectSatuanS.val();
                        selectSatuanS.removeAttr("disabled");
                        $("#nil_satuan_s").removeAttr("disabled");
                        break;
                    case "K":
                        swkode = selectSatuanK.val();
                        selectSatuanK.removeAttr("disabled");
                        $("#nil_satuan_k").removeAttr("disabled");
                        $("#nil_satuan_k").attr("readonly", true);
                        break;
                }

                if (kodeDipilih.length == 0) {
                    kodeDipilih = kodeDipilih + swkode;
                    nilaiDipilih = nilaiDipilih + inp_nilaiSatuan[i].value;
                } else {
                    kodeDipilih = kodeDipilih + "." + swkode;
                    nilaiDipilih = nilaiDipilih + "." + inp_nilaiSatuan[i].value;
                }

                jmldipilih++;

            }
        }

        if (jmldipilih > 1) {
            $("span#btn_action button#btn_save").removeAttr("disabled");
        } else {
            $("span#btn_action button#btn_save").attr("disabled", "disabled");
        }
        kodeSatuan.val(kodeDipilih+'-'+nilaiDipilih);
        nilaiSatuan.val(nilaiDipilih);
    }

    function single_checkSatuan() {
        let kodeDipilih = "";
        let nilaiDipilih = "";

        selectSatuanB.attr("disabled","disabled");
        selectSatuanS.attr("disabled","disabled");
        selectSatuanK.attr("disabled","disabled");
        inp_nilaiSatuan.attr("disabled", "disabled");

        $("span#btn_action button#btn_save").attr("disabled", "disabled");

        for (var i = 0; i < checkSatuan.length; i++) {
            if (checkSatuan[i].checked) {

                let swkode;

                switch (checkSatuan[i].value) {
                    case "B":
                        swkode = selectSatuanB.val();
                        selectSatuanB.removeAttr("disabled");
                        break;
                    case "S":
                        swkode = selectSatuanS.val();
                        selectSatuanS.removeAttr("disabled");
                        break;
                    case "K":
                        swkode = selectSatuanK.val();
                        selectSatuanK.removeAttr("disabled");
                        $("#nil_satuan_k").attr("readonly", true);
                        break;
                }

                kodeDipilih = swkode;
                nilaiDipilih = inp_nilaiSatuan[i].value;

                $("span#btn_action button#btn_save").removeAttr("disabled");
            }
        }

        kodeSatuan.val(kodeDipilih);
        nilaiSatuan.val(1);
        // nilaiSatuan.val(nilaiDipilih);

    }

    function formAction(action, id) {
        switch (action) {
            case "tambah":
                urlx = "satuans";
                method = "POST";
                break;
            case "edit":
                urlx = "satuans/" + id;
                method = "PATCH";
                break;
            case "hapus":
                urlx = "satuans/" + id;
                method = "DELETE";
                break;
        }
    }

    function formDisabled() {
        formSatuan.trigger("reset");

        $("form input").attr("disabled", "disabled");
        $("form select.form-control-sm").attr("disabled", "disabled");

        selectSatuanB.trigger("change");
        selectSatuanS.trigger("change");
        selectSatuanK.trigger("change");

        nilaiSatuan.val("-");

        btnTambah.show();
        btnActionForm.empty();
    }

    function formEnabled() {
        kodeSatuan.removeAttr("disabled");
        nilaiSatuan.removeAttr("disabled");
        checkSatuan.removeAttr("disabled");

        kodeSatuan.attr("readonly", true);
        nilaiSatuan.attr("readonly", true);

        $("#nil_satuan_k").attr("readonly", true);
        pilihJenisSatuan.removeAttr("disabled");

        btnTambah.hide();
        showButtonAction();
    }

    function showButtonAction() {
        btnActionForm.html(
            `<button class="btn btn-sm btn-info" type="button" id="btn_save" disabled>Simpan</button>` +
                " " +
            `<button class="btn btn-sm btn-warning" type="button" id="btn_cancel">Batal</button>`
        );

        // $("input[name=nama]").focus();
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
            preventDuplicates: false,
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

    function deleteFunc(id) {
        if (confirm("Hapus Data Satuan?") == true) {
            $.ajax({
                url: urlx,
                type: method,
                data: { id: id },
                dataType: "json",
                success: function (resp) {
                    // console.log(resp)
                    remove_card.remove();
                    mynotife(
                        "success",
                        "Data Satuan",
                        "Data Berhasil di Hapus"
                    );
                },
                error: showError,
            });
        }
    }

    function showError(xhr, status, errorThrown) {
        let result = xhr.responseJSON;
        let pesan = result.message;
        let isi_pesan = result.errors;

        let isi;
        $.each(isi_pesan, function (key, value) {
            isi = isi + `<li>` + key + " : " + value + ` </li>`;
        });

        $(".form-errors").show();
        $(".form-errors").html(
            `<div class="alert alert-danger alert-dismissible" style="margin: 20px; padding:10px;" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="right:0px">
                    <span aria-hidden="true">&times;</span>
                </button>
                <span class="text-center"><strong>Error!-->  [` + xhr.status + `]  </strong>` +
                pesan +
                `<br><ul style="list-style-type: circle;text-align: start">` +
                isi +
                `<br>` +
                errorThrown +
                "<br>" +
                `</ul></span></div>`
        );
        // setTimeout(() => {
        //     $(".form-errors").hide();
        // }, 2000);
    }

    /**
     * Validation and saved
     */
     $.validator.setDefaults({
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

    formSatuan.validate({
        ignore: ".ignore",
        rules: {
            kode_satuan: {
                required: true,
                remote: {
                    url: "satuans/cekTipe",
                    type: "post",
                    dataType: "json",
                    data: {
                        opr: function() {return action},
                        kodelama: function() {return kodelama},
                    },
                    // success: function(resp){
                    //     console.log(resp);
                    // }
                },
            },
        },
        messages: {
            kode_satuan: {
                required: "Kode Satuan Wajib di-isi",
                remote: "Satuan ini sudah ada",
            },
        },

        submitHandler: function (form) {
            // if (confirm("Simpan Data Satuan?") == true) {
                $.ajax({
                    url: urlx,
                    type: method,
                    dataType: "json",
                    data: $(form).serialize(),
                    success: function (resp) {
                        // console.log(resp);
                        let info = resp.info;
                        mynotife(info.status, "Simpan Data", info.pesan);
                        formDisabled();
                        loadData();
                    },
                    error: function (err) {
                        console.log(err);
                        mynotife('error', "Simpan Data", err.responseText);
                    },
                });
                return false;
            // }
        },
    });

    tabelSatuan.hide();
    formDisabled();
    loadData();
    single_checkSatuan();
})

