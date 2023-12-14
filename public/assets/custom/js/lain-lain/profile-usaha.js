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
    $(".select2").select2();

    let spass = $(".toggle-password");
    spass.css("cursor: pointer");
    $("body").on('click', '.toggle-password', function() {
        let ipass = $("input[name=password]")
        if (ipass.attr("type") === "password") {
            ipass.attr("type", "text");
            $("span#toggle-password").html(`<i class="fas fa-eye-slash"></i>`)
        } else {
            ipass.attr("type", "password");
            $("span#toggle-password").html(`<i class="fas fa-eye"></i>`)
        }
    });

    /**
     * set varibel foam
     */
    let form_toko = $("form#form_toko");
    let form_logo = $("form#form_ganti_logo");
    let nama = $("input#nama");
    let telpon = $("input#telpon");
    let alamat = $("textarea#alamat");
    let email = $("input#email");
    let provinsi = $("select#provinsi");
    let kota = $("select#kota");

    let urlx, method, action, idusaha, usaha;
    let cek_ganti_logo = false;

    let btn_buat = $("button#btn_buat");
    let btn_edit = $("button#btn_edit");
    let btn_action = $("#btn_action");
    let kota_id = $('a.kota').attr('data-kota');

    let btn_ganti = $('#btn_action_logo');
    let label_ganti = $('#label_ganti');
    let img_ganti = $('input#ganti_logo');
    let image_logo = $("input#inputFile");
    let getFile, cloneLogo;

     // AjaxForm for option setting
    let progress_bar = $('#progress_animation');
    progress_bar.hide();

    let options = {
        dataType: "json",
        clearForm: true,
        resetForm: true,
        // complete: function (resp) {
            // console.log(resp.responseJSON);
            // return false
        // },
        // target: "#output1", // target element(s) to be updated with server response
        // beforeSubmit: validate,
        // beforeSubmit: showRequest, // pre-submit callback
        success: function (resp) {
            console.log(resp);
            // return false

            let pesan = resp.pesan;
            let isi_pesan = pesan.ket;
            let teks = "";

            isi_pesan.forEach(elm => {
                teks = teks + `<li>`+elm+`</li>`
            });
            teks = `<ol class="pl-3">`+teks+`</ol>`

            if (pesan.status == "error") {
                // mynotife(pesan.status, "Ada Kesalahan", teks);
                $(document).Toasts('create', {
                    class: 'bg-danger',
                    title: 'Ada Kesalahan',
                    position: 'bottomRight',
                    subtitle: 'Simpan Data',
                    icon: 'fas fa-frown',
                    body: teks,
                })
            } else {
                label_ganti.show();
                btn_edit.show();
                btn_action.html("");

                if (!cek_ganti_logo) {
                    loadDataToko()
                } else {
                    // cloneLogo = $("#previewImg").attr('src');
                }
                formUsaha_change();
                formLogo_change();

                $(document).Toasts('create', {
                    class: 'bg-success',
                    icon: 'fas fa-grin',
                    title: 'Sukses',
                    subtitle: 'Simpan Data',
                    position: 'topRight',
                    autohide: true,
                    delay: 8000,
                    body: teks,
                })
            }
            return false;
        }, // post-submit callback
    };

    form_toko.enterAsTab({ allowSubmit: false });

    /**
     * Set Button Function Trigger
     */
    img_ganti.on('change', function(){
        cloneLogo = $("#previewImg").attr('src');
        previewFile($(this));
        if (getFile) {
            cek_ganti_logo = true;
            btn_edit.hide();
            label_ganti.hide();
            btn_ganti.html(`
                <button type="submit" class="btn btn-outline-primary btn-xs mr-1" id="btn_simpan_logo"><i class="fas fa-save"></i> Simpan</button></a>
                <button type="button" class="btn btn-outline-danger btn-xs" id="btn_batal_logo"><i class="fas fa-times"></i> Batal</button></a>
            `);
        }
    })

    image_logo.on('change', function(){
        previewFile($(this));
    })



    btn_ganti
    .on('click','button#btn_batal_logo', function(){
        $("#previewImg").attr("src", cloneLogo);
        formLogo_change(false);
    })
    .on('click','button#btn_simpan_logo', function(){
        if (img_ganti.val() != "") {
            formLogo_change(true);
            form_logo.ajaxForm(options);
        } else {
            alert("File tidak tersedia, ulangi lagi!");
            label_ganti.show()
            btn_ganti.html('');
            $("#previewImg").attr("src", cloneLogo);
            return false;
        }
    });

    btn_edit.on('click', function(){
        let idx = $(this).attr('data-id');

        $(this).hide();
        btn_action.html(`
            <button type="submit" class="btn btn-outline-primary btn-xs mr-1" id="btn_simpan"><i class="fas fa-save"></i> Simpan</button></a>
            <button type="button" class="btn btn-outline-danger btn-xs" id="btn_batal"><i class="fas fa-times"></i> Batal</button></a>
        `);

        label_ganti.hide();

        action = "edit";
        formAction(action, idx);
        formUsaha_change(true);
    });

    btn_buat.on('click', function(){
        $(this).hide();
        btn_action.html(`
            <button type="submit" class="btn btn-outline-primary btn-xs mr-1" id="btn_simpan"><i class="fas fa-save"></i> Simpan</button></a>
            <button type="button" class="btn btn-outline-danger btn-xs" id="btn_batal"><i class="fas fa-times"></i> Batal</button></a>
        `);

        action = "tambah";
        formAction(action);
        formUsaha_change(true);
    })

    btn_action
    .on('click','button#btn_batal', function(){
        btn_action.html("");
        btn_edit.show();
        btn_buat.show();
        label_ganti.show();
        formUsaha_change();
        loadDataToko();
    })
    .on('click','button#btn_simpan', function(){
        form_toko.ajaxForm(options);
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
                    // set value for edit di sini
                    if (kota_id != "" && action == "Edit") {
                        kota.val(kota_id);
                        kota_id = ""
                    } else {
                        kota.val(kota_id);
                    }
                    kota.trigger("change");
                }
            }
        })
    }).change();

    /**
     * Function
     */
    // buat object Date dan convert yyyy-mm-dd to dd-mm-yyyy
    // var newdate1 = tgl1.split("-").reverse().join("-");
    // Convertion date (yyyy-mm-dd) to dd-mm-yyyy

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

    function formLogo_change(xform) {
        if (xform) {
            form_logo.attr("action", "profile-usaha/"+idusaha);
            form_logo.attr("method", "post");
            $("#method2").replaceWith(`<input type="hidden" name="_method" value="PUT" id="method2">`);
        } else {
            cek_ganti_logo = false;
            $("#method2").replaceWith('<div id="method2"></div>');
            form_logo.removeAttr('action');
            form_logo.removeAttr('method');
            btn_edit.show();
            label_ganti.show();
            btn_ganti.html('');
            img_ganti.val('');
        }
    }

    function loadDataToko() {
        $.ajax({
            url: "load-toko",
            method: 'get',
            success: function(resp){
                // console.log(resp)

                let info = resp.pesan;
                let prov = resp.provinsi;
                usaha = resp.usaha;

                if (prov.length > 0) {
                    prov.forEach(elm => {
                        provinsi.append(`
                            <option value=`+elm.id+`>`+elm.name+`</option>
                        `)
                    });
                } else {
                    provinsi.append(`<option value="">Tidak Ada Data</option>`)
                };
                provinsi.trigger('change');

                if (info.status == "success") {
                    if (usaha == null){
                        $('#info_status').text('Belum Aktif')
                        btn_edit.hide()
                        btn_buat.toggleClass('d-none');
                    } else if (usaha.status != 1) {
                        $('#info_status').html('Belum Aktif');

                        $('#action_paket').html(
                            `<button class="btn btn-xs btn-warning mr-2" id="btn_gratis">Aktivasi Akun Gratis</button>
                            <button class="btn btn-xs btn-primary" id="btn_berbayar">Aktivasi Akun Berbayar</button>`
                        )
                    } else {
                        $('#info_status').text('Aktif')
                    }

                    if (usaha != null) {
                        $('#info_nama').text((usaha.nama == null) ? "Nama Toko" : usaha.nama);
                        $('#info_email').text((usaha.email == null) ? "email@example.com" : usaha.email);
                        $('#info_telpon').text((usaha.telpon == null) ? "No. Telpon" : usaha.telpon);
                        $('#info_kota').text(usaha.kota);
                        $('#info_akun').text((usaha.status_akun == 1) ? 'Aktif' : 'Belum Aktif');
                        $('#info_kota').attr('data-prov', usaha.prov_id);
                        $('#info_kota').attr('data-kota', usaha.cities_id);
                        $('#info_alamat').text((usaha.alamat == null) ? "Alamat Toko" : usaha.alamat);
                        $('img#previewImg').attr('src', (usaha.logo != null) ? '/images/profile/' + usaha.logo : '/assets/ui_admin/dist/img/logo_175x75.png');

                        // data form
                        btn_edit.attr('data-id', usaha.id);
                        idusaha = usaha.id;

                        kota_id = usaha.cities_id;
                        prov_id = usaha.prov_id; //toni

                        nama.val(usaha.nama);
                        telpon.val(usaha.telpon);
                        email.val(usaha.email);
                        alamat.val(usaha.alamat);
                        provinsi.val(usaha.prov_id)
                        provinsi.trigger('change');
                    }

                } else {
                    // tampilkan modal warning
                    $('.content').html(`
                        <div class="text-danger text-lg text-center text-bold">Anda tidak bisa akses halaman ini.</div>
                    `);
                }
            }
        });
        return false;
    }

    function formUsaha_change(xform) {
        if (xform) {
            $("form#form_toko input").attr("disabled", false)
            $("form#form_toko textarea").attr("disabled", false)
            $("form#form_toko select").attr("disabled", false)
            image_logo.attr("disabled", false)
            nama.focus();
        } else {
            $("form#form_toko input").attr("disabled", true);
            $("form#form_toko textarea").attr("disabled", true)
            $("form#form_toko select").attr("disabled", true)
            image_logo.attr("disabled", true)
            $("input#method").replaceWith(`<div id="method"></div>`);
            form_toko.removeAttr('action');
            form_toko.removeAttr('method');
            // clear form from error validator
            form_toko.find(".is-invalid").removeClass("is-invalid");
            form_toko.find("span.error").remove();
            image_logo.val('');
            img_ganti.val('')
        }
    }

    /**
     * switch form Aksi Submit Nota Pembelian
     * @param {*} action string (Tambah, Edit, Hapus)
     * @param {*} idx string (nomor nota)
     */
    function formAction(action, idx) {
        switch (action) {
            case "tambah":
                urlx = "profile-usaha";
                method = "POST";
                break;
            case "edit":
                urlx = "profile-usaha/" + idx;
                method = "POST";
                $("#method").replaceWith(
                    `<input type="hidden" name="_method" value="PUT" id="method">`
                );
                break;
        }
        form_toko.attr("action", urlx);
        form_toko.attr("method", method);
    }

    /**
     * Validation & Foam
     */
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

    form_toko.validate({
        ignore: ".ignore",
        rules: {
            nama: { required: true, minlength: 3 },
            alamat: { required: true, minlength: 10 },
            kota: { required: true },
            // email: {
            //     required: true,
            //     email: true,
            //     remote: {
            //         url: "customers/cekDataUser",
            //         type: "post",
            //         dataType: "json",
            //         // success: function(resp){
            //         //     console.log(resp);
            //         // }
            //     },
            // },
            // telpon: {
            //     required: true,
            //     minlength: 10,
            //     maxlength: 15,
            //     remote: {
            //         url: "customers/cekDataUser",
            //         type: "post",
            //         dataType: "json",
            //         // success: function(resp){
            //         //     console.log(resp);
            //         // }
            //     },
            // },
        },

        messages: {
            nama: {
                required: "Wajib di-isi",
                minlength: $.validator.format("Min. {0} karakter")
            },
            alamat: {
                required: "Wajib di-isi",
                minlength: $.validator.format("Min. {0} karakter")
            },
            kota: { required: "Wajib di-isi" },
            telpon: {
                required: "Wajib di-isi",
                minlength: $.validator.format("Min. {0} karakter"),
                maxlength: $.validator.format("Min. {0} karakter"),
                remote: "No. Handphone ini sudah ada"
            },
            email: {
                required: "Wajib di-isi",
                email: "Format Email tidak valid",
                remote: "Email ini sudah ada"
            },
        },
    });

    /**
     * run start js
     */
    formUsaha_change();
    loadDataToko();
});
