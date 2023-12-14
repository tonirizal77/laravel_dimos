$(function () {
    ("use strict");

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    $("button.upload-image").on("click", function (e) {
        $("form#form_product").ajaxForm(options);
    });

    var options = {
        complete: function (response) {
            console.log(response);
            if ($.isEmptyObject(response.responseJSON.error)) {
                $(".print-img").css("display", "block");
                $(".print-img")
                    .find("img")
                    .attr("src", "/gambar/" + response.responseJSON.gambar);

                alert("Upload gambar berhasil.");
            } else {
                printErrorMsg(response.responseJSON.error);
            }
        },

        // target: "#output1", // target element(s) to be updated with server response
        // beforeSubmit: validate,

        // success: function(ss){
        //     alert(ss)
        // }, // post-submit callback

        // other available options:
        url: "products", // override for form's 'action' attribute
        type: "post", // 'get' or 'post', override for form's 'method' attribute
        dataType:  'json',   // 'xml', 'script', or 'json' (expected server response type)
        clearForm: true, // clear all form fields after successful submit
        resetForm: true, // reset the form after successful submit
    };

    function printErrorMsg(msg) {
        $(".print-error-msg").find("ul").html("");
        $(".print-error-msg").css("display", "block");
        $.each(msg, function (key, value) {
            $(".print-error-msg")
                .find("ul")
                .append("<li>" + value + "</li>");
        });
    }

    function validate(formData, jqForm, options) {
        // formData is an array of objects representing the name and value of each field
        // that will be sent to the server;  it takes the following form:
        //
        // [
        //     { name:  username, value: valueOfUsernameInput },
        //     { name:  password, value: valueOfPasswordInput }
        // ]
        //
        // To validate, we can examine the contents of this array to see if the
        // username and password fields have values.  If either value evaluates
        // to false then we return false from this method.

        for (var i = 0; i < formData.length; i++) {
            if (!formData[i].value) {
                alert("Please enter a value for both Username and Password");
                return false;
            }
        }
        alert("Both fields contain values.");
    }

    // $.validator.setDefaults({
    //     submitHandler: function () {
    //         alert("Form successful submitted!");
    //     },
    // });

    $("form#form_product").validate({
        rules: {
            judul: { required: true },
            gambar: { required: true },
        },
        messages: {
            judul: { required: "Judul wajib diisi" },
            gambar: { required: "Gambar wajib di pilih" },
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

})
