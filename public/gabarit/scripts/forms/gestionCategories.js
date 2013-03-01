
function getCategories() {
	$.ajax({
		url: '/fr/photos/axadministration-getallcategories',
		success : function(sCat) {
			$("#categories").html(sCat);
		}
	});
}

function ajouterCategorie() {
	$("#formAjouter").slideDown();
}

function supprimerCategorie() {
	$.ajax({
		url: '/fr/photos/axadministration-supprcategoriebyid',
		data: {idCategorie:$(this).attr('id').substr(4)},
		success : function(message) {
			getCategories();
			$(message).dialog({ buttons: { "Ok": function() { $(this).dialog("close"); }}
			});
		}
	});
}

$(document).ready(function() {
	getCategories();
	$("#ajouterCategorie").click(ajouterCategorie);
	$("#formAjouter").hide();
});
