<?php

class Inscriptions_View_Helper_ListingEquipes extends
		Zend_View_Helper_Abstract {

	public function listingEquipes(array $aEquipes = array()) {
		$oListe = new Projet_Xml('table', array('class' => 'listing'));
		$oListeHead = new Projet_Xml('thead', array(), array(new Projet_Xml('td', array(), 'Nom de l\'équipe'),
															 new Projet_Xml('td', array(), 'Inscrite par'),
															 new Projet_Xml('td', array(), 'Autres Personnes')));
		$oListeBody = new Projet_Xml('tbody', array());
		$oListe->append(array($oListeHead, $oListeBody));

		foreach ($aEquipes as $oEquipe) {
			$oListeBody->append($this->getRow($oEquipe));
		}

		return $oListe;
	}

	public function getRow(Application_Model_Equipe $oEquipe) {
		$oRow = new Projet_Xml('tr');
		$oRow->append(array(
				new Projet_Xml('td', array(), $oEquipe->getNom()),
				new Projet_Xml('td', array(), $oEquipe->getNomPrenomInscripteur()),
				new Projet_Xml('td', array(), $oEquipe->getParticipants()->getNomPrenoms()),
// 				new Projet_Xml('td', array(), $oEquipe->getInscription()->get)
				)
			);

		return $oRow;
	}
}
