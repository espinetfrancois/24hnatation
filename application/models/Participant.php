<?php

class Application_Model_Participant extends Projet_Entite {


	protected $_nomPrenom;
	protected $_idInscription = 0 ;

	public function getNomPrenom()
	{
	    return $this->_nomPrenom;
	}

	public function setNomPrenom($_nomPrenom)
	{
	    $this->_nomPrenom = $_nomPrenom;
	}

	public function getIdInscription()
	{
	    return $this->_idInscription;
	}

	public function setIdInscription($_idInscription)
	{
	    $this->_idInscription = $_idInscription;
	}
}
