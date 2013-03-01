<?php
class Form_FullRegister extends Projet_Form {

	const LOGIN = 'login';

	const NOM = "nom";
	const PRENOM = "prenom";
	const UID	= "uid";

	const PASSWD = 'passwd';
	const PASSWD_CONF = 'passwd_conf';

	public function __construct($sAction = "#") {
		parent::__construct('FormRegister');
		$this->setAction($sAction);
		$this->setSrvMethodes('Application_Service_Login', 'addUserManualy');
		$this->createForm();
	}

	public function createForm() {

		$oNom = new Projet_Form_Element_Text(self::NOM);
		$oNom->setRequired(true)
			 ->setLabel('login.nom')
			 ->addValidator('StringLength', false, array('max' => 50));

		$oPrenom = new Projet_Form_Element_Text(self::PRENOM);
		$oPrenom->setRequired(true)
				->setLabel('login.prenom')
				->addValidator('StringLength', false, array('max' => 50));

		$oUid = new Projet_Form_Element_Text(self::UID);
		$oUid->setLabel('login.uid')
			->addValidator('StringLength', false, array('max' => 101));

		$oUserName = new Projet_Form_Element_Mail(self::LOGIN, array('domaine' => 'polytechnique.edu'));
		$oUserName->setRequired(true)->setLabel("login.mail");

		$oMdp = new Projet_Form_Element_Password(self::PASSWD);
		$oMdp->setRequired(true)->setLabel('login.passwd');

		$oMdpConf = new Projet_Form_Element_Password(self::PASSWD_CONF);
		$oMdpConf->setRequired(true)->setLabel('login.passwd_conf')
				->addValidator('Identical', false, array('token' => self::PASSWD));

		$this->addElementsWithSubmit(array($oNom, $oPrenom, $oUid, $oUserName, $oMdp, $oMdpConf), 'form.action.adduser');
		$this->setDefaultDecorators();
		$this->setAttrib('class', CSS_FORM_LARGE);
	}
}