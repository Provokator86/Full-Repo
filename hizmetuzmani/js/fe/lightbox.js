// JavaScript Document
<!--
var dialog = null;
function show_dialog (id)
{
	if(!dialog) dialog = null;
	dialog = new ModalDialog ("."+id);
	dialog.show();
	return false;
}

function hide_dialog ()
{
	dialog.hide();
	if(!dialog) dialog = null;
}
//-->