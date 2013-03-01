<?php

/**
 * FIXME : get an array
 * TODO : fixit
 * @author francois.espinet
 *
 */
class Projet_Validate_Hosts extends Zend_Validate_Hostname {

	const HOST_NOT_ALLOWED = "host_not_allowed";

	protected $_allowedHosts = array();
	protected $_sAllowedHosts = "";

	public function __construct($options) {
		if (isset($options['hosts'])) {
			$this->setAllowedHosts($options['hosts']);
			unset($options['hosts']);
		}

		parent::__construct($options);
		$this->_messageTemplates[self::HOST_NOT_ALLOWED] = ("'%value%' is not among the allowed hostname values : %hosts%");
		$this->_messageVariables['hosts'] ='_sAllowedHosts';

		$this->_sAllowedHosts = join(', ', $this->_allowedHosts);
	}

	public function isValid($value) {
		$res =  parent::isValid($value);
		if ($res && !in_array($value, $this->_allowedHosts)) {
			$this->_error(self::HOST_NOT_ALLOWED, $value);
			return false;
		}

		return $res;
	}

	public function setAllowedHosts($aHosts = array()) {
		$this->_allowedHosts = $aHosts;
	}
}
