(function($) {
    $(document).on('click', '.j-frame-dialog', function(event) {
        event.preventDefault();
        var el = $(this);

        var iframePopup = $('<div class="iframe-popup" />').appendTo('body');
        var iframePopupIframe = $('<div class="iframe-popup-iframe" />').appendTo(iframePopup);
        var close = $('<a class="iframe-popup-close" />').appendTo(iframePopupIframe);
        close.click(function() {
            iframePopup.remove();
            $(document).off('action');
        });
        var iframe = $('<iframe />').appendTo(iframePopupIframe);
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