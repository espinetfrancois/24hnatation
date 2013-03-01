<?php

class Form_Individuel extends Projet_Form_Inscription {

	const ID_ACTIVITE = 'activite';
	const DESINSCRIPTION = "desinscription";

	public function __construct($nIdActivite = null) {
		parent::__construct('Individuel');
		$this->createForm((int) $nIdActivite);

		$this->setSrvMethodes('Application_Service_Inscriptions', 'saveIndividuel', 'getIndividuel');
	}

	public function createForm($nIdActivite) {


		$oIdActi = new Projet_Form_Element_Hidden(self::ID_ACTIVITE);
		$oIdActi->setValue($nIdActivite);

		$oInscription = new Projet_Form_Element_Hidden(self::DESINSCRIPTION);

		$this->addElementsWithSubmit(array($oIdActi, $oInscription), 'form.action.suscribe');

		$this->setAttrib('class', CSS_FORM_SMALL);
		$this->setDefaultDecorators();
	}
}