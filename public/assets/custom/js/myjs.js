(function ($) {
    ("use strict");

    $.fn.enterAsTab = function (options) {
        var settings = $.extend(
            {
                allowSubmit: false,
            },
            options
        );
        this.find("input, select").on(
            "keypress",
            { localSettings: settings },
            function (event) {
                // event.preventDefault(); //tambahan
                if (settings.allowSubmit) {
                    var type = $(this).attr("type");
                    if (type == "submit") {
                        return true;
                    }
                }
                if (event.keyCode == 13) {
                    var inputs = $(this)
                        .parents("form")
                        .eq(0)
                        .find(":input:visible:not(disabled):not([readonly])");
                    var idx = inputs.index(this);
                    if (idx == inputs.length - 1) {
                        idx = -1;
                    } else {
                        inputs[idx + 1].focus(); // handles submit buttons
                    }
                    try {
                        inputs[idx + 1].select();
                    } catch (err) {
                        // handle objects not offering select
                    }
                    return false;
                }
            }
        );
        return this;
    };

    /**
     * Function Tanggal dd/mm/yyyy
     * @param {*} dateObject
     * @returns $.tgl1(yourDateObject) - dd/mm/yyyy;
     */
    // $.fn.date = function (dateObject) {
    //     var d = new Date(dateObject);
    //     var day = d.getDate();
    //     var month = d.getMonth() + 1;
    //     var year = d.getFullYear();
    //     if (day < 10) {
    //         day = "0" + day;
    //     }
    //     if (month < 10) {
    //         month = "0" + month;
    //     }
    //     var date = day + "/" + month + "/" + year;

    //     return date;
    // };

    // $.fn.formatDate = function(tanggal) {
    //     let cTgl = new Date(tanggal); //new Date(2021,11,01) -- year, month(0-11), and day
    //     let dd = String(cTgl.getDate()).padStart(2, "0");
    //     let mm = String(cTgl.getMonth() + 1).padStart(2, "0"); //January is 0!
    //     let yyyy = cTgl.getFullYear();
    //     cTgl = dd + "-" + mm + "-" + yyyy;

    //     return cTgl;
    // };

    // Play oscillators at certain frequency and for a certain time

})(jQuery);
