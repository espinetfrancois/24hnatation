var max_champs = 10;

function checkChamps() {
	if ($('input[name^=Crenaux]:checked').size() > max_champs) {
		$('<div>Le nombre de creneaux est limité à '+max_champs+'.</div>').dialog();
		$(this).removeAttr('checked');
	}
}

function displayInscription() {
	if ($('[name=type_inscription]:checked').val() == 1) {
		//inscription personnelle
		$('#champ-Binet_inscrit').hide();
		$('#Personnes_inscrites-element').show();
	} else {
		$('#champ-Binet_inscrit').show();
		$('#Personnes_inscrites-element').hide();
	}
}

$(function() {
	if  (parseInt($('#role').text()) < 10) {
		$('input[name^=Crenaux]').click(checkChamps);
		$('[name=type_inscription]').click(displayInscription);
		displayInscription();
	}
});