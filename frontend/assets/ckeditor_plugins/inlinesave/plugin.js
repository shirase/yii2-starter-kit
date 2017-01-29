/*
Copyright (c) 2003-2011, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

/**
 * @fileSave plugin.
 */

(function()
{
	var saveCmd =
	{
		modes : { wysiwyg:1, source:1 },
		readOnly : 1,

		exec : function( editor )
		{
            var editorhtml = editor.getData();

            setTimeout(function() {
                var saveurl = $(editor.element.$).data('saveurl');
                var attribute = $(editor.element.$).data('attribute');
                if(!attribute) attribute = 'html';
                var data = {};
                data[attribute] = editorhtml;
                var csrfParam = $('meta[name="csrf-param"]').attr('content');
                data[csrfParam] = $('meta[name="csrf-token"]').attr('content');
                if(saveurl) {
                    $.ajax({
                        url: saveurl,
                        data: data,
                        dataType: 'html',
                        cache: false,
                        type: 'POST',
                        'success':function(html, textStatus, jqXHR) {
                            alert(html);
                        },
                        'error':function(jqXHR, textStatus, errorThrown) {
                            alert(jqXHR.responseText);
                        }
                    });
                } else {
                    alert('No SaveURL');
                }
            }, 1);
		}
	};

    var onSubmit = function(e, data) {
        e.preventDefault();
    };

	var pluginName = 'inlinesave';

	// Register a plugin named "save".
	CKEDITOR.plugins.add( pluginName,
	{
        icons: 'inlinesave',
		init : function( editor )
		{
            var $form = $(editor.element.$.form);
            $form.bind('submit', onSubmit);
            //$form.data('_onsubmit', $form.attr('onsubmit'));
            $form.removeAttr('onsubmit');

			var command = editor.addCommand( pluginName, saveCmd );
			//command.modes = { wysiwyg : !!( editor.element.$.form ) };

			editor.ui.addButton( 'InlineSave',
				{
					label : editor.lang.save.toolbar,
					command : pluginName
				});
		}
	});
})();
