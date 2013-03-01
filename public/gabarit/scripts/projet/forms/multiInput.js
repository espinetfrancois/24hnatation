var champs_limit 	= 3;

var prefix_length 	= 10;
var div_suffix 		= '-element';


var remBoutonPrefix = 'remBoutons';
var addBoutonPrefix = 'addBoutons';

$(function () {
	initBoutons();
	//au click des boutons ajouter ou suprrimer on suprrime ou on ajout une case
	$('.remBouton').click(remChamp);
	$('.addBouton').click(addChamp);
});

function setChampsLimit(limit) {
	champs_limit = limit;
}
function addChamp() {
	//récupération de l'id du champ à changer
	var idChamp = $(this).attr('id').substr(prefix_length);
	var currentNumber = $('div#'+idChamp+div_suffix).find('input').length;
	console.log(currentNumber);
	if (currentNumber < champs_limit) {
		//clonage et ajout de -nombre à la fin de l'id
		var champ = $('#'+idChamp).clone();
		var baseId = champ.attr('id');
		champ.attr('id', baseId+"-"+currentNumber);
		champ.val("");
		$('#'+idChamp+'-element').find(".champsMultiInput").append(champ);
		if (currentNumber >= 1) {
			var butremid = $(this).attr('id').replace('add', 'rem');
			$('#'+butremid).show();
		}
	} else {
		alert('Le nombre maximal de champs est : '+champs_limit);
	}
	
}

function remChamp() {
	var idChamp = $(this).attr('id').substr(prefix_length);
	var currentNumber = $('div#'+idChamp+div_suffix).find('input').length;
	if (currentNumber >= 2) {
		$('div#'+idChamp+div_suffix).find('div.champsMultiInput').children(':last-child').remove();
	}
	
	if (currentNumber-1 == 1 ) {
		$(this).hide();
	}
}

function initBoutons() {
	$('.MultiInput').each(function() {
		var currentNum = $(this).find('input').length;
		var rawAttr = $(this).attr('id').replace(div_suffix, '');
//		console.log(rawAttr);
		//si on ne peut plus ajouter de champs
		if (currentNum == champs_limit) {
			$('#'+addBoutonPrefix+rawAttr).hide();
		} else if (currentNum == 1) {
			$('#'+remBoutonPrefix+rawAttr).hide();
		}
	});
}