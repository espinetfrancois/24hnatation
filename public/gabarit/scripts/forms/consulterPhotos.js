
function getPhotos() {
	$.ajax({
		url: '/fr/photos/axconsulter-getphotosbycategorie',
		data : {idCategorie : $('#Categorie').val()},
		success : function(sPhotos) {
			$("#photos").html(sPhotos);
		}
	});
}

$(document).ready(function() {
	$("#Categorie").change(getPhotos);
	getPhotos();
});
