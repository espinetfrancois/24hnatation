<?php

class Application_Model_Eleve extends Application_Model_Utilisateur {

	protected $_sport = null;
	protected $_droits;
	protected $_binetsAdmin;



	public function getSport()
	{
		if ($this->_sport == null) {
			return 'Aucun';
		}
	    return $this->_sport;
	}

	public function setSport($_sport)
	{
	    $this->_sport = $_sport;
	}

	public function getDroits()
	{
	    return $this->_droits;
	}

	public function setDroits($_droits)
	{
	    $this->_droits = $_droits;
	}

	public function getBinetsAdmin()
	{
	    return $this->_binetsAdmin;
	}

	public function setBinetsAdmin($_binetsAdmin)
	{
	    $this->_binetsAdmin = $_binetsAdmin;
	}
}