(function () {
    CKEDITOR.plugins.add('widgets', {
        requires: 'widget,richcombo',
        init: function (editor) {
            var config = editor.config;

            editor.ui.addRichCombo('Widgets', {
                label: 'Вставить',

                panel: {
                    css: [ CKEDITOR.skin.getPath( 'editor' ) ].concat( config.contentsCss ),
                    multiSelect: false
                },

                init: function () {
                    this.add('important-block', 'Выделенный блок');
                    this.commit();
                },

                onClick: function (value) {
                    editor.focus();
                    editor.fire('saveSnapshot');

                    editor.execCommand(value);

                    editor.fire('saveSnapshot');
                }
            });

            editor.widgets.add('important-block', {
                template: '<div class="important-block"><p>&nbsp;</p></div>',

                editables: {
                    content: {
                        selector: 'div.important-block'
                    }
                },

                upcast: function (element) {
                    return element.name == 'div' && element.hasClass('important-block');
                }
            });
        }
    });
})();