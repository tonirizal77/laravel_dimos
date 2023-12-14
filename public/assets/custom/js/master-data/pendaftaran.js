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
    $("#telpon").inputmask({
        mask: '9999-9999-9999',
        placeholder: ' ',
        showMaskOnHover: false,
        showMaskOnFocus: false,
        onBeforePaste: function (pastedValue, opts) {
          var processedValue = pastedValue;
          //do something with it
          console.log(processedValue);
          if (processedValue.length > 14) {
                // mask: '9999-99999-9999',
          } else {
            // mask: '9999-9999-9999',
          }
          return processedValue;
        }
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
     * set varibel foam
     */
    let form_isian = $("form#form_customer");

    let nama_usaha = $("input#nama_usaha");
    let nama_customer = $("input#nama_customer");
    let username = $("input#username");

    // variabel for edit
    // let tipe_cs = $("input[name='tipe_cs']");
    // let tipe_customer = $("input#tipe_customer");
    // let tipe_store = $("input#tipe_store");
    // let alamat = $("input#alamat");
    // let kota = $("input#kota");
    // let telpon = $("input#telpon");
    // let email = $("input#email");
    // let password = $("input#password");
    // let tipe_access = $("input[name='tipe_user']");
    // let tipe_admin = $("input#admin");
    // let tipe_user = $("input#user");
    // let status = $("input#status");

    let urlx, method, action, idx;

    /**
     * Set Button Variable
     */
    let btn_TambahData = $("button#btn_tambah")
    let btn_SimpanData = $("button#btn_simpan")
    let btn_Batal = $("button#btn_batal")

    let modal_formCS = new bootstrap.Modal(
        document.getElementById("modal_form_cs"),
        {
            keyboard: false,
            backdrop: "static",
        }
    );

    form_isian.enterAsTab({ allowSubmit: false });

    // Button Function Modal Form Isian Data
    btn_TambahData.on("click", function () {
        action = "Tambah";
        idx = "",
        formAction(action, idx)
        formChange(true);
        modal_formCS.toggle();
    });

    btn_Batal.on("click",function(){
        formChange(false);
    })

    btn_SimpanData.on("click", function () {
        formAction(action, idx)
        console.log("action: "+action,"idx: "+idx)
        console.log("url: "+urlx,"method: "+method)
        form_isian.submit();
    });

    /**
     * Function
     */
    //buat object Date dan convert yyyy-mm-dd to dd-mm-yyyy
    // var newdate1 = tgl1.split("-").reverse().join("-");

    function formChange(xform) {
        if (xform) {
            $("form#form_customer input").attr("disabled", false)
            $("form#form_customer textarea").attr("disabled", false)
        } else {
            $("form#form_customer textarea").attr("disabled", true)
            $("form#form_customer input").attr("disabled", true);
            form_isian.trigger("reset");
        }
        $("form#form_customer input#tipe_distributor").attr("disabled", true)
    }


    /**
     * switch form Aksi Submit Nota Pembelian
     * @param {*} action string (Tambah, Edit, Hapus)
     * @param {*} idx string (nomor nota)
     */
     function formAction(action, idx) {
        switch (action) {
            case "Tambah":
                urlx = "customers";
                method = "POST";
                break;
            case "Edit":
                urlx = "customers/" + idx;
                method = "PUT";
                break;
            case "Hapus":
                urlx = "customers/" + idx;
                method = "DELETE";
                break;
        }
    }


    // buat username dan password

    form_isian.on("input", (nama_usaha, nama_customer), function(){
        let tipe_cust = $('input[name=tipe_cs]:checked', "#form_customer").val();

        let nm_usaha = nama_usaha.val().toLowerCase();
        let nm_cust = nama_customer.val().toLowerCase();
        if (tipe_cust == "1" || tipe_cust == "2") {
            // Distributor & Store - username
            nama_usaha.removeClass("ignore")
            nama_usaha.prop("disabled", false)
            username.val(nm_usaha.split(" ").join("."));
        } else {
            // Customer - username
            nama_usaha.addClass("ignore")
            nama_usaha.prop("disabled", true)
            username.val(nm_cust.split(" ").join("."));
        }
        nama_usaha.val(nm_usaha.toUpperCase());
        nama_customer.val(nm_cust.toUpperCase());
    })

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

    form_isian.validate({
        ignore: ".ignore",
        rules: {
            nama_usaha: { required: true, minlength: 8 },
            nama_customer: { required: true, minlength: 8 },
            alamat: { required: true, minlength: 20 },
            telpon: { required: true, minlength: 10, maxlength: 15 },
            kota: { required: true },
            username: {
                required: true,
                minlength: 8,
                // remote: {
                //     url: "satuans/cekTipe",
                //     type: "post",
                //     dataType: "json",
                //     // success: function(resp){
                //     //     console.log(resp);
                //     // }
                // },
            },

            // email: { required: true, email: true },
            // password: { required: true, minlength: 6 },
        },

        messages: {
            nama_usaha: {
                required: "Wajib di-isi",
                minlength: $.validator.format("Min. {0} karakter")
            },
            nama_customer: {
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
                maxlength: $.validator.format("Min. {0} karakter")
            },
            kota: { required: "Wajib di-isi" },
            username: {
                required: "Wajib di-isi",
                minlength: $.validator.format("Min. {0} karakter")
            },
            email: {
                required: "Wajib di-isi",
                email: "Format Email tidak valid"
            },
            // password: {
            //     required: "Wajib di-isi",
            //     minlength: $.validator.format("Min. {0} karakter")
            // },
        },

        submitHandler: function (form) {
            //ajax nota
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
                    // reset
                    formChange(false);
                    modal_formCS.toggle();
                    mynotife(pesan, "Simpan Data", isi);

                },
                error: showError,
            });
        },
    });

    /**
     * run start js
     */
     formChange(false);

});
