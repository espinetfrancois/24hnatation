function editActi() {
	var id = $(this).attr('id').substr(5);
	
	$.ajax({
		url : "/fr/administration/axactivites-modifieractivite",
		data : {idActivite : id},
		success : function(data) {
			$('#form_temp').html(data);
			$('#form_temp form').submit(function() {
				$.post($(this).attr('action'), $(this).serialize(), function() {
					$(".ui-dialog-content").dialog("close");
					document.location.reload(true);
				});
				
				return false;
				});
		},
		complete: function() {
			$('#form_temp').dialog(
					{width : "700px",
					 title : "Modifier une activité"
				});
		}
	});
	
	
}

$(document).ready(function() {
	$('.activite').click(editActi);
});
