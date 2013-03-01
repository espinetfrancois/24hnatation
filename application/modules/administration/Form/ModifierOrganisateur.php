<?php
class Form_ModifierOrganisateur extends Projet_Form {

	const NOM = 'Nom';
	const PRENOM = 'Prenom';
	const EMAIL = 'Email';
	const TELEPHONE = 'Telephone';
	const ROLE = 'Role';

	public function __construct($aRoles, $nIdRole, $nId = null) {
		parent::__construct('FormModifOrganisateur_'.$nIdRole);
		$this->createForm($aRoles,$nIdRole, $nId);
		$this->setSrvMethodes('Application_Service_Contacts', 'saveOrganisateur', 'getOrganisateur');
	}

	public function createForm($aRoles = array(), $nIdRole, $nId) {

		$this->setName($aRoles[$nIdRole]);
		$oId = new Projet_Form_Element_Hidden(self::ID);
		if ($nId !== null) {
			$oId->setValue($nId);
		}
		$oRole = new Projet_Form_Element_Hidden(self::ROLE);
		$oRole->setValue($nIdRole);

		$oNom = new Projet_Form_Element_Text(self::NOM);
		$oNom->setLabel('nom')
			 ->setRequired(true);

		$oPrenom = new Projet_Form_Element_Text(self::PRENOM);
		$oPrenom->setLabel('prenom')
				->setRequired(true);

		$oTel = new Projet_Form_Element_Text(self::TELEPHONE);
		$oTel->setLabel('telephone')
			 ->setRequired(true);

		$this->addElementsWithSubmit(array($oId,$oNom, $oPrenom, $oTel, $oRole), 'form.action.save');
		$this->setDefaultDecorators();

		$this->setAttrib('class', CSS_FORM_SMALL);
	}
}