<?php
class Form_Register extends Projet_Form {

	const LOGIN = 'login';
	const PASSWD = 'passwd';
	const PASSWD_CONF = 'passwd_conf';

	public function __construct($sAction) {
		parent::__construct('FormRegister');
		$this->setAction($sAction);
		$this->setSrvMethodes('Application_Service_Login', 'authUser');
		$this->createForm();
	}

	public function createForm() {
		$oUserName = new Projet_Form_Element_Mail(self::LOGIN, array('hosts' => array('polytechnique.edu')));
		$oUserName->setRequired(true)->setAllowEmpty(false)->setLabel("login.mail");

		$oValidatorMdp = new Projet_Validate_Password();

		$oMdp = new Projet_Form_Element_Password(self::PASSWD);
		$oMdp->setRequired(true)->setLabel('login.passwd')
			 ->setAllowEmpty(false)
			 ->addValidator($oValidatorMdp);

		$oMdpConf = new Projet_Form_Element_Password(self::PASSWD_CONF);
		$oMdpConf->setRequired(true)->setLabel('login.passwd_conf')
				 ->addValidator('Identical', false, array('token' => self::PASSWD));

		$this->addElementsWithSubmit(array($oUserName, $oMdp, $oMdpConf), 'form.action.register');
		$this->setDefaultDecorators();
		$this->setAttrib('class', CSS_FORM_MEDIUM);
	}
}