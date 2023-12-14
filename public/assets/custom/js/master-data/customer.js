$(function () {
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
    let provinsi = $("select#provinsi");
    let kota = $("select#kota");
    let alamat = $("textarea#alamat");

    let telpon = $("input#telpon");
    let email = $("input#email");
    let password = $("input#password");

    let urlx, method, action, idx;
    let kota_id = "";

    /**
     * Set Button Function Trigger
     */
    let btn_TambahData = $("button#btn_tambah")
    let btn_SimpanData = $("button#btn_simpan")
    let btn_EditData = $("button#btn_edit")
    let btn_Batal = $("button#btn_batal")

    let modal_formCS = new bootstrap.Modal(
        document.getElementById("modal_form_cs"),
        { keyboard: false, backdrop: "static"}
    );

    form_isian.enterAsTab({ allowSubmit: false });

    let tabelData = $("#tabel_customer tbody");
    let tabel_customer = $("#tabel_customer");
    let currRow = tabel_customer.find("tbody tr").first();
    let currCell = tabel_customer.find("tbody td").first();
    let cust_id = "";
    let data_backup;

    let input_filter = $('#filter_data')
    let btn_group = $('#btn_group')

    /**
     * Keyboard Navigation Table
     */
    tabel_customer
    .on("keydown", navigation)
    .on('click', 'td', function(){
        currCell = $(this);
        currRow = currCell.closest('tr');
        cust_id = currRow.attr('data-id');
        currCell.focus();
    })
    .on("dblclick", "td", function () {
        currCell = $(this);
        currRow = currCell.closest('tr');
        cust_id = currRow.attr('data-id');
        $("tr").removeClass("selected-row");
        currRow.addClass("selected-row");
        currCell.focus();
        getCustomer(cust_id);
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

    provinsi
    .on("change", function(){
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
                    }
                    kota.trigger("change");
                }
            }
        })
    }).change();

    // Button Function Modal Form Isian Data
    btn_TambahData
    .on("click", function () {
        action = "Tambah";
        idx = "",
        formAction(action, idx)
        formChange(true);
        modal_formCS.toggle();
    });

    btn_Batal
    .on("click",function(){
        form_validate.resetForm();
        username.removeClass("ignore");
        nama_usaha.removeClass("ignore");
        formChange(false);
        $("tr").removeClass("selected-row");
    })

    btn_SimpanData
    .on("click", function () {
        formAction(action, idx)
        // console.log("action: "+action,"idx: "+idx)
        // console.log("url: "+urlx,"method: "+method)
        form_isian.submit();
    });

    btn_EditData
    .on("click", function(){
        if (cust_id != "") {
            //ignore for remote validate
            $("tr").removeClass("selected-row");
            currRow.addClass("selected-row");
            getCustomer(cust_id);
        }
    });

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
                `<tr><td colspan="9" class="text-center">Product <span class="text-red text-bold"> " `+value+` " </span> Tidak Tersedia</td></tr>`
            );
            input_filter.focus();
        } else {
            currCell = tabelData.find("tbody td:eq(1)").first();
            currCell.focus()
        }
        $("#tot_rec").text(rupiah.format(tot_data));
    }

    /**
     * Function
     */

    // buat object Date dan convert yyyy-mm-dd to dd-mm-yyyy
    // var newdate1 = tgl1.split("-").reverse().join("-");

    function formChange(xform) {
        if (xform) {
            $("form#form_customer input").attr("disabled", false)
            $("form#form_customer textarea").attr("disabled", false)
        } else {
            // form_isian.trigger("reset"); // sebelum di disabled
            form_validate.resetForm();
            $("form#form_customer textarea").attr("disabled", true)
            $("form#form_customer input").attr("disabled", true);
        }
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

    function loadData() {
        $.ajax({
            url: "customers/load-data",
            type: "GET",
            dataType: "json",
            success: function (resp) {
                let data  = resp.data;

                let no = 1;
                if (data.length == 0) {
                    no = 0
                    tabelData.html(
                        `<tr><td colspan="9" class="text-center">Data Tidak Tersedia</td></tr>`
                    );
                } else {
                    tabelData.html("");
                    for (let i = 0; i < data.length; i++) {
                        let status = (data[i].active == 0) ? `<i class="nav-icon fas fa-circle text-danger"></i>` : `<i class="fas fa-circle nav-icon text-success"></i>`;

                        let sw_tipe_role = "";

                        if (data[i].role_id == "1") {
                            sw_tipe_role = "Admin"
                        } else if (data[i].role_id == "2") {
                            sw_tipe_role = "User";
                        } else if (data[i].role_id == "3") {
                            sw_tipe_role = "Kasir";
                        } else if (data[i].role_id == "4") {
                            sw_tipe_role = "Accounting";
                        } else {
                            sw_tipe_role = "Lain-lain";
                        }

                        let email = ((data[i].email == null || data[i].email == "") ? "-" : data[i].email);
                        let kota = ((data[i].kota == null || data[i].kota == "") ? "-" : data[i].kota);

                        let rowdata =
                            `<tr tabindex="`+no+`" data-id="`+data[i].id+`">
                                <td class="text-center">`+no+`</td>
                                <td tabindex="1" class="text-center username">`+data[i].username+`</td>
                                <td tabindex="2" class="name">`+data[i].name+`</td>
                                <td tabindex="3" class="text-center tipe">`+sw_tipe_role+`</td>
                                <td tabindex="4" class="text-center email">`+email+`</td>
                                <td tabindex="5" class="alamat">`+data[i].alamat+`</td>
                                <td tabindex="6" class="kota">`+kota+`</td>
                                <td tabindex="7" class="telpon">`+data[i].telpon+`</td>
                                <td tabindex="8" class="text-center status">`+status+`</td>
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

    function reload_data() {
        $.ajax({
            url: "customers/load-data",
            type: "GET",
            dataType: "json",
            success: function (resp) {
                let data  = resp.data;

                let no = 1;
                if (data.length == 0) {
                    data_backup.html(
                        `<tr><td colspan="9" class="text-center">Data Tidak Tersedia</td></tr>`
                    );
                } else {
                    data_backup.html("");
                    for (let i = 0; i < data.length; i++) {
                        let status = (data[i].active == 0) ? "Non-Active" : "Active";


                        let sw_tipe_role = "";

                        if (data[i].role_id == "1") {
                            sw_tipe_role = "Admin"
                        } else if (data[i].role_id == "2") {
                            sw_tipe_role = "User";
                        } else if (data[i].role_id == "3") {
                            sw_tipe_role = "Kasir";
                        } else if (data[i].role_id == "4") {
                            sw_tipe_role = "Accounting";
                        } else {
                            sw_tipe_role = "Lain-lain";
                        }

                        let rowdata =
                            `<tr tabindex="`+no+`" data-id="`+data[i].id+`">
                                <td class="text-center">`+no+`</td>
                                <td tabindex="1" class="text-center username">`+data[i].username+`</td>
                                <td tabindex="2" class="name">`+data[i].name+`</td>
                                <td tabindex="3" class="text-center tipe">`+sw_tipe_role+`</td>
                                <td tabindex="4" class="text-center email">`+data[i].email+`</td>
                                <td tabindex="5" class="alamat">`+data[i].alamat+`</td>
                                <td tabindex="6" class="kota">`+data[i].kota+`</td>
                                <td tabindex="7" class="telpon">`+data[i].telpon+`</td>
                                <td tabindex="8" class="text-center status">`+status+`</td>
                            </tr>`;

                        no++;
                        data_backup.append(rowdata);
                    }
                }
                $("#tot_rec").text(data.length);
            },
        });
    }

    function getCustomer(id){
        $.ajax({
            url: "customers/"+id+"/edit",
            method: "get",
            success: function(resp){
                console.log(resp);

                action = "Edit";
                idx = id,
                formAction(action, idx)
                formChange(true);

                kota_id = resp.cities_id;

                nama_customer.val(resp.name);
                username.val(resp.username);

                provinsi.val(resp.prov_id);
                provinsi.trigger("change");

                kota.val(resp.cities_id)
                kota.trigger("change");

                alamat.val(resp.alamat);
                telpon.val(resp.telpon);
                email.val(resp.email);

                if (resp.active) {
                    $("#active").iCheck("check");
                } else {
                    $("#non-active").iCheck("check");
                }

                // jika sudah aktif tidak bisa di-edit
                username.addClass("ignore")
                email.addClass("ignore")
                telpon.addClass("ignore")

                if (resp.status_usaha) {
                    username.prop("readonly", true);
                    email.prop("readonly", true)
                    telpon.prop("readonly", true)
                    password.prop("readonly", true)
                    $("#note").html("Customer ini, akun 'Toko'-nya sudah aktif")
                } else {
                    username.prop("readonly", false)
                    email.prop("readonly", false)
                    telpon.prop("readonly", false)
                    password.prop("readonly", false)
                }

                modal_formCS.toggle();
            },
            error: function(err){
                console.log(err);
            }
        })
    }

    function showError(err) {
        let result = err.responseJSON;
        let pesan = err.statusText;
        let isi_pesan = result.message;

        console.error();

        $(".form-errors").show();
        $(".form-errors").html(
            `<div class="alert alert-danger alert-dismissible" style="margin: 20px; padding:10px;" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="right:0px">
                    <span aria-hidden="true">&times;</span>
                </button>
                <span class="text-center"><strong>Error! [` + err.status + `]  </strong>` + pesan +
                    `<br>` + isi_pesan + `<br>` +
                `</span>
            </div>`
        );
        setTimeout(() => {
            $(".form-errors").hide();
        }, 5000);
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
            //Enter Key
            currRow = currCell.closest("tr");
            cust_id = $(currRow).attr("data-id");
            $("tr").removeClass("selected-row");
            currRow.addClass("selected-row");
            getCustomer(cust_id);
        }

        if (c.length > 0) {
            currCell = c;
            currRow = currCell.closest("tr");
            currCell.focus();
            cust_id = currRow.attr("data-id");
            // currRow.focus();
            // data_cell = currRow.find("td");
        }
    };

    // Convertion string to Number/Double(float)
    function toNumber(string) {
        return parseInt(string.split(",").join(""));
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

    let form_validate = form_isian.validate({
        ignore: ".ignore",
        rules: {
            nama_customer: { required: true, minlength: 3 },
            alamat: { required: true, minlength: 10 },
            kota: { required: true },
            password: { required: true, minlength: 6 },
            username: {
                required: true,
                minlength: 6,
                maxlength: 10,
                remote: {
                    url: "customers/cekDataUser",
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

                    let data = resp.data;
                    let pesan = resp.info.pesan;
                    let isi = resp.info.isi_pesan;
                    // reset
                    formChange(false);

                    modal_formCS.toggle();
                    mynotife(pesan, "Simpan Data", isi);

                    let sw_tipe_role = "";

                    if (data.role_id == "1") {
                        sw_tipe_role = "Admin"
                    } else if (data.role_id == "2") {
                        sw_tipe_role = "User";
                    } else if (data.role_id == "3") {
                        sw_tipe_role = "Kasir";
                    } else if (data.role_id == "4") {
                        sw_tipe_role = "Accounting";
                    } else {
                        sw_tipe_role = "Staff";
                    }

                    // let status = (data.active == 0) ? "Non-Active" : "Active";
                    let status = (data.active == 0) ? `<i class="nav-icon fas fa-circle text-danger"></i>` : `<i class="fas fa-circle nav-icon text-success"></i>`;

                    if (action == "Tambah") {
                        let no = toNumber($('#tot_rec').text()) + 1
                        $('#tot_rec').text(rupiah.format(no))
                        let rowdata =
                        `<tr tabindex="`+no+`" data-id="`+data.id+`">
                            <td class="text-center">`+no+`</td>
                            <td tabindex="1" class="text-center username">`+data.username+`</td>
                            <td tabindex="2" class="name">`+data.name+`</td>
                            <td tabindex="3" class="text-center tipe">`+sw_tipe_role+`</td>
                            <td tabindex="4" class="text-center email">`+data.email+`</td>
                            <td tabindex="5" class="alamat">`+data.alamat+`</td>
                            <td tabindex="6" class="kota">`+data.kota+`</td>
                            <td tabindex="7" class="telpon">`+data.telpon+`</td>
                            <td tabindex="8" class="text-center status">`+status+`</td>
                        </tr>`;
                        tabelData.append(rowdata);
                        data_backup.append(rowdata);

                        let cell = currCell.parent().parent().find('tr').last().find("td:eq(" + currCell.index() + ")");
                        currCell = cell;
                        currRow = currCell.closest('tr');
                        currRow.focus();
                    } else {
                        let cell = currRow.find('td');
                        $(cell[1]).text(data.username);
                        $(cell[2]).text(data.name);
                        $(cell[3]).text(sw_tipe_role);
                        $(cell[4]).text(data.email);
                        $(cell[5]).text(data.alamat);
                        $(cell[6]).text(data.kota);
                        $(cell[7]).text(data.telpon);
                        $(cell[8]).html(status);

                        currRow.removeClass('selected-row')
                        currRow.focus();

                        reload_data();
                    }
                },
                error: showError,
            });
        },
    });

    /**
     * run start js
     */
     formChange(false);
     loadData();

});
