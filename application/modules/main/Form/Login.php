<?php
class Form_Login extends Projet_Form {

	const LOGIN = 'login';
	const PASSWD= 'passwd';
	const LOCATION = "location";

	public function __construct($sAction, $sLocation = "") {
		parent::__construct('FormLogin');
		$this->setAction($sAction)
			 ->setAttrib('id', 'FormLogin');
// 		$this->setSrvMethodes('Application_Service_Login', 'authUser');
		$this->createForm($sLocation);
	}

	public function createForm($sLocation) {
		$oLocation = new Projet_Form_Element_Hidden(self::LOCATION);
		$oLocation->setValue($sLocation);

		$oUserName = new Projet_Form_Element_Mail(self::LOGIN, array('domaine' => array('polytechnique.edu', 'hec.edu', '')));
		$oUserName->setRequired(true)->setLabel("login.mail");

		$oPassWd = new Projet_Form_Element_Password(self::PASSWD);
		$oPassWd->setRequired(true)->setLabel("login.passwd");

		$this->addElementsWithSubmit(array($oLocation,$oUserName, $oPassWd), 'form.action.connect');
		$this->setDefaultDecorators();
		$this->setAttrib('class', CSS_FORM_MEDIUM);
	}
}