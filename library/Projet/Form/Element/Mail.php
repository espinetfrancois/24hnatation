<?php

class Projet_Form_Element_Mail extends Projet_Form_Element_Text {

	public function __construct($name, $aOptions = array()) {
		parent::__construct($name);

		if (isset($aOptions['hosts'])) {
			$host = new Projet_Validate_Hosts(array('hosts' => $aOptions['hosts']));
			$validator = new Zend_Validate_EmailAddress(array('domain' => true, 'hostname' => $host));
		} else {
			$validator = new Zend_Validate_EmailAddress(array('domain' => true));
		}


		$this->addValidator($validator);

		$this->setAttrib('class', $this->getAttrib('class') . ' '
						. CSS_CHAMP_MAIL);
	}

}
