"use strict";
(function($) {
    if ($.pjax) {
        $.pjax.defaults.scrollTo = false;
        $.pjax.defaults.timeout = 5000;
    }

    if (window.parent && window.frameElement && window.parent.jQuery) {
        var $parent = window.parent.jQuery;
        $(function() {
            $parent(window.frameElement).trigger("iframeready");
        });
        $(window).unload(function() {
            $parent(window.frameElement).trigger("iframeunloaded");
        });
    }

    $(function() {
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
            if(searchForm.length && searchForm.closest('.box-body-main').length) {
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

    $(document).on('action.Create action.Update action.Delete', function(event, data) {
        if(window.parent && window.frameElement && window.parent.jQuery) {
            window.parent.jQuery(window.parent.document).trigger(event, data);
        }
    });

    $('body')
        .on('fixed', function() {
            var body = $(this);
            body.css({overflow:'hidden'});
        })
        .on('unfixed', function() {
            var body = $(this);
            body.css({overflow:''});
        });

    $(document).on('click', '.j-frame-dialog', function(event) {
        event.preventDefault();
        var el = $(this);

        $('body').trigger('fixed');

        var iframePopup = $('<div class="iframe-popup" />').appendTo('body');
        var iframePopupIframe = $('<div class="iframe-popup-iframe" />').appendTo(iframePopup);
        var close = $('<a class="iframe-popup-close" />').appendTo(iframePopupIframe);
        close.click(function() {
            iframePopup.remove();
            $('body').trigger('unfixed');
        });
        var iframe = $('<iframe />').appendTo(iframePopupIframe);
        var iframesrc;
        iframe.on('iframeloading', function() {
            var doc = $(this).contents();
            doc.find('body').addClass('sidebar-collapse');
            if (!iframesrc) {
                iframesrc = iframe[0].contentWindow.location.href;
            } else {
                if (iframesrc != iframe[0].contentWindow.location.href) {
                    iframePopup.remove();
                    $('body').trigger('unfixed');
                }
            }
        });
        iframe.attr('src', el.attr('href'));
    });
})(jQuery);