<?php

class Application_Model_Categorie extends Projet_Entite {

	protected $_libelle = null;

	public function setLibelle($sRefLibelle) {
		$this->_libelle = $sRefLibelle;
	}

	public function getLibelle() {
		return $this->_libelle;
	}
}