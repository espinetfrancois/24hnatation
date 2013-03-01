<?php

class Application_Model_Activite extends Projet_Entite {

	protected $_nom;
	protected $_description;
	protected $_inscriptible;
	protected $_date_debut = null;
	protected $_heure_debut= null;
	protected $_dateFin = null;
	protected $_heureFin = null;
	protected $_type;

	public function getNom()
	{
	    return $this->_nom;
	}

	public function setNom($_nom)
	{
	    $this->_nom = $_nom;
	}

	public function getDescription()
	{
	    return $this->_description;
	}

	public function setDescription($_description)
	{
	    $this->_description = $_description;
	}

	public function getInscriptible()
	{
	    return $this->_inscriptible;
	}

	public function setInscriptible($_inscriptible)
	{
	    $this->_inscriptible = (bool) $_inscriptible;
	}

	public function getDateDebut()
	{
	    return $this->_date_debut;
	}

	public function setDateDebut($_date_debut)
	{
	    $this->_date_debut = (int) $_date_debut;
	}

	public function getDuree()
	{
	    return $this->_duree;
	}

	public function setDuree($_duree)
	{
	    $this->_duree = $_duree;
	}

	public function getHeureDebut()
	{
	    return $this->_heure_debut;
	}

	public function setHeureDebut($_heure_debut)
	{
	    $this->_heure_debut = $_heure_debut;
	}

	public function getDateFin()
	{
	    return $this->_dateFin;
	}

	public function setDateFin($_dateFin)
	{
	    $this->_dateFin = (int) $_dateFin;
	}

	public function getHeureFin()
	{
	    return $this->_heureFin;
	}

	public function setHeureFin($_heureFin)
	{
	    $this->_heureFin = $_heureFin;
	}

	public function getType()
	{
	    return $this->_type;
	}

	public function setType($_type)
	{
	    $this->_type = $_type;
	}
}