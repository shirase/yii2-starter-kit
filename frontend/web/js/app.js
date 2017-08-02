(function($) {
    $('body')
        .on('fixed', function() {
            var body = $(this);
            var y = body.scrollTop();
            body.addClass('fixed');
            $('#body_scroll').scrollTop(y);
        })
        .on('unfixed', function() {
            var body = $(this);
            var y = $('#body_scroll').scrollTop();
            body.removeClass('fixed');
            body.scrollTop(y);
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
            $(document).off('action');
            $('body').trigger('unfixed');
        });

        var expand = $('<a class="iframe-popup-expand" />').appendTo(iframePopupIframe);
        expand.click(function() {
            iframePopup.toggleClass('iframe-popup-expanded');
        });

        var iframe = $('<iframe />').appendTo(iframePopupIframe);

        iframe.on('iframeloading', function() {
            iframe.contents().find('body').addClass('is-frame-dialog');
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