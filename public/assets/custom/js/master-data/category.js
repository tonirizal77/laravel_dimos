/**
 * Category Product
 */

$(function(){
    "use strict";

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    // bsCustomFileInput.init();

    //Initialize Select2 Elements
    $('.select2').select2()

    let action, urlx, method, id, filter_elm, row;
    let formCategory2 = $("form#form_category2");
    let listCard = $("div#data-card");

    let btn_Tambah = $("button#btn_add");
    let btn_action = $("span#btn_action");
    let btn_action_form = $(".btn_action_form");

    let modal_form = new bootstrap.Modal(
        document.getElementById("modal_form_kategori"),
        {
            keyboard: false,
            backdrop: "static",
        }
    );


    /**
     * Button Triger
     */
    btn_Tambah.on("click", function(){
        formAction("tambah", "");
        modal_form.toggle();
    })

    btn_action_form
    .on("click", "button#btn_batal", function () {
        formCategory2.resetForm();
        $('input#status').trigger('click');
        modal_form.toggle();
    })
    .on("click", "button#btn_simpan", function () {
        formCategory2.submit();
    });

    btn_action
    .on("click","button#btn_hapus", function(){
        let multi_idx = [];
        for (let x = 0; x < filter_elm.length; x++) {
            const elm = filter_elm[x];

            if (x < filter_elm.length-1) {
                multi_idx = multi_idx + $(elm).attr('data-id')+',';
            } else {
                multi_idx = multi_idx + $(elm).attr('data-id');
            }
            // console.log(idx);
        }

        deleteFunc(multi_idx);
        $(this).hide();
    });

    listCard
    .on("click", "input[type=checkbox]", function(){
        let id = $(this).attr('data-id');
        $(this).prop('checked', function (i, value) {
            if (value) {
                $(this).parent().find("label").text("Active")
            } else {
                $(this).parent().find("label").text("Non-Active")
            }
            // console.log(id);
            updateStatus(id, value);
            // return string value;
        });
    })
    .on("click","span.nama", function(){
        let id = $(this).attr('data-id');
        let elm_parents = $(this).closest('div.kategori-box');
        let elm_clone = $(this).closest('div').html();
        let elm_nama = $(this).text();
        let elm_parent = $(this).closest('div');

        elm_parents.find("span.no-card").remove(); // hapus element nomor

        $(this).replaceWith(`
            <div class="d-flex form-group" style="width: 100%">
                <input class="form-control form-control-sm ml-2" type="text" name="nama" placeholder="Nama Kategori">
                <div class="btn-group">
                    <span class="d-flex align-items-center badge-btn" id="btn_simpan_nama" style="cursor: pointer"><i class="fas fa-check-circle text-success text-lg"></i></span>
                    <span class="d-flex align-items-center badge-btn" id="btn_batal_nama" style="cursor: pointer"><i class="fas fa-times-circle text-danger text-lg"></i></span>
                </div>
            </div>`);

        let btn_simpan_nama = $("span#btn_simpan_nama");
        let btn_batal_nama = $("span#btn_batal_nama");

        let inp_nama = $(elm_parent).find("input[name=nama]");
        inp_nama.val(elm_nama);

        btn_simpan_nama.on("click", function(){
            // alert($(inp_nama).val());
            $(this).closest('div.form-group').parent().html(elm_clone);
            updateNama(id, $(inp_nama).val())
            elm_parent.find('span.nama').html(inp_nama.val());
        })

        btn_batal_nama.on("click", function(){
            $(this).closest('div.form-group').parent().html(elm_clone);
        })

        // console.log(id);
    })
    .on("click", ".no-card", function(){
        $(this).closest('div.info-box').toggleClass('selected-card');

        filter_elm = $(".kategori-box > .info-box").filter(".selected-card")

        if (filter_elm.length > 0) {
            btn_action.html(`
                <button type="button" class="btn btn-xs btn-danger" id="btn_hapus">Hapus Kategori (`+filter_elm.length+`) </button>
            `)
        } else {
            btn_action.html("");
        }

        // console.log(filter_elm);

    });

    formCategory2
    .on("click", "input[type=checkbox]", function() {
        $(this).prop('checked', function (i, value) {
            if (value) {
                $(this).parent().find("label").text("Active")
            } else {
                $(this).parent().find("label").text("Non-Active")
            }
            return value;
        });
    });

    /**
     * Function
     */

    function previewFile(filex){
        var filex = $("input[type=file]").get(0).files[0];
        if(filex){
            var reader = new FileReader();
            reader.onload = function(){
                $("#previewImg").attr("src", reader.result);
            }
            reader.readAsDataURL(filex);
        }
    }

    function formAction(action, id) {
        switch (action) {
            case "tambah":
                urlx = "category";
                method = "POST";
                break;
            case "edit":
                urlx = "category/" + id;
                method = "PUT";
                break;
            case "hapus":
                urlx = "category/" + id;
                method = "DELETE";
                break;
        }
    }

    function loadData() {
        $.ajax({
            url: "category/load-data",
            type: "GET",
            dataType: "json",
            success: function (res) {
                console.log(res);

                let kategori = res.kategori
                let group = res.group

                if (kategori.length != 0) {
                    listCard.html("");

                    var no = 1;
                    for (let i = 0; i < kategori.length; i++) {

                        let status = (kategori[i].active == 1) ? "Active" : "Non-Active";
                        let isChecked = (kategori[i].active == 1) ? "checked" : "";

                        let total = 0;
                        for (let x = 0; x < group.length; x++) {
                            const idc = group[x].kategory_id;
                            const tot = group[x].totprod;
                            if (kategori[i].id == idc) {
                                total = tot
                            }
                        }

                        let dataCard =
                            `<div class="col-lg-3 col-md-4 col-sm-6 kategori-box">
                                <div tabindex="`+ no +`" data-id="`+kategori[i].id+`"  class="info-box shadow">
                                    <span class="info-box-icon bg-info" style="cursor:pointer"><i class="far fa-question-circle"></i></span>
                                    <div class="info-box-content">
                                        <div class="row name-cate d-flex justify-content-between">
                                            <span class="text-bold pl-2 nama" data-id="`+kategori[i].id+`">`+kategori[i].name+`</span>
                                            <span data-toggle="tooltip" data-placement="top" title="Seleksi Kategori"
                                                class="no-card d-flex badge badge-pill bg-success align-items-center text-sm">#`+ no +`</span>
                                        </div>
                                        <div class="row d-flex justify-content-between pl-2">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" id="statusSw`+ no +`" name="status[]" `+isChecked+` data-id="`+kategori[i].id+`">
                                                <label class="custom-control-label text-secondary text-sm" for="statusSw`+ no +`">`+status+`</label>
                                            </div>

                                            <span class="text-bold">`+total+` - item</span>
                                        </div>
                                    </div>
                                </div>
                            </div>`

                        no++;
                        listCard.append(dataCard);
                    }

                } else {
                    listCard.html(`<div class="col-12 text-center text-info">Data Kategori Belum Tersedia</div>`);
                }

            },
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
            positionClass: "toast-bottom-right",
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
                <span class="text-center"><strong>Error!-->  [` +
                xhr.status +
                `]  </strong>` +
                pesan +
                `<br><ul style="list-style-type: circle;text-align: start">` +
                isi +
                `<br>` +
                errorThrown +
                "<br>" +
                `</ul></span></div>`
        );
        setTimeout(() => {
            $(".form-errors").hide();
        }, 2000);
    }

    function updateStatus(id, status) {
        $.ajax({
            url: "category/update-status",
            type: "post",
            data: { id: id, status: status },
            dataType: "json",
            success: function (resp) {
                console.log(resp);
                // return false;

                let pesan = resp.info.pesan;
                let isi = resp.info.isi_pesan;
                mynotife(pesan, "Update Status", isi);
            },
            error: function(err){console.log(err)},
        });
    }

    function updateNama(id, nama) {
        // if (confirm("Update Nama Kategori?") == true) {
            $.ajax({
                url: "category/update-name",
                type: "post",
                data: { id: id, nama: nama },
                dataType: "json",
                success: function (resp) {
                    console.log(resp);
                    // return false;

                    let pesan = resp.info.pesan;
                    let isi = resp.info.isi_pesan;
                    mynotife(pesan, "Update Nama", isi);
                },
                error: function(err){console.log(err)},
            });
        // }
    }

    function deleteFunc(id) {
        if (confirm("Hapus Data Kategori?") == true) {
            $.ajax({
                url: "category/multi-delete",
                type: "post",
                data: { id: id },
                dataType: "json",
                success: function (resp) {
                    // console.log(resp);
                    let pesan = resp.info.pesan;
                    let isi = resp.info.isi_pesan;
                    filter_elm.parent().remove();
                    mynotife(pesan, "Hapus Kategori", isi);
                },
                error: function(err){console.log(err)},
            });
        } else {
            //  removeClass('selected-card');
            $('div.info-box').removeClass('selected-card');
        }
    }

    /**
     * Validation
     */
     $.validator.setDefaults({
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },

        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },

        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        }
    });

    formCategory2.validate({
        rules: {
            name: { required: true, },
            // icons: { required: true },
        },
        messages: {
            name: "Mohon nama wajib di-isi",
            // icons: "Pilih Icons yang tersedia"
        },

        submitHandler: function (form) {
            let status = $('input#status').prop('checked');
            let name = $('input#name').val();
            // let token = $('input[name=_token]').val();
            // let data = $(form).serialize();
            console.log('status:' + status, 'name:'+name);

            if (confirm("Simpan Data Kategori?") == true) {
                $.ajax({
                    url: urlx,
                    type: method,
                    dataType: "json",
                    data: {
                        name: name,
                        active: status,
                        // _token: token,
                    },
                    success: function (resp) {
                        console.log(resp);
                        // return false;

                        loadData();
                        modal_form.toggle();
                        formCategory2.resetForm();
                        $('input#status').trigger('click');

                        let pesan = resp.info.pesan;
                        let isi = resp.info.isi_pesan;
                        mynotife(pesan, "Simpan Data", isi);
                    },
                    error: function (err) {
                        console.log(err);
                    },
                });
                return false;
            };
        }
    });

    /**
     * Run Start At
     */

    loadData();

})
