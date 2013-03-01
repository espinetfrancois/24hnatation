<?php
class Form_ModifierResultat extends Projet_Form {

	const ACTI = 'Acti';
	const CONTENU = 'Contenu';

	public function __construct(array $aActis = array()) {
		parent::__construct('FormModifResultat');
		$this->createForm($aActis);
		$this->setSrvMethodes('Application_Service_Resultats', 'saveResultat', 'getResultat');
	}

	public function createForm($aActis) {

		$oId = new Projet_Form_Element_Hidden(self::ID);

		$oNom = new Projet_Form_Element_Select(self::ACTI);
		$oNom->setLabel('acti.nom')
			 ->setRequired(true)
			 ->setMultiOptions($aActis);

		$oDesc = new Projet_Form_Element_TextArea(self::CONTENU);
		$oDesc->setLabel('acti.description')
				->setRequired(true);


		$this->addElementsWithSubmit(array($oId,$oNom, $oDesc), 'form.action.save');
		$this->setDefaultDecorators();

		$this->setAttrib('class', CSS_FORM_MEDIUM);
	}
}