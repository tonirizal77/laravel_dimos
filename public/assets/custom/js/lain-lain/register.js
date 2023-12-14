$(function () {
    ("use strict");

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    let setuju = "";
    let btn_create = $("button#btn-create");
    let form_register = $("form#register");
    $("#setuju").on("change", function(){
        setuju = $('input#setuju:checked', "#register").val();
        if (setuju === "on") {
            btn_create.prop("disabled", false);
        } else {
            btn_create.prop("disabled", true);
        }
    });

    btn_create.on("click", function(){
        form_register.submit();
    })

    form_register.enterAsTab({ allowSubmit: false });

    $('#username').on("keydown", function(e){
        if (e.which === 32)
        return false;
    }).on("keyup", function(){
        this.value = this.value.toLowerCase();
    }).on('change',function() {
        this.value = this.value.replace(/\s/g, "");
    })

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

    form_register.validate({
        ignore: ".ignore",
        rules: {
            nama_usaha: { required: true, minlength: 8 },
            password: { required: true, minlength: 6 },
            username: {
                required: true,
                minlength: 6,
                maxlength: 20,
                remote: {
                    url: "cekDataUser",
                    type: "post",
                    dataType: "json",
                    // success: function(resp){
                    //     console.log(resp);
                    // }
                },
            },
            email: {
                required: true,
                email: true,
                remote: {
                    url: "cekDataUser", //CustomerController
                    type: "post",
                    dataType: "json",
                    // success: function(resp){
                    //     console.log(resp);
                    // }
                },
            },
        },

        messages: {
            nama_usaha: {
                required: "Wajib di-isi, min. 8 chr",
                minlength: $.validator.format("Min. {0} karakter")
            },
            username: {
                required: "Wajib di-isi, 6-10 chr",
                minlength: $.validator.format("Min. {0} karakter"),
                maxlength: $.validator.format("Max. {0} karakter"),
                remote: "Username sudah ada."
            },
            email: {
                required: "Wajib di-isi",
                email: "Format Email tidak valid",
                remote: "Email ini sudah ada."
            },
            password: {
                required: "Wajib di-isi",
                minlength: $.validator.format("Min. {0} karakter")
            },
        },

        submitHandler: function (form) {
            //ajax nota
            $.ajax({
                url: "register",
                method: "post",
                dataType: "json",
                data: $(form).serialize(),
                success: function (resp) {
                    console.log(resp);
                    // return false;

                    let pesan = resp.info.pesan;
                    let isi = resp.info.isi_pesan;
                    mynotife(pesan, "Pendaftaran Sukses", isi);
                    setTimeout(pageRedirect(), 100000);
                },
                error: function(err){
                    console.log(err);
                },
            });
            return false;
        },
    });

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

    function pageRedirect() {
        // var pathname = window.location.pathname; // Returns path only (/path/example.html)
        // var url      = window.location.href;     // Returns full URL (https://example.com/path/example.html)
        var origin      = window.location.origin;   // Returns base URL (https://example.com)
        window.location.replace(origin+"/login");
    }
});
