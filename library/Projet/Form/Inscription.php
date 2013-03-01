<?php

class Projet_Form_Inscription extends Projet_Form {

	/**
	 * @author francois.espinet
	 * @param unknown $name
	 * @param array $option
	 */
	public function __construct($name, array $option = array()) {
		parent::__construct($name, $option);
		$this->addElement($this->getIdElement());

	}

	protected function getIdElement() {
		return new Projet_Form_Element_Hidden(self::ID);
	}

}