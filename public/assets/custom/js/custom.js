/* Create the popover with Header Content and Footer */
$('.popover-markup>[data-toggle="popover"]').popover({
    html: true,
    title: function () {
        return $(this).parent().find(".head").html();
    },
    /**********
    In the content method, return a class 'popover-content1' wrapping the actual 'contents',
    concatenated with a class 'popover-footer' wrapping the footer.
  ************/
    content: function () {
        return (
            '<div class="popover-content1">' +
            $(this).parent().find(".content").html() +
            '</div><div class="popover-footer">' +
            $(this).parent().find(".footer").html() +
            "</div>"
        );
    },
});

/**
  Allow the popover to be closed by clicking anywhere outside it.
**/
$("body").on("click", function (e) {
    $('.popover-markup>[data-toggle="popover"]').each(function () {
        //the 'is' for buttons that trigger popups
        //the 'has' for icons within a button that triggers a
        if (
            !$(this).is(e.target) &&
            $(this).has(e.target).length === 0 &&
            $(".popover").has(e.target).length === 0
        ) {
            $(this).popover("hide");
        }
    });
});
$(".datemask").daterangepicker(
    {
        singleDatePicker: false,
        showDropdowns: true,
        timePicker: true,
        timePicker24Hour: true,
        autoApply: true,
        ranges: {
            Today: [moment(), moment()],
            Yesterday: [
                moment().subtract(1, "days"),
                moment().subtract(1, "days"),
            ],
            "Last 7 Days": [moment().subtract(6, "days"), moment()],
            "Last 30 Days": [moment().subtract(29, "days"), moment()],
            "This Month": [moment().startOf("month"), moment().endOf("month")],
            "Last Month": [
                moment().subtract(1, "month").startOf("month"),
                moment().subtract(1, "month").endOf("month"),
            ],
        },
        locale: {
            format: "DD-MM-YYYY",
            separator: " - ",
            applyLabel: "Apply",
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
        startDate: "07-05-2021",
        endDate: "14-05-2021",
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
 * Tabel Data Barang Navigation Keyboard
 */
var data_barang = $("table#tabel_barang tbody tr");
var currRow = data_barang.first();
var data_cell = currRow.find("td");

data_barang.on("dblclick", function () {
    currRow = $(this);
    data_cell = currRow.find("td");
    id = $(this).attr("data-id");

    getProduct(data_cell);
});
data_barang.on("click", function () {
    currRow = $(this);
    data_cell = currRow.find("td");
    id = $(this).attr("data-id");
});

input_filter.on("keyup", function (e) {
    e.preventDefault();

    let value = $(this).val().toLowerCase();

    if (e.which != 27) {
        data_barang.filter(function () {
            $(this).toggle(
                $(this).text().toLowerCase().indexOf(value) > -1
            );
        });
        $("div#note_cari").html("Gunakan Mouse Klik utk ambil barang");
    } else {
        if (value == "") {
            tutupLayarBarang();
        } else {
            $("button.clear").trigger("click");
        }
    }
});

$("button.clear").on("click", function () {
    var value = $(this).val().toLowerCase();
    input_filter.val("");
    data_barang.filter(function () {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
    });
    input_filter.focus();
    $("div#note_cari").html(
        "Gunakan Mouse Klik, panah atas bawah dan enter dan utk ambil barang"
    );
});

data_barang.on("keydown", function (e) {
    let c_row = "";

    e.preventDefault();

    if (e.keyCode == 40) {
        // Down Arrow
        c_row = currRow.next();
    } else if (e.keyCode == 38) {
        // Up Arrow
        c_row = currRow.prev();
    } else if (e.keyCode == 13) {
        // enter
        data_cell = currRow.find("td");
        id = data_cell.parent().attr("data-id");
        getProduct(data_cell);
    } else if (e.keyCode == 27) {
        tutupLayarBarang();
    }

    // If we didn't hit a boundary, update the current row
    if (c_row.length > 0) {
        currRow = c_row;
        currRow.focus();
    }
});

/**
 * Multi Event one function
 */
// $("#element").on("keyup keypress blur change", function (e) {
//     // e.type is the type of event fired
// });

// or

// var myFunction = function() {
//    ...
// }

// $('#element')
//     .keyup(myFunction)
//     .keypress(myFunction)
//     .blur(myFunction)
//     .change(myFunction)
