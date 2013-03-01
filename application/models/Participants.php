<?php

class Application_Model_Participants {

	public function __construct($sNomPrenoms = "") {
		$this->setNomPrenoms($sNomPrenoms);
	}
	protected $_nomPrenoms = array();

	public function getNomPrenoms($separator = ', ')
	{
	    return implode($separator, $this->_nomPrenoms);
	}

	public function setNomPrenoms($_nomPrenoms)
	{
	    $this->_nomPrenoms = explode(SQL_CONCAT_SEPARATOR, $_nomPrenoms);
	}
}
