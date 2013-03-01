<?php

class Application_Model_Jour extends Projet_Entite {

	protected $_libelle = null;
	protected $_noJour;
	protected $_mois;

	public function setLibelle($sRefLibelle) {
		$this->_libelle = $sRefLibelle;
	}

	public function getLibelle() {
		return $this->_libelle;
	}

	public function getNoJour()
	{
	    return $this->_noJour;
	}

	public function setNoJour($_noJour)
	{
	    $this->_noJour = $_noJour;
	}

	public function getMois()
	{
	    return $this->_mois;
	}

	public function setMois($_mois)
	{
	    $this->_mois = $_mois;
	}
}