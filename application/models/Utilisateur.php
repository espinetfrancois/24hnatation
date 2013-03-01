<?php

class Application_Model_Utilisateur extends Projet_Entite {

	protected $_uid = null;
	protected $_nom = null;
	protected $_prenom = null;
	protected $_email;
	protected $_role = null;
	protected $_nomPrenom = null;


	public function getUid()
	{
		if ($this->_uid == null) {
			return strtolower($this->getPrenom()).'.'.strtolower($this->getNom());
		}
	    return $this->_uid;
	}

	public function setUid($_uid)
	{
	    $this->_uid = $_uid;
	}

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

	public function getEmail()
	{
	    return $this->_email;
	}

	public function setEmail($_email)
	{
	    $this->_email = $_email;
	}

	public function getRole()
	{
	    return (string) $this->_role;
	}

	public function setRole($_role)
	{
	    $this->_role = (string) $_role;
	}

	public function setNomPrenom($nomPrenom) {
		$this->_nomPrenom = $nomPrenom;
	}

	public function getNomPrenom() {
		if ($this->_nomPrenom == null) {
			return strtoupper($this->_nom).' '.ucfirst($this->_prenom);
		} else {
			return $this->_nomPrenom;
		}
	}

}