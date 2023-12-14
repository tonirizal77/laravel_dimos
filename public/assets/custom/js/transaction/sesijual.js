$(
    (function ($) {
        ("use strict");

        /**
         * setting UI
         */
        //"en-US"
        //"id-ID"
        //format utk convert string to number
        const int2string_number = new Intl.NumberFormat("en-US", {
            // style: "currency",
            // currency: "IDR",
            minimumFractionDigits: 0,
        });

        $(".datemask").daterangepicker(
            {
                singleDatePicker: true,
                showDropdowns: true,
                autoApply: true,
                // timePicker: true,
                // timePicker24Hour: true,
                // ranges: {
                //     Today: [moment(), moment()],
                //     Yesterday: [
                //         moment().subtract(1, "days"),
                //         moment().subtract(1, "days"),
                //     ],
                //     "Last 7 Days": [moment().subtract(6, "days"), moment()],
                //     "Last 30 Days": [moment().subtract(29, "days"), moment()],
                //     "This Month": [
                //         moment().startOf("month"),
                //         moment().endOf("month"),
                //     ],
                //     "Last Month": [
                //         moment().subtract(1, "month").startOf("month"),
                //         moment().subtract(1, "month").endOf("month"),
                //     ],
                // },
                locale: {
                    format: "DD-MM-YYYY",
                    separator: " - ",
                    applyLabel: "OK",
                    cancelLabel: "Cancel",
                    fromLabel: "From",
                    toLabel: "To",
                    customRangeLabel: "Custom",
                    weekLabel: "W",
                    daysOfWeek: ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"],
                    monthNames: [
                        "January",
                        "February",
                        "March",
                        "April",
                        "May",
                        "June",
                        "July",
                        "August",
                        "September",
                        "October",
                        "November",
                        "December",
                    ],
                    firstDay: 1,
                },
                linkedCalendars: false,
                showCustomRangeLabel: true,
                alwaysShowCalendars: true,
                // startDate: "07-05-2021",
                // endDate: "14-05-2021",
            },
            function (start, end, label) {
                console.log(
                    "New date range selected: " +
                        start.format("YYYY-MM-DD") +
                        " to " +
                        end.format("YYYY-MM-DD") +
                        " (predefined range: " +
                        label +
                        ")"
                );
                console.log(tgl_nota.val());
            }
        );

        /**
         * Variabel Data Nota
         */
        let nomor_nota = $("input[name=nomor_nota]");
        let tgl_nota = $("input[name=tanggal]");
        let petugas = $("input[name=kasir_now]");

        /**
         * sesi penjualan
         */
        let sesijual = false;
        let kode_sesi = "";
        let tabel_SesiJual = $("#tabel_sesijual");
        let btn_SesiBaru = $("button#sesi_baru");
        let btn_BuatSesi = $("button#buat_sesi");
        let form_SesiBaru = $("form#sesi_baru");

        let modal_sesijual = new bootstrap.Modal(
            document.getElementById("modal_sesijual"),
            {
                keyboard: false,
                backdrop: "static",
            }
        );

        loadSesiJual();

        let modal_SesiBaru = new bootstrap.Modal(
            document.getElementById("modal-sesi-baru"),
            {
                keyboard: false,
                backdrop: "static",
            }
        );

        // Button Function Modal Buat Sesi Baru
        btn_SesiBaru.on("click", function () {
            modal_SesiBaru.toggle();
        });

        btn_BuatSesi.on("click", function () {
            form_SesiBaru.submit();
        });

        form_SesiBaru.validate({
            submitHandler: function (form) {
                //ajax nota
                $.ajax({
                    url: "sesi-penjualan",
                    method: "post",
                    dataType: "json",
                    data: $(form).serialize(),
                    success: function (resp) {
                        let data = resp.data;
                        let pesan = resp.info.pesan;
                        let isi = resp.info.isi_pesan;

                        kode_sesi = data.kode_sesi; //update sesi_kode

                        nomor_nota.val(data.kode_sesi + "-0001");
                        tgl_nota.val(dateIndo(data.tanggal));
                        petugas.val(
                            kode_sesi.substring(0, 2) + "-" + data.user_id
                        );

                        // // reset
                        // formChange("aktif");
                        mynotife(pesan, "Sukses Simpan Data", isi);

                        modal_SesiBaru.toggle();
                        modal_sesijual.toggle();
                        formChange("aktif");
                        sesijual = true;
                    },
                });
            },
        });

        function cek_sesijual() {
            modal_sesijual.toggle();
        }

        function loadSesiJual() {
            $.ajax({
                url: "sesi-penjualan",
                method: "get",
                success: function (resp) {
                    let data = resp.data;
                    console.log(data);
                    let data_sesi = tabel_SesiJual.find("tbody");
                    data_sesi.html("");

                    if (data.length == 0) {
                        data_sesi.html(
                            `<tr><td colspan="5" class="text-center">Belum Ada Sesi Penjualan</td></tr>`
                        );
                    } else {
                        let nobrs = 0;
                        for (let x = 0; x < data.length; x++) {
                            nobrs++;
                            let rowdata =
                                `
                            <tr class="text-center">
                                <td>` +
                                nobrs +
                                `</td>
                                <td>` +
                                data[x].kode_sesi +
                                `</td>
                                <td>` +
                                $.dateIndo(data[x].tanggal) +
                                `</td>
                                <td>` +
                                data[x].user_id +
                                `</td>
                                <td>` +
                                int2string_number.format(data[x].kas_awal) +
                                `</td>
                            </tr>
                        `;

                            data_sesi.append(rowdata);
                        }
                    }
                },
            });
            modal_sesijual.toggle();
        }
    })(jQuery)
);
