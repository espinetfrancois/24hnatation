function goToInscriptions() {
	window.location = '/fr/inscriptions/accueil';
}


$(document).ready(function() {
	$('.inscriptible').click(goToInscriptions);
});


