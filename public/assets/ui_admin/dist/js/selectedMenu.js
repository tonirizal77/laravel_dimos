$(function () {
    "use strict";

    // berikut script untuk class active css
    var url = window.location;
    // untuk sidebar menu
    $("ul.sidebar-menu a")
        .filter(function () {
            return this.href == url;
        })
        .parent()
        .siblings()
        .removeClass("active")
        .end()
        .addClass("active");

    // untuk treeview sub menu dan multimenu
    $("ul.treeview-menu a")
        .filter(function () {
            return this.href == url;
        })
        .parentsUntil(".sidebar-menu > .treeview-menu")
        .siblings()
        .removeClass("active menu-open")
        .end()
        .addClass("active menu-open")
        .css({ display: "block" });
});
