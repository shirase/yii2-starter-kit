(function($) {
    $(document).on('click', '.j-frame-dialog', function(event) {
        event.preventDefault();
        var el = $(this);

        var iframePopup = $('<div class="iframe-popup" />').appendTo('body');
        var iframePopupIframe = $('<div class="iframe-popup-iframe" />').appendTo(iframePopup);
        var close = $('<a class="iframe-popup-close" />').appendTo(iframePopupIframe);
        close.click(function() {
            iframePopup.remove();
        });
        var iframe = $('<iframe />').appendTo(iframePopupIframe);
        iframe.attr('src', el.attr('href'));
    });
})(jQuery);