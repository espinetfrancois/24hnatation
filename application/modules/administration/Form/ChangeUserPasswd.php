<?php
class Form_ChangeUserPasswd extends Projet_Form {


	const PASSWD = 'passwd';
	const PASSWD_CONF = 'passwd_conf';


	public function __construct($nIdUtilisateur = 0) {
		parent::__construct('FormModifActivite');
		$this->createForm($nIdUtilisateur);
		$this->setSrvMethodes('Application_Service_Login', 'changeUserPasswd');
	}

	public function createForm($nIdUtilisateur) {

		$oId = new Projet_Form_Element_Hidden(self::ID);
		$oId->setValue($nIdUtilisateur);

		$oMdp = new Projet_Form_Element_Password(self::PASSWD);
		$oMdp->setRequired(true)->setLabel('login.passwd')
			 ->setAllowEmpty(false);

		$oMdpConf = new Projet_Form_Element_Password(self::PASSWD_CONF);
		$oMdpConf->setRequired(true)->setLabel('login.passwd_conf')
			->addValidator('Identical', false, array('token' => self::PASSWD));

		$this->addElementsWithSubmit(array($oId,$oMdp, $oMdpConf), 'form.action.save');
		$this->setDefaultDecorators();

		$this->setAttrib('class', CSS_FORM_MEDIUM);
	}
}