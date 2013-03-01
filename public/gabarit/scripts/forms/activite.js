function displayType() {
	if ($(this).val() == 0) {
		$('#champ-Type').hide();
	} else {
		$('#champ-Type').show();
	}
	
}

function initForm() {
	if ($('[name=Inscriptible]').val() == 0) {
		$('#champ-Type').hide();
	} else {
		$('#champ-Type').show();
	}
}
$(document).ready(function() {
	initForm();
	$('[name=Inscriptible]').on('change', displayType);
});
