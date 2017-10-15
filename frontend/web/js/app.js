(function($) {
    if ($.pjax) {
        $.pjax.defaults.scrollTo = false;
        $.pjax.defaults.timeout = 5000;
    }

    $('body')
        .on('fixed', function() {
            var body = $(this);
            var y = $(window).scrollTop();
            body.addClass('fixed');
            $('#body_scroll').scrollTop(y);
        })
        .on('unfixed', function() {
            var body = $(this);
            var y = $('#body_scroll').scrollTop();
            body.removeClass('fixed');
            $(window).scrollTop(y);
        });

    $(document).on('click', '.j-frame-dialog, .j_frame_dialog', function(event) {
        event.preventDefault();
        var el = $(this);

        $('body').trigger('fixed');

        var iframePopup = $('<div class="iframe_popup" />').appendTo('body');
        var iframePopupIframe = $('<div class="iframe_popup__iframe" />').appendTo(iframePopup);
        var close = $('<a class="iframe_popup__close" />').appendTo(iframePopupIframe);
        close.click(function() {
            iframePopup.remove();
            $(document).off('action');
            $('body').trigger('unfixed');
        });

        var expand = $('<a class="iframe_popup__expand" />').appendTo(iframePopupIframe);
        expand.click(function() {
            iframePopup.toggleClass('iframe_popup__expanded');
        });

        var iframe = $('<iframe />').appendTo(iframePopupIframe);

        iframe.on('iframeloading', function() {
            iframe.contents().find('body').addClass('is-frame-dialog');
            iframe.contents().find('body').addClass('sidebar-collapse');
        });

        iframe.attr('src', el.attr('href'));

        var dataType = el.data('type');
        if(dataType=='index') {
            close.click(function() {
                location.reload();
            });
        }
        if(dataType=='create') {
            $(document).on('action.Create', function() {
                location.reload();
            });
        }
        if(dataType=='update') {
            $(document).on('action.Delete', function() {
                location.reload();
            });
            $(document).on('action.Update', function() {
                location.reload();
            });
        }
    });
})(jQuery);