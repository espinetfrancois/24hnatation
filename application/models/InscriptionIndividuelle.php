<?php

class Application_Model_InscriptionIndividuelle extends Projet_Entite {

	protected $_uid = null;
	protected $_idActivite = null;

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
}