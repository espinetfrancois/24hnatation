var input = '<input type="text">';
var table;
var buttonSet = "<div class='buttonSet'>"+
			"<span class='bouton' id='colAdd'>Ajouter une colone</span>"+
			"<span class='bouton' id='colDel'>Supprimer une colone</span>"+		
			"<span class='bouton' id='rowAdd'>Ajouter une ligne</span>"+
			"<span class='bouton' id='rowDel'>Supprimer une ligne</span>"+
			"</div>";

function setTable(aTable) {
	table = aTable;
}
function formSubmit() {
	//récupération des résulats édités
	var txt  = getTable();
	//mise en place dans le champ adéquat
	$('#Contenu').text(txt);
	
	return true;
}

function getTable() {
	table.removeAttr('id');
	table.find('td').each(function() {
		var val = $(this).find(':input').val();
		$(this).html(val);
	});
	var txt = table.clone().wrap('<p>').parent().html();
	return txt;
}

function addRow() {
	var row = "<tr>";
	for (var i=0; i< getNoCols(); i++) {
		row += "<td>"+input+'</td>';
	}
	row +='</tr>';
	
	table.append(row);
}

function removeRow() {
	table.children('tbody').children('tr:last-child').remove();
}

function addCol() {
	var col = '<td>'+input+'</td>';
	table.children('thead').children('tr').append(col);
	table.children('tbody').children('tr').each(function() {
		$(this).append(col);
	});
}

function removeCol() {
	table.children('thead').find('td:last-child').remove();
	table.children('tbody').find('td:last-child').each(function() {
		$(this).remove();
	});
}

function initTable() {
	return '<table id="result" border="1"><thead>'+getFirstRow()+'</thead><tbody></tbody></table>';
}

function getFirstRow() {
	return "<tr><td>"+input+'</td><td>'+input+'</td></tr>';
}
//
//function addCaption() {
//	return "
//}
//
//function removeCaption() {
//	$('caption').remove();
//}

function getNoCols() {
	return table.children('thead').find('td').length;
}

function getNoRows() {
	return table.children('tr').length;
}

function linkButtons() {
	$('#colAdd').click(addCol);
	$('#rowAdd').click(addRow);
	
	$('#colDel').click(removeCol);
	$('#rowDel').click(removeRow);
}

$(document).ready(function() {
	$('#champ-Contenu').append('<div id="resultWrapper"></div>');
	$('#resultWrapper').append(buttonSet);
	linkButtons();
	$('#resultWrapper').append(initTable());
	table = $('#result');
	$('form#FormModifResultat').submit(formSubmit);
});
