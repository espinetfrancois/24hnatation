
function uncheckChamp() {
	$('input[name=Crenaux]:checked').removeAttr('checked');
	$('#is_desinscription').val(1);
}


$(function() {
	$('#desinscription').click(uncheckChamp);
});