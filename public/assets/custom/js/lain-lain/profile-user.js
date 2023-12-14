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
    // $("#telpon").inputmask({
    //     mask: '9999-9999-9999',
    //     placeholder: ' ',
    //     showMaskOnHover: false,
    //     showMaskOnFocus: false,
    //     onBeforePaste: function (pastedValue, opts) {
    //       var processedValue = pastedValue;
    //       //do something with it
    //       console.log(processedValue);
    //       if (processedValue.length > 14) {
    //             // mask: '9999-99999-9999',
    //       } else {
    //         // mask: '9999-9999-9999',
    //       }
    //       return processedValue;
    //     }
    //   });

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
    let form_profile = $("form#form_user_profile");
    // let form_access = $("form#form_user_access");

    let image_user = $("input#inputFile");

    // let nama_user = $("input#nama_user");
    // let telpon = $("input#telpon");
    // let alamat = $("textarea#alamat");
    let provinsi = $("select#provinsi");
    let kota = $("select#kota");

    let username = $("input#username");
    let email = $("input#email");
    // let password = $("input#password");
    let password_lama = $("input#password_lama");

    let urlx, method, action, idx, kodelama;

    let btn_edit_profile = $("button#btn_edit_profile");
    let btn_action1 = $("#btn_action_1");

    let btn_edit_access = $("button#btn_edit_access");
    let btn_action2 = $("#btn_action_2");

    let kota_id = $('a.kota').attr('data-kota');
    let prov_id = $('a.kota').attr('data-prov');

     // AjaxForm for option setting
    let opsi_user_profile = {
        dataType: "json",
        clearForm: false,
        resetForm: false,
        // complete: function (resp) {
        //     if ($.isEmptyObject(resp.responseJSON.error)) {
        //         console.log(resp.responseJSON);
        //         // let info = resp.responseJSON.pesan;
        //         // let data = resp.responseJSON.data[0];
        //         // console.log(data);
        //         // mynotife("success", "Sukses", info);
        //     } else {
        //         printErrorMsg(resp.responseJSON.error);
        //     }
        // },

        // target: "#output1", // target element(s) to be updated with server response
        // beforeSubmit: validate,
        // beforeSubmit: showRequest, // pre-submit callback

        success: function (resp) {
            let info = resp.pesan;
            let isi_pesan = resp.pesan.info;
            let teks = "";

            isi_pesan.forEach(elm => {
                teks = teks + `<li>`+elm+`</li>`
            });
            teks = `<ol class="pl-3">`+teks+`</ol>`

            if (info.status == "error") {
                // mynotife(info.status, "Ada Kesalahan", teks);
                $(document).Toasts('create', {
                    class: 'bg-danger',
                    title: 'Ada Kesalahan',
                    position: 'bottomRight',
                    subtitle: 'Simpan Data',
                    icon: 'fas fa-frown',
                    body: teks,
                })
            } else {

                btn_action1.html("");
                btn_edit_profile.show();
                formUser_change();

                // mynotife(info.status, "Sukses", teks);
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

            console.log(info);
        }, // post-submit callback
    };

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
     * Set Button Function Trigger
     */
    btn_edit_profile.on('click', function(){
        idx = $(this).attr('data-id');

        $(this).hide();
        btn_action1.html(`
            <button type="submit" class="btn btn-outline-primary btn-xs mr-1" id="btn_simpan_profile"><i class="fas fa-save"></i> Simpan</button></a>
            <button type="button" class="btn btn-outline-danger btn-xs" id="btn_batal_profile"><i class="fas fa-times"></i> Batal</button></a>
        `);

        action = "edit";
        kodelama=username.val();

        formAction("edit", idx);
        formUser_change(true);
    });
    btn_action1
        .on('click','button#btn_batal_profile', function(){
            btn_action1.html("");
            btn_edit_profile.show();
            formUser_change();
        })
        .on('click','button#btn_simpan_profile', function(){
            form_profile.ajaxForm(opsi_user_profile);

        });

    btn_edit_access.hide();
    // btn_edit_access.on('click', function(){
    //     $(this).hide();
    //     btn_action2.html(`
    //         <button type="submit" class="btn btn-xs btn-outline-primary" id="btn_simpan"><i class="fas fa-save"></i> Simpan</button>
    //         <button type="button" class="btn btn-xs btn-outline-danger" id="btn_batal"><i class="fas fa-times"></i> Batal </button>
    //     `)
    // });
    // btn_action2
    //     .on('click','button#btn_simpan', function(){
    //         btn_action2.html("");
    //         btn_edit_access.show();
    //     })
    //     .on('click','button#btn_batal', function(){
    //         btn_action2.html("");
    //         btn_edit_access.show();
    //     });

    form_profile.enterAsTab({ allowSubmit: false });

    /**
     * Function
     */
    // buat object Date dan convert yyyy-mm-dd to dd-mm-yyyy
    // var newdate1 = tgl1.split("-").reverse().join("-");

    function formUser_change(xform) {
        if (xform) {
            $("form#form_user_profile input").attr("disabled", false)
            $("form#form_user_profile textarea").attr("disabled", false)
            $("form#form_user_profile select").attr("disabled", false)
            image_user.attr("disabled", false)
        } else {
            // form_profile.resetForm();
            $("form#form_user_profile input").attr("disabled", true);
            $("form#form_user_profile textarea").attr("disabled", true)
            $("form#form_user_profile select").attr("disabled", true)
            image_user.attr("disabled", true)
            $("input[name=_method]").replaceWith(`<div id="method"></div>`);
        }
        password_lama.attr("disabled", true);
        // username.attr("disabled", true);
        // email.attr("disabled", true);
    }

    /**
     * switch form Aksi Submit Nota Pembelian
     * @param {*} action string (Tambah, Edit, Hapus)
     * @param {*} idx string (nomor nota)
     */
    function formAction(action, idx) {
        switch (action) {
            case "tambah":
                urlx = "profile-user";
                method = "POST";
                break;
            case "edit":
                urlx = "profile-user/" + idx;
                method = "POST";
                $("#method").replaceWith(
                    `<input type="hidden" name="_method" value="PUT">`
                );
                break;
            case "hapus":
                urlx = "profile-user/" + idx;
                method = "DELETE";
                break;
        }
        form_profile.attr("action", urlx);
        form_profile.attr("method", method);
    }


    function showError(xhr, errorThrown) {
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
                <span class="text-center"><strong>Error! [` + xhr.status + `]  </strong>` +
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
                // switch (switchConfirm) {
                //     case "Nota Baru":
                //         nota_baru(kode_sesi);
                //         break;
                //     case "Batal Transaksi":
                //         batal_nota();
                //         break;
                //     case "Simpan Transaksi":
                //         simpan_nota();
                //         break;
                //     case "Proses Bayar":
                //         bayar_nota();
                //         break;
                //     case "Edit Nota":
                //         edit_nota(id_nota);
                //         break;
                //     case "Hapus Nota":
                //         hapus_nota(id_nota);
                //         break;
                //     case "Sesi Out":
                //         sesi_out(true);
                //         break;
                //     default:
                //         mynotife(
                //             "error",
                //             "Ada Kesalahan System",
                //             "Confirm [" + switchConfirm + "] - Tidak Tersedia"
                //         );
                // }
            } else {
                // kode_Brg.focus();
                // return false;
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

    form_profile.validate({
        ignore: ".ignore",
        rules: {
            nama_user: { required: true, minlength: 3 },
            alamat: { required: true, minlength: 10 },
            kota: { required: true },
            password: { minlength: 6 },
            username: {
                required: true,
                minlength: 6,
                maxlength: 20,
                remote: {
                    url: "profile-user/cekDataUser",
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
            nama_user: {
                required: "Wajib di-isi",
                minlength: $.validator.format("Min. {0} karakter")
            },
            alamat: {
                required: "Wajib di-isi",
                minlength: $.validator.format("Min. {0} karakter")
            },
            telpon: {
                required: "Wajib di-isi",
                minlength: $.validator.format("Min. {0} karakter"),
                maxlength: $.validator.format("Min. {0} karakter"),
                remote: "No. Handphone ini sudah ada"
            },
            kota: { required: "Wajib di-isi" },
            username: {
                required: "Wajib di-isi",
                minlength: $.validator.format("Min. {0} karakter"),
                maxlength: $.validator.format("Min. {0} karakter"),
                remote: "Username sudah ada, ganti nama usaha/customer"
            },
            email: {
                required: "Wajib di-isi",
                email: "Format Email tidak valid",
                remote: "Email ini sudah ada"
            },
            password: {
                required: "Wajib di-isi",
                minlength: $.validator.format("Min. {0} karakter")
            },
        },
    });

    /**
     * run start js
     */
    formUser_change();
});
