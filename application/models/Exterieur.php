<?php

class Application_Model_Exterieur extends Application_Model_Utilisateur {

	protected $_mdp = null;
	protected $_salt = null;
	protected $_challenge = null;
	protected $_valid = false;

	public function prepareForInscription() {
		$this->assignChallenge();
		$this->assignSalt();
	}

	public function getMdp()
	{
		return $this->_mdp;
	}

	public function setMdp($_mdp, $sSalt = null)
	{
		$salt = ($this->_salt ? $this->_salt :  $sSalt);
		if (!$salt) {
			throw new Exception('no.salt');
		}
		$this->_mdp = hash('sha256', $_mdp.$salt, false);
	}

	public function getSalt()
	{
	    return $this->_salt;
	}

	public function setSalt($_salt)
	{
	    $this->_salt = $_salt;
	}

	public function assignSalt() {
		$this->_salt = substr(md5(uniqid(Zend_Controller_Front::getInstance()->getRequest()->getServer('REMOTE_ADDR'), false)), -10);
	}


	public function getChallenge()
	{
	    return $this->_challenge;
	}

	public function setChallenge($_challenge)
	{
	    $this->_challenge = $_challenge;
	}

	public function assignChallenge() {
		$this->_challenge = substr(md5(uniqid(Zend_Controller_Front::getInstance()->getRequest()->getServer('REMOTE_ADDR'), false)), -20);
	}

	public function getValid()
	{
	    return $this->_valid;
	}

	public function setValid($_valid)
	{
	    $this->_valid = (bool) $_valid;
	}

	public function isValid() {
		return $this->getValid();
	}
}