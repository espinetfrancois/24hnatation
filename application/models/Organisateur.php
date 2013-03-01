<?php

class Application_Model_Organisateur extends Projet_Entite {

	protected $_nom = null;
	protected $_prenom = null;
	protected $_telephone = null;
	protected $_idRole = null;


	public function getNom()
	{
	    return $this->_nom;
	}

	public function setNom($_nom)
	{
	    $this->_nom = $_nom;
	}

	public function getPrenom()
	{
	    return $this->_prenom;
	}

	public function setPrenom($_prenom)
	{
	    $this->_prenom = $_prenom;
	}

	public function getTelephone()
	{
	    return $this->_telephone;
	}

	public function setTelephone($_telephone)
	{
	    $this->_telephone = $_telephone;
	}

	public function getIdRole()
	{
	    return $this->_idRole;
	}

	public function setIdRole($_idRole)
	{
	    $this->_idRole = $_idRole;
	}
}