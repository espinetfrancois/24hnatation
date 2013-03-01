<?php

class Application_Model_Photo extends Projet_Entite {

	protected $_uidUtilisateur = null;
	protected $_nomFichier = null;
	protected $_idCategorie = null;



	public function getUidUtilisateur()
	{
	    return $this->_idUtilisateur;
	}

	public function setUidUtilisateur($_idUtilisateur)
	{
	    $this->_idUtilisateur = $_idUtilisateur;
	}

	public function getNomFichier()
	{
	    return $this->_nomFichier;
	}

	public function setNomFichier($_nomFichier)
	{
	    $this->_nomFichier = $_nomFichier;
	}

	public function getIdCategorie()
	{
	    return $this->_idCategorie;
	}

	public function setIdCategorie($_idCategorie)
	{
	    $this->_idCategorie = $_idCategorie;
	}
}