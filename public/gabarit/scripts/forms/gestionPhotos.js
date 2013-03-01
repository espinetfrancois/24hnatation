
function updateCategorie() {
	$.ajax({
		url : "/fr/photos/axadministration-updatecategoriebyidphoto",
		data : {idPhoto : $(this).closest('.photo').attr('id').substr(6),
				idCategorie : $(this).val()},
		success : function(msg) {
			$(msg).dialog();
		}
	});
}

function supprimerPhoto() {
	var divph = $(this).closest('.photo');
	$.ajax({
		url : "/fr/photos/axadministration-supprimerphotobyid",
		data : {idPhoto : divph.attr('id').substr(6),
				idCategorie : $(this).val()},
		success : function(msg) {
			$(msg).dialog();
			divph.hide();
		}
	});
}

$(document).ready(function() {
	$("#Categorie").change(updateCategorie);
	$('.photo_delete').click(supprimerPhoto);
});
