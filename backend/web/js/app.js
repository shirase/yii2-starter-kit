$(function() {
    "use strict";

    //Make the dashboard widgets sortable Using jquery UI
    $(".connectedSortable").sortable({
        placeholder: "sort-highlight",
        connectWith: ".connectedSortable",
        handle: ".box-header, .nav-tabs",
        forcePlaceholderSize: true,
        zIndex: 999999
    }).disableSelection();
    $(".connectedSortable .box-header, .connectedSortable .nav-tabs-custom").css("cursor", "move");

    (function() {
        var pageTitle = $('.content-wrapper .content-header h1:first');
        if(pageTitle.html()) {
            $('.content-wrapper .content h1:first').remove();
        } else {
            var h1 = $('.content-wrapper .content h1:first');
            pageTitle.replaceWith(h1);
        }

        var searchForm = $('.content-wrapper .content .search-form');
        if(searchForm.length) {
            searchForm
                .wrap('<div class="box-body" />')
                .parent()
                .wrap('<div class="box collapsed-box" />')
                .parent()
                .prependTo($('.content-wrapper .content'))
                .prepend($('<div class="box-header"><div class="box-title" onclick="$.AdminLTE.boxWidget.collapse($(this).next().find(\'button\'))" style="cursor: pointer">'+searchForm.find('.btn-primary:first').text()+'</div><div class="box-tools pull-right"><button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button></div></div>'));
        }
    })();
});