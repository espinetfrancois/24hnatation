<?php

class Application_Model_Equipe {


	public function __construct($aEquipe) {
		$this->setNomPrenomInscripteur($aEquipe['NOM_PRENOM']);
		$this->setNom($aEquipe['NOM_EQUIPE']);
		$this->setParticipants(new Application_Model_Participants($aEquipe['PARTICIPANTS_NOM_PRENOM']));
		$oInscription = new Application_Model_InscriptionTournoi();
		$oInscription->setIdActivite($aEquipe['ID_ACTIVITE']);
		$oInscription->setNomEquipe($aEquipe['NOM_EQUIPE']);
		$oInscription->setUid($aEquipe['UID']);
		$this->setInscription($oInscription);
	}

	protected $_nomPrenomInscripteur = null;
	protected $_nom;

	/**
	 *
	 * @var Application_Model_Participants
	 */
	protected $_participants = null;

	/**
	 *
	 * @var Application_Model_InscriptionTournoi
	 */
	protected $_inscription = null;

	public function getNomPrenomInscripteur()
	{
	    return $this->_nomPrenomInscripteur;
	}

	public function setNomPrenomInscripteur($_nomPrenomInscripteur)
	{
	    $this->_nomPrenomInscripteur = $_nomPrenomInscripteur;
	}

	public function getNom()
	{
	    return $this->_nom;
	}

	public function setNom($_nom)
	{
	    $this->_nom = $_nom;
	}

	public function getParticipants()
	{
	    return $this->_participants;
	}

	public function setParticipants(Application_Model_Participants $_participants = null)
	{
	    $this->_participants = $_participants;
	}

	public function getInscription()
	{
	    return $this->_inscription;
	}

	public function setInscription(Application_Model_InscriptionTournoi $_inscription = null)
	{
	    $this->_inscription = $_inscription;
	}
}