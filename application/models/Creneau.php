<?php

class Application_Model_Creneau extends Projet_Entite {

	protected $_idActivite;
	protected $_idJour;
	protected $_HeureDebut;
	protected $_HeureFin;
	protected $_idInscription = null;
	protected $_utilisateur = null;

	protected $_participants = null;

	public function getIdActivite()
	{
	    return $this->_idActivite;
	}

	public function setIdActivite($_idActivite)
	{
	    $this->_idActivite = $_idActivite;
	}

	public function getIdJour()
	{
	    return $this->_idJour;
	}

	public function setIdJour($_idJour)
	{
	    $this->_idJour = $_idJour;
	}

	public function getHeureDebut()
	{
	    return $this->_HeureDebut;
	}

	public function setHeureDebut($_HeureDebut)
	{
	    $this->_HeureDebut = $_HeureDebut;
	}

	public function getHeureFin()
	{
	    return $this->_HeureFin;
	}

	public function setHeureFin($_HeureFin)
	{
	    $this->_HeureFin = $_HeureFin;
	}

	public function getIdInscription()
	{
		if ($this->_idInscription == null) {
			return 0;
		}
	    return $this->_idInscription;
	}

	public function setIdInscription($_idInscription)
	{
	    $this->_idInscription = $_idInscription;
	}

	/**
	 *
	 * @author francois.espinet
	 * @return Application_Model_Utilisateur
	 */
	public function getUtilisateur()
	{
	    return $this->_utilisateur;
	}

	public function setUtilisateur($_utilisateur)
	{
	    $this->_utilisateur = $_utilisateur;
	}

	/**
	 * @return Application_Model_Participants
	 * @author francois.espinet
	 */
	public function getParticipants()
	{
	    return $this->_participants;
	}

	public function setParticipants($_participants)
	{
	    $this->_participants = $_participants;
	}
}