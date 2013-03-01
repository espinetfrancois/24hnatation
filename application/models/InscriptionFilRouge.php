<?php

class Application_Model_InscriptionFilRouge extends Projet_Entite {

	protected $_uid = null;
	protected $_idActivite = null;
	protected $_typeInscription = null;

	public function getUid()
	{
	    return $this->_uid;
	}

	public function setUid($_uid)
	{
	    $this->_uid = $_uid;
	}

	public function getIdActivite()
	{
	    return $this->_idActivite;
	}

	public function setIdActivite($_idActivite)
	{
	    $this->_idActivite = $_idActivite;
	}

	public function getNomEquipe()
	{
		return $this->_nomEquipe;
	}

	public function setNomEquipe($_nomEquipe)
	{
		$this->_nomEquipe = $_nomEquipe;
	}

	public function getTypeInscription()
	{
	    return $this->_type;
	}

	public function setTypeInscription($_type)
	{
	    $this->_type = $_type;
	}
}