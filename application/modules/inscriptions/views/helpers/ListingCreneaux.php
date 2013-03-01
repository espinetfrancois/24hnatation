<?php

class Inscriptions_View_Helper_ListingCreneaux extends
		Zend_View_Helper_Abstract {

	const NB_TABLES = 2;
	public $listesBody = array();
	public $listes = array();
	public $listesHeads = array();

	public function listingCreneaux($aCreneaux = array(), $aPris = array()) {
		$this->initLists();
		$i=0;
		foreach ($aCreneaux as $sId => $oCreneau) {
			$this->listesBody[$i % self::NB_TABLES]->append($this->getRow($oCreneau, in_array($sId, $aPris)));
			$i++;
		}
		$oListe = new Projet_Xml('div');
		$oListe->append($this->listes);
		return $oListe;
	}

	protected function initLists() {
		for ($i=0; $i<self::NB_TABLES; $i++) {
			$this->listes[$i] = new Projet_Xml('table', array('class' => 'listing'));
			$this->listesHeads[$i] = new Projet_Xml('thead', array(), array(new Projet_Xml('td', array(), 'Horaire'),
											new Projet_Xml('td', array(), 'Réservé par'),
											new Projet_Xml('td', array(), 'Participants'),
											new Projet_Xml('td', array(), 'Section')));
			$this->listesBody[$i] = new Projet_Xml('tbody', array());
			$this->listes[$i]->append(array($this->listesHeads[$i], $this->listesBody[$i]));
		}
	}

	public function getRow(Application_Model_Creneau $oCreneau, $isPris = false) {
		$oRow = new Projet_Xml('tr');
		$oRow->append(array(
				new Projet_Xml('td', array(), $oCreneau->getHeureDebut().' - '.$oCreneau->getHeureFin())
				)
			);

		if ($isPris) {
			$oRow->setAttr('class', 'pris');
			$oRow->append(new Projet_Xml('td', array(), $oCreneau->getUtilisateur()->getNomPrenom()));
			$oRow->append(new Projet_Xml('td', array(), $oCreneau->getParticipants()->getNomPrenoms()));
		} else {
			$oRow->append(array(new Projet_Xml('td'), new Projet_Xml('td')));
		}

		if ($oCreneau->getUtilisateur() instanceof Application_Model_Eleve) {
			$oRow->append(new Projet_Xml('td', array(), $oCreneau->getUtilisateur()->getSport()));
		} else {
			$oRow->append(new Projet_Xml('td'));
		}

		//colone supplémentaire pour les commentaires
		$oRow->append(new Projet_Xml('td'));
		return $oRow;
	}
}
