<?php

/**
 * Décoration SIMPLE des éléments radio (pratique en ajax)
 *
 * @author	francoisespinet
 * @deprecated
 */
class Projet_Form_Decorator_Radio extends Zend_Form_Decorator_Abstract {

	public function render($sContent) {
		return $this->getElement()->getView()->formRadio($this->getElement()->getName(), $this->getElement()->getValue(),$this->getElement()->getAttribs(),
        $this->getOptions(), "\n");

	}
}
