CKEDITOR.on('dialogDefinition', function( event ) {
    var dialogName = event.data.name;
    var dialogDefinition = event.data.definition;

    if (dialogName == 'table') {
        var infoTab = dialogDefinition.getContents('info');
        infoTab.remove('txtCellPad');
        infoTab.remove('txtCellSpace');
        infoTab.remove('txtBorder');
        var txtWidth = infoTab.get('txtWidth');
        txtWidth['default'] = '100%';
    }
});