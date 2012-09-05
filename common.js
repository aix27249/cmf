$(document).ready(function() {
	jQuery('input[placeholder], textarea[placeholder]').placeholder();
/*	jQuery('<nobr>').replaceWith('<span style="white-space: nowrap;">');
	jQuery('</nobr>').replaceWith('</span>');*/
	/*jQuery('nobr').replaceWith(function() {
		  return '<span style="white-space: nowrap;">' + $(this).html() + '</span>';
	});*/


	$('.connect_widget').html('WOLOLO');
	
});

function handleFileInputChange(id) {
	var newval = $("#" + id).val();
	var f = newval.split('\\');
	var new_filename = f[f.length-1];
	var displayname = new_filename;
	if (new_filename.length>24) displayname = new_filename.substring(0, 21) + '...';
	$("#file_input_text_" + id).text(displayname);
}
