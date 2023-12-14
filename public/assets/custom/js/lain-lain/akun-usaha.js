$(function () {
    ("use strict");

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        },
    });

    /**
     * setting UI
     */
    //format utk convert string to number
    const rupiah = new Intl.NumberFormat("en-US", {
        // style: "currency",
        // currency: "IDR",
        minimumFractionDigits: 0,
    });

    /**
     * set varibel foam
     */

    let pilih_bayar = $("input[name='opsi_durasi']");
    let pilih_paket = $('input[name=pilih_paket]');

    let biaya, paketId, paketName, durasi; //global scope

    let tabel_orders = $('table#tabel_orders tbody');

    let btn_listPaket = $('#listpakets');

     // AjaxForm for option setting
    let progress_bar = $('#progress_animation');
    progress_bar.hide();

    /**
     * Set Button Function Trigger
     */

    let btn_lanjut = $('button#btn_lanjut');
    btn_lanjut.on('click', function(){

        buat_order();

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
    })
    .on('click','button#btn_gratis', function(){
        let id = $(this).attr('data-idusaha');
        updateStatus('1', 1, id);
    })
    .on('click','button#btn_bayar', function(){
        let token = $(this).attr('data-token')
        let orderNo = $(this).attr('data-orderno')
        let orderId = $(this).attr('data-orderid')
        // SnapToken acquired from previous step
        // snap.pay(token, optionResultPayment);
        console.log('token:', token, 'orderNo:', orderNo, 'orderId', orderId)
        snap.pay(token, optionResultPayment);
    })
    .on('click','button#btn_detail', function(){
        let orderNo = $(this).attr('data-orderno')
        redirect(`/payment/finish?order_id=`+orderNo);
    });

    /**
     * Function
     */

    let optionResultPayment = {
        // Optional
        onSuccess: function(result){
            /* You may add your own js here, this is just example */
            // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
            console.log(result)

            // let resp = JSON.stringify(result)
            // console.log(resp);

            $(document).Toasts('create', {
                class: 'bg-success',
                title: 'Proses Payment Sukses',
                position: 'bottomRight',
                subtitle: 'Simpan Data',
                icon: 'fas fa-frown',
                body: 'Terimaksih atas pembayarannya.',
            })

            saveHistoryPayment(result.order_id, result);
        },
        // Optional
        onPending: function(result){
            /* You may add your own js here, this is just example */
            // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
            console.log(result)

            $(document).Toasts('create', {
                class: 'bg-success',
                title: 'Proses Payment Sukses',
                position: 'bottomRight',
                subtitle: 'Proses Payment Sukses',
                icon: 'fas fa-frown',
                body: '<center>Lanjutkan Pembayaran Sesuai<br>Instruksi pada halaman payment</center>',
            })

            saveHistoryPayment(result.order_id, result);
        },
        // Optional
        onError: function(result){
            /* You may add your own js here, this is just example */
            // document.getElementById('result-json').innerHTML += JSON.stringify(result);
            console.log(result)
            $(document).Toasts('create', {
                class: 'bg-danger',
                title: 'Proses Payment Gagal',
                position: 'bottomRight',
                subtitle: 'Ada Kesalahan',
                icon: 'fas fa-frown',
                body: result.status_message,
            });

            saveHistoryPayment(result.order_id, result);
        },
        // Optional
        // onClose: function(){
        //     /* You may add your own implementation here */
        //     alert('You closed the popup without finishing the payment');
        //     // setTimeout(function(){
        //     //     location.reload(); // reload halaman
        //     // }, 1000);
        // }
    }

    // function ajaxGetToken(orderId, callback){
    //     let snapToken;
    //     // Request get token to your server & save result to snapToken variable
    //     // get data orderId
    //     $.ajax({
    //         url: 'orders/'+orderId,
    //         method: 'get',
    //         success: function(resp){
    //             console.log(resp)
    //             snapToken = resp.token;
    //             if(snapToken){
    //                 // success
    //                 callback(null, snapToken);
    //             } else {
    //                 // error
    //                 callback(new Error('Failed to Fetch snap token'), null);
    //             }
    //         }
    //     })
    // }

    // $('body').on('click', 'button#btn_bayar' , function() {
    //     let orderId = $(this).attr('data-orderid')
    //     // snap.show();
    //     ajaxGetToken(orderId, function(error, snapToken){
    //         if(error){
    //             snap.hide();
    //         } else {
    //             snap.pay(snapToken, optionResultPayment);
    //         }
    //     });
    // });


    function redirect(url) {
        var ua        = navigator.userAgent.toLowerCase(),
            isIE      = ua.indexOf('msie') !== -1,
            version   = parseInt(ua.substr(4, 2), 10);

        // Internet Explorer 8 and lower
        if (isIE && version < 9) {
            var link = document.createElement('a');
            link.href = url;
            document.body.appendChild(link);
            link.click();
        }
        // All other browsers can use the standard window.location.href (they don't lose HTTP_REFERER like Internet Explorer 8 & lower does)
        else {
            window.location.href = url;
        }
    }

    // buat object Date dan convert yyyy-mm-dd to dd-mm-yyyy
    // var newdate1 = tgl1.split("-").reverse().join("-");
    function saveHistoryPayment(orderNo, result) {
        $.ajax({
            url: 'history-payment',
            method: 'post',
            data: {
                orderNo: orderNo,
                result: JSON.stringify(result),
            },
            success: function(resp){
                let goto = resp.result.finish_redirect_url;
                let orderid = resp.result.order_id;

                mynotife(resp.pesan.tipe,'Simpan History' , resp.pesan.info )

                console.log(resp)

                setTimeout(function(){
                    // serverhosting
                    // redirect(goto)

                    //localhost
                    redirect(`/payment/finish?order_id=`+orderid);

                }, 3000);
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

    // updata status toko (free paket)
    let percentage = 0;
    function updateStatus(status, paket, id) {
        $.ajax({
            url: 'update-status-toko/'+id,
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
                // mynotife(info.status, "Ada Kesalahan", teks);
                $(document).Toasts('create', {
                    class: (info.status == "success") ? 'bg-success' : 'bg-danger',
                    title: (info.status == "success") ? 'Berhasil' : 'Ada Kesalahan',
                    position: 'bottomRight',
                    subtitle: 'Simpan Data',
                    icon: 'fas fa-frown',
                    body: info.ket,
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
                console.log('buat order:',resp)
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
                const usaha = resp.usaha;

                if (akun != null) {
                    let today = new Date(); //moment().format("YYYY-MM-DD");
                    let durasi_hari = hitungSelisihHari(akun.start_date, akun.expire_date);
                    let sisa_hari = hitungSelisihHari(today, akun.expire_date);
                    const status_akun = (akun.status == '1') ? "Active" : (akun.status == '2') ? "Pending" : "Non-Active";

                    $('#card-akun').addClass(akun.paket.warna_header)
                    $('#box_akun').addClass(akun.paket.warna_body)
                    $('#box_akun').html(
                        `<div class="row">
                            <div class="col-12 justify-content-center">
                                <div class="box-akun-logo-akun">
                                    <div class="align-content-center">
                                        <img src="/assets/custom/gambar/`+akun.paket.gambar+`" alt="logo-paket">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <table class="table table-borderless" id="tabel_akun">
                                    <tr>
                                        <td>Paket</td>
                                        <td style="width: 3%">:</td>
                                        <td class="kuning" id="info-akun"> Paket `+akun.paket.name+`</td>
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

                    if (akun.status == '3'){
                        $('#action_paket').html(
                            `<div class="card-footer">
                                <div class="row col-12 justify-content-center">
                                    <button class="btn btn-xs btn-primary" id="btn_berbayar">Aktifkan Paket Berbayar</button>
                                </div>
                            </div>`
                        )
                    }
                } else {
                    $('#card-akun').addClass('bg-info')
                    $('#box_akun').addClass('bg-info')
                    $('#box_akun').html(
                        ` <div class="text-center">
                            <div class="">Akun Usaha Belum Tersedia</div>
                            <img src="`+'/assets/custom/gambar/kartun-2.png'+`" alt="akun-logo">
                        </div>`
                    );

                    $('#tabel_akuns tbody').html(`<tr><td colspan="7" class="text-center">Data Akun Belum Tersedia</td></tr>`);

                    //action_paket

                    // pindahkan ke atas action_paket
                    $('#action_paket').html(
                        `<div class="card-footer">
                            <div class="row col-12 justify-content-center">
                                <button class="btn btn-xs btn-warning mr-2" data-idusaha="`+usaha.id+`" id="btn_gratis">Aktifkan Paket Gratis</button>
                                <button class="btn btn-xs btn-primary" id="btn_berbayar">Aktifkan Paket Berbayar</button>
                            </div>
                        </div>`
                    );
                }

            },
            error: showError
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
                            status_order = 'Pending';
                        } else if (el.order_status == "2"){
                            warna_status = 'badge-success';
                            status_order = 'Selesai';
                            aksi = "Selesai";
                        } else if (el.order_status == "3"){
                            warna_status = 'badge-danger';
                            status_order = 'Batal';
                            aksi = "Batal";
                        }

                        if (el.payment_status == 0) {
                            warna_payment = 'badge-warning';
                            status_payment = 'Belum diproses';
                            aksi = `<div class="p-2">
                                    <button class="btn btn-xs btn-outline-danger mr-1"
                                        id="btn_bayar" data-token="`+el.snap_token+`"
                                        data-orderno="`+el.order_no+`"
                                        data-orderid="`+el.id+`">Proses Pembayaran</button>
                                </div>`
                        } else {
                            warna_payment = 'badge-info';

                            if (el.paket.id != 1) {
                                aksi = `<div class="p-2">
                                            <button class="btn btn-xs btn-outline-info mr-1" id="btn_detail" data-orderno="`+el.order_no+`">Detail Pembayaran</button>
                                        </div>`

                            } else {
                                aksi = '-'
                            }
                        }

                        if (el.payment_status == "1"){
                            warna_payment = 'badge-warning';
                            status_payment = 'Menunggu Pembayaran';
                        } else if (el.payment_status == "2"){
                            warna_payment = 'badge-success';
                            status_payment = 'Lunas';
                        } else if (el.payment_status == "3"){
                            warna_payment = 'badge-danger';
                            status_payment = 'Batal';
                        } else if (el.payment_status == "4") {
                            warna_payment = 'badge-danger';
                            status_payment = 'Kadaluarsa';
                        } else if (el.payment_status == "5") {
                            warna_payment = 'badge-danger';
                            status_payment = 'Ditolak';
                        }

                        let row = `
                        <tr>
                            <td class="text-center">`+no+`</td>
                            <td class="text-center `+el.paket.warna_body+`">
                                <span>Paket `+el.paket.name+`</span>
                                <div>
                                    <img style="width:120px;height:100px" src="/assets/custom/gambar/`+el.paket.gambar+`" alt="logo-paket">
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
     * run start js
     */
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


