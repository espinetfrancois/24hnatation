<?php

class Application_Model_Resultat extends Projet_Entite {

	protected $_contenu;
	protected $_id_activite;
	protected $_nom_activite;


	public function getContenu()
	{
	    return $this->_contenu;
	}

	public function setContenu($_contenu)
	{
	    $this->_contenu = $_contenu;
	}

	public function getIdActivite()
	{
	    return $this->_id_activite;
	}

	public function setIdActivite($_id_activite)
	{
	    $this->_id_activite = $_id_activite;
	}

	public function getNomActivite()
	{
	    return $this->_nom_activite;
	}

	public function setNomActivite($_nomActivite)
	{
	    $this->_nom_activite = $_nomActivite;
	}
}