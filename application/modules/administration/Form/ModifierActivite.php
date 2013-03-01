<?php
class Form_ModifierActivite extends Projet_Form {

	const NOM = 'Nom';
	const DESCRIPTION = 'Description';
	const INSCRIPTIBLE = 'Inscriptible';
	const DATE_DEBUT = 'Date_debut';
	const DATE_FIN = 'Date_fin';
	const HEURE_FIN = 'Heure_fin';
	const HEURE_DEBUT = 'Heure_debut';
	const TYPE			= 'Type';

	public function __construct(array $aJours = array(), array $aHeures  = array(), array $aTypesActis = array(), $bIsInscriptible = false) {
		parent::__construct('FormModifActivite');
		$this->createForm($aJours, $aHeures, $bIsInscriptible, $aTypesActis);
		$this->setSrvMethodes('Application_Service_Activites', 'saveActivite', 'getActivite');
	}

	public function createForm($aJours, $aHeures, $bIsInscriptible, $aTypesActis) {

		$oId = new Projet_Form_Element_Hidden(self::ID);

		$oNom = new Projet_Form_Element_Text(self::NOM);
		$oNom->setLabel('acti.nom')
			 ->setRequired(true)
			 ->setAllowEmpty(false)
			 ->addValidator('StringLength', false, array('max' => 200, 'min' => 3));

		$oDesc = new Projet_Form_Element_TextArea(self::DESCRIPTION);
		$oDesc->setLabel('acti.description')
				->setRequired(true)
				->setAllowEmpty(false)
				->addValidator('StringLength', false, array('max' => 1000, 'min' => 10));

		$oDateDebut = new Projet_Form_Element_Select(self::DATE_DEBUT);
		$oDateDebut->setLabel('date.debut')
			 ->setRequired(true)
			 ->setMultiOptions($aJours);

		$oHeureDebut = new Projet_Form_Element_Select(self::HEURE_DEBUT);
		$oHeureDebut->setRequired(true)
					->setMultiOptions($aHeures)
					->setLabel('heure.debut');


		$oDateFin = new Projet_Form_Element_Select(self::DATE_FIN);
		$oDateFin->setLabel('date.fin')
				->setRequired(true)
				->setMultiOptions($aJours);

		$oHeureFin = new Projet_Form_Element_Select(self::HEURE_FIN);
		$oHeureFin->setRequired(true)
		->setMultiOptions($aHeures)
		->setLabel('heure.fin');

		$oInscriptible = new Projet_Form_Element_Radio(self::INSCRIPTIBLE);
		$oInscriptible->setLabel('is.inscriptible')
					  ->setSeparator(" ")
					  ->setMultiOptions(array( 0 => 'non',	1 => 'oui'));

		$oType	= new Projet_Form_Element_Select(self::TYPE);
		$oType->setLabel('acti.type')
			  ->setMultiOptions($aTypesActis);

		$this->addElementsWithSubmit(array($oId,$oNom, $oDesc, $oDateDebut, $oHeureDebut, $oDateFin, $oHeureFin, $oInscriptible, $oType), 'form.action.save');
		$this->setDefaultDecorators();

		$this->setAttrib('class', CSS_FORM_MEDIUM);
	}
}