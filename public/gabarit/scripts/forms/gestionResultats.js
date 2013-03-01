function editResult() {
	var id = $(this).attr('id').substr(5);
	
	$.ajax({
		url : "/fr/administration/axresultats-modifierresultat",
		data : {idResultat : id},
		success : function(data) {
			$('#form_temp').html(data);
			$('#form_temp form').submit(function() {
				formSubmit();
				$.post($(this).attr('action'), $(this).serialize(), function() {
					$(".ui-dialog-content").dialog("close");
					document.location.reload(true);
				});
				
				return false;
				});
		},
		complete: function() {
			$('#champ-Contenu').append('<div id="resultWrapper"></div>');
			$('#resultWrapper').append(buttonSet);
			linkButtons();
			$('#resultWrapper').append(initTable());
			table = $('#result');
			
			fillFormTable('acti_'+id);
			
			$('#form_temp').dialog(
					{width : "80%",
					 title : "Modifier un résultat"
				});
		}
	});
	
	
}

function fillFormTable(idActi) {
	$('#'+idActi).find('tr').each(function() {
		var dup = $(this).clone();
		
		//remplissage des td par des input
		$(dup).children('td').each(function() {
			var ain = $(input).val($(this).text());
			$(this).text("");
			$(this).append(ain);
		});
		
		if ($(this).parent().is('thead')) {
			table.children('thead').html(dup);
		} else {
			table.children('tbody').append(dup);
		}
		
	});
	
}

function fillNextRaw(content) {
	$(content).find('td').each(function() {
		$(this).html($(input).val($(this).html()));
	});
//	alert(raw);
	table.append();
}

$(document).ready(function() {
	$('.resultat.admin').click(editResult);
});
