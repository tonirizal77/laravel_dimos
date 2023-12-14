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

    //"en-US"
    //"id-ID"
    //format utk convert string to number

    const rupiah = new Intl.NumberFormat("en-US", {
        // style: "currency",
        // currency: "IDR",
        minimumFractionDigits: 0,
    });

    // bsCustomFileInput.init();

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

    let pilih_bayar = $("input[name='opsi_durasi']");
    let pilih_paket = $('input[name=pilih_paket]');

    let biaya, paketId, paketName, durasi; //global scope

    let tabel_orders = $('table#tabel_orders tbody');

    let urlx, method, action, idusaha, usaha;
    let cek_ganti_logo = false;

    let btn_buat = $("button#btn_buat");
    let btn_edit = $("button#btn_edit");
    let btn_action = $("#btn_action");
    let btn_listPaket = $('#listpakets');

    let kota_id = $('a.kota').attr('data-kota');

    let btn_ganti = $('#btn_action_logo');
    let label_ganti = $('#label_ganti');
    let img_ganti = $('input#ganti_logo');
    let image_logo = $("input#inputFile");
    let getFile, cloneLogo;

     // AjaxForm for option setting
    let progress_bar = $('#progress_animation');
    progress_bar.hide();

    let opsi_logo = {
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

            let info = resp.pesan;
            let isi_pesan = info.ket;
            let teks = "";

            isi_pesan.forEach(elm => {
                teks = teks + `<li>`+elm+`</li>`
            });
            teks = `<ol class="pl-3">`+teks+`</ol>`

            if (info.status == "error") {
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
                btn_ganti.html("");
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

    function formLogo_change(xform) {
        if (xform) {
            form_logo.attr("action", "profile-toko/"+idusaha);
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

    let btn_lanjut = $('button#btn_lanjut');
    btn_lanjut.on('click', function(){
        if (usaha !=null) {
            buat_order();
        } else {
            mynotife(
                'error',
                'Data Usaha',
                'Data Usaha Belum Tersedia, Buat Toko Lebih dahulu.'
            )
        }
        // cek menggunakan attr checked
        // let cek_paket = $("input[name='pilih_paket'][checked]");
        // let cek_bayar = $("input[name='opsi_durasi'][checked]");

        // console.log("Paket ID: "+paketId);
        // console.log("Durasi: "+durasi)
        // console.log("biaya: "+biaya)

        // console.log("cek menggunakan attr-checked");
        // console.log("Paket ID : "+cek_paket.val());
        // console.log("Paket : "+cek_paket.attr('id'));
        // console.log("Durasi: "+cek_bayar.val()+" Bulan");

        // cek menggunakan prop checked
        // let cek_paket2 = pilih_paket.is("checked");
        // let cek_bayar2 = pilih_bayar.is(":checked");
        // console.log("cek menggunakan prop-checked");
        // console.log(cek_paket2);
        // console.log(cek_paket2);
        // console.log("2-Durasi: "+cek_bayar2+" Bulan");
    })

    pilih_paket.on('change', function(){
        // checked opsi-paket
        pilih_paket.removeAttr("checked");
        $(this).attr("checked", true);
        $(this).prop("checked", true);

        // checked opsi-bayar
        let obsibayar_id = $('input#'+$(this).attr('data-bayarid'))
        pilih_bayar.removeAttr("checked");
        obsibayar_id.attr("checked", true)
        obsibayar_id.prop("checked", true);
        obsibayar_id.trigger('change'); //call elm

        $('.box-nilai-paket').removeAttr('style');
        $(this).closest('div').find('.box-nilai-paket').css({'background-color':'#ffd865','color':'black'});
        btn_lanjut.prop("disabled", false);
    });

    pilih_bayar.on("change", function(){
        // $("#radio_1").is(":checked")
        // checked opsi-bayar
        pilih_bayar.removeAttr("checked");
        $(this).attr("checked", true);
        $(this).prop("checked", true);

        let obsibayar_id = $(this).attr('id');
        let paket = $(this).attr('data-paket');
        // save valut to global variable
        durasi = $(this).val();
        paketId = $(this).attr('data-paketid');
        biaya = $(this).attr('data-harga');
        paketName = paket;

        // checked opsi-paket + update opsi-bayar
        let opsipaket_id = $('input#'+paket);
        pilih_paket.removeAttr("checked")
        opsipaket_id.attr("checked", true);
        opsipaket_id.prop("checked", true);
        opsipaket_id.attr('data-bayarid', obsibayar_id);

        $('.box-nilai-paket').removeAttr('style');
        let box_harga = $(this).closest('div.opsi-bayar')
        box_harga.find('.nilai-paket').text(rupiah.format(biaya))
        box_harga.find('.durasi-paket').text('/'+durasi+' bln');
        box_harga.find('.box-nilai-paket').css({'background-color':'#ffd865','color':'black'});

        console.log("Paket: "+ paketId+"/"+paket);
        console.log("Bayar: "+ obsibayar_id+'/'+durasi);
        console.log("Harga: "+rupiah.format(biaya));

        btn_lanjut.prop("disabled", false);
    });

    // Update Status Toko/Usaha ->#info_status
    $('body')
    .on('click','button#btn_berbayar', function(){
        btn_listPaket.css('display','block');
        $('a[href="#pakets"]').trigger('click');
        // prosesPaymentGateway();
    })
    .on('click','button#btn_gratis', function(){
        updateStatus('1',1);
    })
    .on('click','button#btn_bayar', function(){
        let token = $(this).attr('data-token')
        let orderNo = $(this).attr('data-orderno')
        let orderId = $(this).attr('data-orderid')
        // SnapToken acquired from previous step
        snap.pay(token, {
            // Optional
            onSuccess: function(result){
                /* You may add your own js here, this is just example */
                // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                console.log(result)

                let resp = JSON.stringify(result)
                console.log(resp);

                $(document).Toasts('create', {
                    class: 'bg-success',
                    title: 'Proses Payment Sukses',
                    position: 'bottomRight',
                    subtitle: 'Simpan Data',
                    icon: 'fas fa-frown',
                    body: 'Terimaksih atas pembayarannya.',
                })

                saveHistoryPayment(orderNo, result);
            },
            // Optional
            onPending: function(result){
                /* You may add your own js here, this is just example */
                // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                console.log(result)

                let resp = JSON.stringify(result)
                console.log(resp);

                $(document).Toasts('create', {
                    class: 'bg-success',
                    title: 'Proses Payment Sukses',
                    position: 'bottomRight',
                    subtitle: 'Proses Payment Sukses',
                    icon: 'fas fa-frown',
                    body: '<center>Lanjutkan Pembayaran Sesuai<br>Instruksi pada halaman payment</center>',
                })

                saveHistoryPayment(orderNo, result);
            },
            // Optional
            onError: function(result){
                /* You may add your own js here, this is just example */
                // document.getElementById('result-json').innerHTML += JSON.stringify(result);
                console.log(result)

                let resp = JSON.stringify(result)
                console.log(resp);

                $(document).Toasts('create', {
                    class: 'bg-danger',
                    title: 'Proses Payment Gagal',
                    position: 'bottomRight',
                    subtitle: 'Ada Kesalahan',
                    icon: 'fas fa-frown',
                    body: result.status_message,
                });

                saveHistoryPayment(orderNo, result);
            },
            // Optional
            onClose: function(){
            /* You may add your own implementation here */
                alert('You closed the popup without finishing the payment');
                setTimeout(function(){
                    location.reload(); // reload halaman
                }, 1000);
            }
        });
    });

    /**
     * Function
     */
    // buat object Date dan convert yyyy-mm-dd to dd-mm-yyyy
    // var newdate1 = tgl1.split("-").reverse().join("-");
    function saveHistoryPayment(orderNo, result) {
        $.ajax({
            url: 'history-payment',
            method: 'post',
            data: {
                orderNo: orderNo,
                result: JSON.stringify(result, null, 2),
            },
            success: function(resp){
                mynotife(resp.pesan.tipe,'Simpan History' ,resp.pesan.info )

                // setTimeout(function(){
                //     location.reload(); // reload halaman
                // }, 2000);
            }
        });
        return false;
    }

    // Convertion date (yyyy-mm-dd) to dd-mm-yyyy
    function dateIndo(tanggal, yearDigits, spr) {
        let cTgl = new Date(tanggal); //new Date(2021,11,01) -- year, month(0-11), and day
        let dd = String(cTgl.getDate()).padStart(2, "0");
        let mm = String(cTgl.getMonth() + 1).padStart(2, "0"); //January is 0!
        let yyyy = cTgl.getFullYear();

        let s = spr != null ? spr : "-";

        if (yearDigits == 2) {
            cTgl = dd + s + mm + s + cTgl.getFullYear().toString().substr(-2);
        } else {
            cTgl = dd + s + mm + s + yyyy;
        }

        return cTgl;
    }
    function dateTimeIndo(tanggal, yearDigits, spr) {
        let dt = new Date(tanggal);

        let jam = String(dt.getHours()).padStart(2,"0");
        let menit = String(dt.getMinutes()).padStart(2,"0");
        let detik = String(dt.getSeconds()).padStart(2,"0");
        let timeNow = jam + ":" + menit + ":" + detik;

        let dd = String(dt.getDate()).padStart(2, "0");
        let mm = String(dt.getMonth() + 1).padStart(2, "0"); //January is 0!
        let yyyy = dt.getFullYear();

        let s = spr != null ? spr : "-";

        if (yearDigits == 2) {
            dt = dd + s + mm + s + dt.getFullYear().toString().substr(-2);
        } else {
            dt = dd + s + mm + s + yyyy;
        }

        return dt +' - '+ timeNow;
    }

    function hitungSelisihHari(tgl1, tgl2) {
        // varibel miliday sebagai pembagi untuk menghasilkan hari
        let miliday = 24 * 60 * 60 * 1000;

        // buat object Date dan convert dd/mm/yyyy to yyyy-mm-dd
        // let newdate1 = tgl1.split("/").reverse().join("-");
        // let newdate2 = tgl2.split("/").reverse().join("-");
        // let tanggalx = new Date(newdate1);
        // let tanggaly = new Date(newdate2);

        // not convert
        let tanggalx = new Date(tgl1);
        let tanggaly = new Date(tgl2);

        /**
         * Date.parse akan menghasilkan nilai bernilai
         * integer dalam bentuk milisecond/miliday
         */
        let tglPertama = Date.parse(tanggalx);
        let tglKedua = Date.parse(tanggaly);
        let selisih = (tglKedua - tglPertama) / miliday;
        return selisih;
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
                            `<button class="btn btn-xs btn-outline-warning mr-2" id="btn_gratis">Aktifkan Paket Gratis</button>
                            <button class="btn btn-xs btn-outline-success" id="btn_berbayar">Aktifkan Paket Berbayar</button>`
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
                        $('img#previewImg').attr('src', (usaha.logo != null) ? '/profile/' + usaha.logo : '/assets/ui_admin/dist/img/logo_175x75.png');

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

    let percentage = 0;
    function updateStatus(status, paket) {
        $.ajax({
            url: 'update-status-toko/'+idusaha,
            method: 'post',
            data: {status:status, paket:paket},
            beforeSend: function(){

                // cek status paket dan pembayaran

                progress_bar.css('display', 'flex'); //munculkan

                // Proses real progress at here
                let timer = setInterval(function(){
                    percentage = percentage + 5;
                    progress_bar_process(percentage, timer);
                    // console.log("BeforeSend : "+percentage);
                }, 1000);

                // $('#percent_bar').text(percentage + "%");
            },
            success: function(resp) {
                console.log(resp);

                let info = resp.pesan;
                let isi_pesan = info.ket;
                let teks = "";

                isi_pesan.forEach(elm => {
                    teks = teks + `<li>`+elm+`</li>`
                });
                teks = `<ol class="pl-3">`+teks+`</ol>`

                // mynotife(info.status, "Ada Kesalahan", teks);
                $(document).Toasts('create', {
                    class: (info.status == "success") ? 'bg-success' : 'bg-danger',
                    title: (info.status == "success") ? 'Berhasil' : 'Ada Kesalahan',
                    position: 'bottomRight',
                    subtitle: 'Simpan Data',
                    icon: 'fas fa-frown',
                    body: teks,
                })

                if (info.status === "success") {
                    $('#percent_bar').text("100%");
                    $('#title_progress').text('Mohon Menunggu')
                    $('#status_progress').text('Proses Reload Halaman...')
                    $('#progress-box').addClass('bg-gradient-success')
                    setTimeout(function(){
                        // console.log("Reload : "+percentage);
                        location.reload(); // reload halaman
                    }, 5000);
                }
            }
        })
        return false;
    }

    function progress_bar_process(percentage, timer) {
        $('#percent_bar').text(percentage + '%');
        if(percentage >= 100) {
            // selesai..
            clearInterval(timer);
            $('#percent_bar').text("100%");
            $('#title_progress').text('Proses Selesai')
            $('#status_progress').text('Toko Berhasil di-Aktifkan.')
            setTimeout(function(){
                // $('#success_message').html('');
                console.log('selesai...')
            }, 1000);
        }
    }

    // function progress_bar_process(percentage, timer) {
    //     $('.progress-bar').css('width', percentage + '%');
    //     if(percentage > 100) {
    //         clearInterval(timer);
    //         $('#sample_form')[0].reset();
    //         $('#process').css('display', 'none');
    //         $('.progress-bar').css('width', '0%');
    //         $('#save').attr('disabled', false);
    //         $('#success_message').html("<div class='alert alert-success'>Data Saved</div>");

    //         setTimeout(function(){
    //             $('#success_message').html('');
    //         }, 5000);
    //     }
    // }

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
                urlx = "profile-toko";
                method = "POST";
                break;
            case "edit":
                urlx = "profile-toko/" + idx;
                method = "POST";
                $("#method").replaceWith(
                    `<input type="hidden" name="_method" value="PUT" id="method">`
                );
                break;
        }
        form_toko.attr("action", urlx);
        form_toko.attr("method", method);
    }

    function buat_order() {
        $.ajax({
            url: "orders",
            method: "post",
            data: {
                paketId : paketId,
                paketName : paketName,
                durasi : durasi,
                biaya : biaya,
            },
            success: function(resp){
                console.log(resp)
                // return false;

                let pesan = resp.pesan;
                let status = pesan.status;
                let teks = pesan.ket;
                mynotife(status, "Buat Order", teks);
                loadOrderPaket()
                $('a[href="#list-order"]').trigger('click');
                $('#btn_berbayar').prop('disabled', true);
                $('#listpakets').hide();
            },
            error: function(err){
                console.log(err)
            }
        });
        return false;
    }

    function loadAkunUsaha() {
        $.ajax({
            url: "load-akuns-toko",
            method: "get",
            success: function(resp){
                console.log(resp)
                const akun = resp.akun;
                if (akun != null) {

                    let today = new Date(); //moment().format("YYYY-MM-DD");
                    let durasi_hari = hitungSelisihHari(akun.start_date, akun.expire_date);
                    let sisa_hari = hitungSelisihHari(today, akun.expire_date);
                    const status_akun = (akun.status == '1') ? "Active" : (akun.status == '2') ? "Pending" : "Non-Active";

                    $('#box_akun').html(
                        `<div class="row">
                            <div class="col-md-4 col-sm-12">
                                <div class="text-center ">
                                    <img  class="gambar_akun" src="/assets/custom/gambar/`+akun.gambar+`" alt="logo-paket">
                                </div>
                            </div>
                            <div class="col-md-8 col-sm-12">
                                <table class="table table-borderless" id="tabel_akun">
                                    <tr>
                                        <td>Paket</td>
                                        <td style="width: 3%">:</td>
                                        <td class="kuning" id="info-akun"> Paket `+akun.nama_paket+`</td>
                                    </tr>
                                    <tr>
                                        <td>Status</td>
                                        <td style="width: 3%">:</td>
                                        <td class="kuning"><span id="info-status">`+status_akun+`</span></td>
                                    </tr>
                                    <tr>
                                        <td>Tanggal</td>
                                        <td style="width: 3%">:</td>
                                        <td class="kuning"><span id="info-tanggal">`+dateTimeIndo(akun.created_at)+`</span></td>
                                    </tr>
                                    <tr>
                                        <td>Masa Aktif</td>
                                        <td style="width: 3%">:</td>
                                        <td class="kuning">
                                            <span>`+durasi_hari+` Hari</span><br>
                                            <span>(`+dateIndo(akun.start_date)+` s/d `+dateIndo(akun.expire_date)+`)</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Sisa Aktif</td>
                                        <td style="width: 3%">:</td>
                                        <td class="kuning"><span>`+sisa_hari.toFixed(0)+` Hari</span></td>
                                    </tr>
                                </table>
                            </div>
                        </div>`
                    );

                } else {
                    $('#box_akun').html(
                        ` <div class="text-center">
                            <div class="">Akun Usaha Belum Tersedia</div>
                            <img src="`+'/assets/custom/gambar/kartun-2.png'+`" alt="akun-logo">
                        </div>`
                    );
                }
            }
        });
        return false;
    }

    function loadOrderPaket() {
        $.ajax({
            url: "orders",
            method: "get",
            success: function(resp){
                console.log(resp)
                let order = resp.orders;
                if (order.length == 0) {
                    tabel_orders.html(`<tr><td colspan="9" class="text-center">Data Order Belum Tersedia</td></tr>`)
                } else {
                    // if (usaha.status_order == 0 && order[0].status == "2"){
                    //     console.log('status order last: ', order[0])
                    //     $('#btn_berbayar').prop('disabled', true)
                    //     btn_listPaket.css('display','none');
                    // }
                    // Looping orders
                    tabel_orders.html('')
                    let no = 1;
                    for (let i = 0; i < order.length; i++) {
                        const el = order[i];

                        let status_order, status_payment, aksi;
                        let warna_status, warna_payment;
                        let durasi2hari = (el.durasi > 12 ? el.durasi : el.durasi * 30.42);
                        // let today = new Date(); //moment().format("YYYY-MM-DD")
                        // let sisa_hari = hitungSelisihHari(today, el.expire_date);
                        // let durasi_hari = hitungSelisihHari(el.start_date, el.expire_date);

                        // setting default
                        if (el.order_status == "1"){
                            warna_status = 'badge-warning';
                            status_order = 'Menunggu';
                            aksi = `<div class="p-2">
                                        <button class="btn btn-xs btn-outline-info mr-1" id="btn_bayar" data-orderno="`+el.order_no+`" data-orderid="`+el.id+`" data-token="`+el.snap_token+`">Bayar Sekarang</button>
                                        <button class="btn btn-xs btn-outline-danger">Batalkan</button>
                                    </div>`
                        } else if (el.order_status == "2"){
                            warna_status = 'badge-success';
                            status_order = 'Selesai';
                            aksi = "Selesai";
                        } else if (el.order_status == "3"){
                            warna_status = 'badge-danger';
                            status_order = 'Batal';
                            aksi = "Batal";
                        }

                        if (el.payment_status == "1"){
                            warna_payment = 'badge-warning';
                            status_payment = 'Menunggu';
                        } else if (el.payment_status == "2"){
                            warna_payment = 'badge-success';
                            status_payment = 'Sudah Bayar';
                        } else if (el.payment_status == "3"){
                            warna_payment = 'badge-danger';
                            status_payment = 'Batal';
                        } else {
                            warna_payment = 'badge-info';
                            status_payment = 'Kadaluarsa';
                        }

                        let row = `
                        <tr>
                            <td class="text-center">`+no+`</td>
                            <td class="text-center `+warna_status+`">
                                <span>Paket `+el.paket.name+`</span>
                                <div>
                                    <img class="img-circle" style="width:75px;height:75px" src="/assets/custom/gambar/`+el.paket.gambar+`" alt="logo-paket">
                                </div>
                                <span>Rp. `+rupiah.format(el.total)+`</span>
                            </td>
                            <td class="text-center">`+el.order_no+`</td>
                            <td class="text-center"><span class="bagde badge-btn `+warna_status+`">`+status_order+`</span></td>
                            <td class="text-center"><span class="bagde badge-btn `+warna_payment+`">`+status_payment+`</span></td>
                            <td class="text-center">`+durasi2hari.toFixed(0)+` Hari </td>
                            <td class="text-center">Rp. `+rupiah.format(el.total)+`</td>
                            <td class="text-center">`+dateTimeIndo(el.created_at)+`</td>
                            <td class="text-center">
                                `+aksi+`
                            </td>
                        </tr>`;

                        no++;

                        tabel_orders.append(row)
                    }
                }
            },
            error: showError
        })
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

    function tanya(icon, title, content, switchConfirm) {
        Swal.fire({
            title: title,
            text: content,
            html: content,
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
                switch (switchConfirm) {
                    case "Payment-Success":
                        // $('#listpakets').css('display','block');
                        // $('a[href="#pakets"]').trigger('click');
                        $('button#btn_berbayar').prop('disabled', true)
                        break;
                    case "Payment-Failed":
                        // $('#listpakets').css('display','block');
                        // $('a[href="#pakets"]').trigger('click');
                        $('button#btn_berbayar').prop('disabled', false)
                        break;
                    default:
                        mynotife(
                            "error",
                            "Ada Kesalahan System",
                            "Confirm [" + switchConfirm + "] - Tidak Tersedia"
                        );
                }
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
    loadAkunUsaha();
    loadOrderPaket();
    btn_listPaket.css('display','none')
});

// function addZero(i) {
//     if (i < 10) {
//         i = "0" + i;
//     }
//     return i;
// }

// function getActualFullDate() {
//     var d = new Date();
//     var day = addZero(d.getDate());
//     var month = addZero(d.getMonth()+1);
//     var year = addZero(d.getFullYear());
//     var h = addZero(d.getHours());
//     var m = addZero(d.getMinutes());
//     var s = addZero(d.getSeconds());
//     return day + "-" + month + "-" + year + " (" + h + ":" + m + ")";
// }
// function getActualTime() {
//     var d = new Date();
//     var h = addZero(d.getHours());
//     var m = addZero(d.getMinutes());
//     var s = addZero(d.getSeconds());
//     return h + ":" + m + ":" + s;
// }

// function getActualDate() {
//     var d = new Date();
//     var day = addZero(d.getDate());
//     var month = addZero(d.getMonth()+1);
//     var year = addZero(d.getFullYear());
//     return day + "-" + month + "-" + year;
// }

// $(document).ready(function(){
//     $("#full").html(getActualFullDate());
//     $("#hour").html(getActualTime());
//     $("#date").html(getActualDate());
// });
