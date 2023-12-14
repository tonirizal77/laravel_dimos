$(function () {
    ("use strict");

    let progress_bar = $('#progress_animation');
    progress_bar.hide();

    /**
     * Set Button Function Trigger
     */

    // Update Status Toko/Usaha ->#info_status
    $('body').on('click','button#btn_create_data', createDataClient);

    /**
     * Function
     */

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

    // updata status toko (free paket)
    let percentage = 0;
    function createDataClient() {
        $.ajax({
            url: '/admin/create-dataclient',
            method: 'get',
            beforeSend: function(){
                // cek status paket dan pembayaran
                progress_bar.css('display', 'flex'); //munculkan
                // Proses real progress at here
                let timer = setInterval(function(){
                    percentage = percentage + 5;
                    progress_bar_process(percentage, timer);
                    // console.log("BeforeSend : "+percentage);
                }, 100);
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
});
