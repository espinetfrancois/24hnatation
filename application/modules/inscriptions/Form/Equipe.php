<?php

class Form_Equipe extends Projet_Form_Inscription {

	const MEMBRES = 'membres';
	const ID_ACTIVITE = "activite";
	const NOM_EQUIPE = "nom_equipe";

	public function __construct($nIdActivite = null) {
		parent::__construct('Equipe');
		$this->createForm((int) $nIdActivite);

		$this->setSrvMethodes('Application_Service_Inscriptions', 'saveEquipe', 'getEquipe');
	}

	public function createForm($nIdActivite) {

		$oIdActi = new Projet_Form_Element_Hidden(self::ID_ACTIVITE);
		$oIdActi->setValue($nIdActivite);

		$oNomEquipe = new Projet_Form_Element_Text(self::NOM_EQUIPE);
		$oNomEquipe->setRequired(true)
				   ->setLabel('inscriptions.equipe.nom');

		$oMembres = new Projet_Form_Element_MultiInput(self::MEMBRES, array('boutons' => new Projet_Form_Element_RemAjBoutons(self::MEMBRES)));
		$oMembres->setLabel('inscriptions.equipe.membres');

		$this->addElementsWithSubmit(array($oIdActi,$oNomEquipe, $oMembres), 'form.action.add');

		$this->setAttrib('class', CSS_FORM_MEDIUM);
		$this->setDefaultDecorators();
	}
}