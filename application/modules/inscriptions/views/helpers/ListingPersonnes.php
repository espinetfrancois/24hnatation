<?php

class Inscriptions_View_Helper_ListingPersonnes extends
		Zend_View_Helper_Abstract {

	public function listingPersonnes(array $aPersonnes = array()) {
		$oListe = new Projet_Xml('table', array('class' => 'listing'));
		$oListeHead = new Projet_Xml('thead', array(), array(new Projet_Xml('td', array(), 'Personnes Inscrites')));
		$oListeBody = new Projet_Xml('tbody', array());
		$oListe->append(array($oListeHead, $oListeBody));

		foreach ($aPersonnes as $aPersonne) {
			$oListeBody->append($this->getRow($aPersonne));
		}

		return $oListe;
	}

	public function getRow($aPersonne) {
		$oRow = new Projet_Xml('tr');
		$oRow->append(array(
				new Projet_Xml('td', array(), $aPersonne['NOM_PRENOM'])
				)
			);

		return $oRow;
	}
}
