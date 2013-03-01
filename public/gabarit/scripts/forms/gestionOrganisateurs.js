function editRole() {
	window.location = "/fr/administration/contacts/modifier?idRole="+$('#role').val();
}

$(document).ready(function() {
	$("#valid").click(editRole);
});
