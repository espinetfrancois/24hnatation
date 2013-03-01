<?php

class Form_Tournoi extends Projet_Form_Inscription {

	const MEMBRES = 'membres';
	const ID_ACTIVITE = "activite";
	const NOM_EQUIPE = "nom_equipe";


	public function __construct($nIdActivite = null) {
		parent::__construct('Tournoi');
		$this->createForm((int) $nIdActivite);

		$this->setSrvMethodes('Application_Service_Inscriptions', 'saveTournoi', 'getTournoi');
	}

	public function createForm($nIdActivite) {

		$oIdActi = new Projet_Form_Element_Hidden(self::ID_ACTIVITE);
		$oIdActi->setValue($nIdActivite);

		$oNomEquipe = new Projet_Form_Element_Text(self::NOM_EQUIPE);
		$oNomEquipe->setRequired(true)
		->setLabel('inscriptions.tournoi.nom');

		$oMembres = new Projet_Form_Element_MultiInput(self::MEMBRES, array('boutons' => new Projet_Form_Element_RemAjBoutons(self::MEMBRES) ));
		$oMembres->setLabel('inscriptions.tournoi.membres');

		$this->addElementsWithSubmit(array($oIdActi,$oNomEquipe, $oMembres), 'form.action.add');

		$this->setAttrib('class', CSS_FORM_MEDIUM);
		$this->setDefaultDecorators();
	}
}