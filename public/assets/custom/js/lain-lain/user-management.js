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
    let password = $("input#password");
    let status = $("input[name=status]");
    let posisi = $("input[name=posisi]");

    let urlx, method, action, idx;
    let getFile, cloneLogo;

    let btn_edit_profile = $("button#btn_edit_profile");
    let btn_add_profile = $("button#btn_add_profile");
    let btn_action1 = $("#btn_action_1");

    let btn_edit_access = $("button#btn_edit_access");
    let btn_action2 = $("#btn_action_2");

    let tabel_rinci = $('#tabel_rinci tbody');
    let tabel_user = $('#tabel_rinci');
    let currRow = tabel_rinci.find("tr").first();
    let currCell = tabel_rinci.find("td").first();
    let user_id = "";

     // AjaxForm for option setting
    let opsi_user_profile = {
        dataType: "json",
        clearForm: false,
        resetForm: true,
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
            console.log(resp);
            // return false;

            let info = resp.pesan;
            let isi_pesan = resp.pesan.ket;
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
                btn_add_profile.show();
                formUser_change();

                // mynotife(info.status, "Sukses", teks);
                $(document).Toasts('create', {
                    class: 'bg-success',
                    icon: 'fas fa-grin',
                    title: 'Sukses',
                    subtitle: 'Simpan Data',
                    position: 'bottomRight',
                    autohide: true,
                    delay: 8000,
                    body: teks,
                });

                loadDataUser();
            }

            console.log(info);
        }, // post-submit callback
    };

    let kota_id = "";
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
                    if (kota_id != "" && action == "edit") {
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

    image_user.on('change', function(){
        previewFile($(this));
    });

    /**
     * Set Button Function Trigger
     */

    tabel_user
    .on("keydown", navigation)
    .on('click', 'td', function(){
        currCell = $(this);
        currRow = currCell.closest('tr');
        user_id = currRow.attr('data-id');
        currCell.focus();
    })
    .on("dblclick", "td", function () {
        currCell = $(this);
        currRow = currCell.closest('tr');
        user_id = currRow.attr('data-id');
        $("tr").removeClass("selected-row");
        currRow.addClass("selected-row");
        currCell.focus();
        btn_edit_profile.trigger('click')
    });

    btn_add_profile.on('click', function(){
        $(this).hide();
        btn_edit_profile.hide();
        btn_action1.html(`
            <button type="submit" class="btn btn-outline-primary btn-xs mr-1" id="btn_simpan_profile"><i class="fas fa-save"></i> Simpan</button></a>
            <button type="button" class="btn btn-outline-danger btn-xs" id="btn_batal_profile"><i class="fas fa-times"></i> Batal</button></a>
        `);

        formAction("tambah", "");
        formUser_change(true);
        password.attr("disabled", false);
        username.attr("disabled", false);
    });

    btn_edit_profile.on('click', function(){
        if (user_id != "") {
            $(this).hide();
            btn_add_profile.hide();
            btn_action1.html(`
                <button type="submit" class="btn btn-outline-primary btn-xs mr-1" id="btn_simpan_profile"><i class="fas fa-save"></i> Simpan</button></a>
                <button type="button" class="btn btn-outline-danger btn-xs" id="btn_batal_profile"><i class="fas fa-times"></i> Batal</button></a>
            `);

            $("tr").removeClass("selected-row");
            currRow.addClass("selected-row");

            formAction("edit", user_id);
            formUser_change(true);
            username.attr("disabled", true);
            email.attr("disabled", true);

            cloneLogo = $("#previewImg").attr('src');
            getUser(user_id);
        }
    });

    btn_action1
    .on('click','button#btn_batal_profile', function(){
        btn_action1.html("");
        btn_add_profile.show();
        btn_edit_profile.show();
        formUser_change();
        $("#previewImg").attr("src", cloneLogo);
        $("tr").removeClass("selected-row");
    })
    .on('click','button#btn_simpan_profile', function(){

        form_profile.ajaxForm(opsi_user_profile);
    });

    btn_edit_access.hide(); // button edit access

    // status.on('change', function(){
    //     let value = $(this).val();

    //     status.removeAttr('checked');

    //     if (value == 1) {
    //         $('#active').prop('checked', true)
    //         $('#active').attr('checked', true)
    //     } else {
    //         $('#non-active').prop('checked', true)
    //         $('#non-active').attr('checked', true)
    //     }
    // }).change();

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

    username.on("keydown", function(e){
        if (e.which === 32)
        return false;
    }).on("keyup", function(){
        this.value = this.value.toLowerCase();
    }).on('change',function() {
        this.value = this.value.replace(/\s/g, "");
    })

    function getUser(id){
        $.ajax({
            url: "user-management/"+id+"/edit",
            // method: "get",
            success: function(resp){
                console.log(resp);
                $('#nama_user').val(resp.name);
                $('#verifikasi_hp').attr('href','verifikasi-handphone?='+resp.telpon);
                $('#telpon').val(resp.telpon);
                $('#alamat').val(resp.alamat);
                kota_id = resp.cities_id;
                $('#provinsi').val(resp.prov_id);
                $('#provinsi').trigger('change');

                $('#username').val(resp.username);
                $('#email').val(resp.email);
                $('#verifikasi_email').attr('href','verifikasi-email?='+resp.email);

                status.removeAttr('checked');
                $("input[name=status][value=" + resp.active + "]").prop('checked', true);
                // $("input[name=status][value=" + resp.active + "]").attr('checked', true);

                posisi.removeAttr('checked');
                $("input[name=posisi][value=" + resp.role_id + "]").prop('checked', true);
                // $("input[name=posisi][value=" + resp.role_id + "]").attr('checked', true);

                if (resp.profilePicture != null){
                    $('img#previewImg').attr('src','/profile/'+resp.profilePicture)
                }
            },
            error: function(err){
                console.log(err);
            }
        })
    }

    function navigation(e) {
        e.preventDefault();

        let c = "";
        if (e.which == 39) {
            // Right Arrow
            if (currCell.index() < 4) {
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
            user_id = $(currRow).attr("data-id");
            // $("tr").removeClass("selected-row");
            // currRow.addClass("selected-row");
            btn_edit_profile.trigger('click')
        }

        if (c.length > 0) {
            currCell = c;
            currRow = currCell.closest("tr");
            currCell.focus();
            user_id = currRow.attr("data-id");
            // currRow.focus();
            // data_cell = currRow.find("td");
        }
    };

    function formUser_change(xform) {
        if (xform) {
            $("form#form_user_profile input").attr("disabled", false)
            $("form#form_user_profile textarea").attr("disabled", false)
            $("form#form_user_profile select").attr("disabled", false)
            image_user.attr("disabled", false)
            form_profile.trigger('reset');
        } else {
            // form_profile.resetForm();
            $("form#form_user_profile input").attr("disabled", true);
            $("form#form_user_profile textarea").attr("disabled", true)
            $("form#form_user_profile select").attr("disabled", true)
            image_user.attr("disabled", true)
            $("input#method").replaceWith(`<div id="method"></div>`);

        }
        form_profile.find(".is-invalid").removeClass("is-invalid");
        form_profile.find("span.error").remove();
    }

    /**
     * switch form Aksi Submit Nota Pembelian
     * @param {*} action string (tambah, edit, hapus)
     * @param {*} idx string (nomor nota)
     */
    function formAction(action, idx) {
        switch (action) {
            case "tambah":
                urlx = "user-management";
                method = "POST";
                break;
            case "edit":
                urlx = "user-management/" + idx;
                method = "POST";
                $("#method").replaceWith(
                    `<input type="hidden" name="_method" value="PUT" id="method">`
                );
                break;
            case "hapus":
                urlx = "user-management/" + idx;
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

    function loadDataUser() {
        $.ajax({
            url: 'load-data-user',
            success: function(resp){
                console.log(resp)
                let data = resp.user;

                tabel_rinci.html(`<tr class="text-center"><td colspan="6">Data User Belum Tersedia</td></tr>`);

                if (data.length != 0) {

                    tabel_rinci.html("");

                    let no = 1;
                    for (let i = 0; i < data.length; i++) {
                        const elm = data[i];

                        let status =  (elm.active == 0)
                            ? `<span class="badge badge-btn badge-danger">Non-Active</span>`
                            : `<span class="badge badge-btn badge-success">Active</span>` ;

                        let roles = "-";
                        switch (elm.role_id) {
                            case 1:
                                roles = 'Admin';
                                break;
                            case 2:
                                roles = 'User';
                                break;
                            case 3:
                                roles = 'Kasir';
                                break;
                            case 4:
                                roles = 'Accounting';
                                break;
                            case 5:
                                roles = 'Karyawan';
                                break;
                        }
                        tabel_rinci.append(`
                            <tr class="text-center" tabindex="`+no+`" data-id="`+elm.id+`">
                                <td>#`+no+`</td>
                                <td tabindex="1"><i class="fas fa-user"></i> - `+elm.name+` <br> <span class="text-secondary">`+elm.username+`</span></td>
                                <td tabindex="2">`+roles+` <br> `+status+`</td>
                                <td tabindex="3">`+elm.alamat+ ` Kota `+ elm.kota +`</td>
                                <td tabindex="4"><span class="text-secondary">`+ elm.telpon +`</span> <br> `+ elm.email +`</td>
                                <td>
                                    <button type="button" class="btn btn-xs btn-outline-primary" data-id="`+ elm.id +`">
                                        <i class="fas fa-edit"></i>Setting</button>
                                </td>
                            </tr>
                        `)
                        no++;
                    }
                }
            }
        })
        return false;
    }
    /**
     * Validation & Foam
     * !preg_match("/^[a-zA-Z0-9]*$/", $username)
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
            provinsi: { required: true },
            status: { required: true },
            posisi: { required: true },
            password: { minlength: 6 },
            username: {
                required: true,
                minlength: 6,
                maxlength: 20,
                remote: {
                    url: "user-management/cekDataUser",
                    type: "post",
                    dataType: "json",
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
            kota: { required: "Wajib di-pilih" },
            provinsi: { required: "Wajib di-pilih" },
            status: { required: "Wajib di-pilih" },
            posisi: { required: "Wajib di-pilih" },
            username: {
                required: "Wajib di-isi",
                minlength: $.validator.format("Min. {0} karakter"),
                maxlength: $.validator.format("Min. {0} karakter"),
                remote: "Username sudah ada."
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

        // submitHandler: function (form) {
        //     //ajax nota
        //     $.ajax({
        //         url: urlx,
        //         method: method,
        //         dataType: "json",
        //         data: $(form).serialize(),
        //         success: function (resp) {
        //             console.log(resp);
        //             // return false;

        //             let pesan = resp.info.pesan;
        //             let isi = resp.info.isi_pesan;
        //             // reset
        //         },
        //         error: showError,
        //     });
        // },
    });

    /**
     * run start js
     */
    formUser_change();
    loadDataUser();
});
