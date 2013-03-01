<?php

/**
 * FIXME : get an array
 * TODO : fixit
 * @author francois.espinet
 *
 */
class Projet_Validate_Password extends Zend_Validate_Abstract {

	const PASSWD_INVALID = 'rules';
	const PASSWD_RULES_NUMBER = "rule1";
	const PASSWD_RULES_LENGTH = 'rule2';

	public function __construct() {
		$this->_messageTemplates[self::PASSWD_INVALID] = "Votre mot de passe doit comporter les éléments suivants pour des raisons de sécurité (DSI) :";
		$this->_messageTemplates[self::PASSWD_RULES_NUMBER] = "commencer par 4 chiffres compris entre 1 et 9999";
		$this->_messageTemplates[self::PASSWD_RULES_LENGTH] = "être compris entre 5 et 12 caractères";
	}

	public function isValid($value) {
		$vstring = new Zend_Validate_StringLength(array('min' => 5, 'max' => 12));
		$sres = $vstring->isValid($value);

		$numbers = substr($value, 0, 4);


		$vnumber = new Zend_Validate_Between(array('min' => 1, 'max' => 9999));
		$nres = $vnumber->isValid($numbers);

// 		$rest = substr($string, 4, -1);
		if (! ($sres && $nres)) {
			$this->_error(self::PASSWD_INVALID);
			if (!$sres) {
				$this->_error(self::PASSWD_RULES_LENGTH);
			}
			if (!$nres) {
				$this->_error(self::PASSWD_RULES_NUMBER);
			}
		}
		return $sres && $nres;
	}
}
