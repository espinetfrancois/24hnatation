<?php

/**
 * TODO : limiter les champs
 * @author francois.espinet
 *
 */
class Form_FilRouge extends Projet_Form_Inscription {

	const CRENAUX = 'Crenaux';
	const TYPE_INSCRIPTION = 'type_inscription';
	const PERSONNES_INSCRITES = 'Personnes_inscrites';
	const BINET_INSCRIT		= 'Binet_inscrit';
	const ID_ACTIVITE		= 'activite';

	public function __construct(array $aCrenaux = array(),array $aCrenauxPris = array(), array $aTypeInscriptions = array(),$nIdActivite = null) {
		parent::__construct('FilRouge');
		$this->createForm($aCrenaux, $aCrenauxPris, $aTypeInscriptions, $nIdActivite);

		$this->setSrvMethodes('Application_Service_Inscriptions', 'saveFilRouge', 'getFilRouge');
	}

	public function createForm($aCrenaux, $aCrenauxPris, $aTypeInscriptions, $nIdActivite) {

		$oIdActi = new Projet_Form_Element_Hidden(self::ID_ACTIVITE);
		$oIdActi->setValue($nIdActivite);

		$oCrenaux = new Projet_Form_Element_MultiCheckBox(self::CRENAUX);
		$oCrenaux->setValue($aCrenauxPris)
				 ->setLabel('inscriptions.filrouge.selection_crenaux')
				 ->setRequired(true)
				 ->setMultiOptions($aCrenaux)
				 ->setInline(true);
// 				 ->addValidator(new Projet_Validate_BetweenCheckBox(), true, array('min' => 1, 'max' => ACTI_TYPE_FIL_ROUGE_MAX_CRENEAUX));

		$oTypeInscription = new Projet_Form_Element_Radio(self::TYPE_INSCRIPTION);
		$oTypeInscription->setRequired(true)
						 ->setLabel('inscriptions.filrouge.type_inscription')
						 ->setMultiOptions($aTypeInscriptions)
						 ->setSeparator(" ");

		$oButsAddRemPersonnes = new Projet_Form_Element_RemAjBoutons(self::PERSONNES_INSCRITES);


		$oPersonnesInscrites = new Projet_Form_Element_MultiInput(self::PERSONNES_INSCRITES, array('boutons' => $oButsAddRemPersonnes));
		$oPersonnesInscrites->setRequired(false)
							->setLabel('inscriptions.filrouge.personnes_inscrites');

// 		$oBinetInscrit = new Projet_Form_Element_Select(self::BINET_INSCRIT);
// 		$oBinetInscrit->setLabel('inscriptions.filrouge.binet_inscrit')
// 					  ->setMultiOptions($aBinets)
// 					  ->setRegisterInArrayValidator(false);

		$oBinetInscrit = new Projet_Form_Element_Text(self::BINET_INSCRIT);
		$oBinetInscrit->setLabel('inscriptions.filrouge.binet_inscrit');

		$this->addElementsWithSubmit(array($oIdActi, $oCrenaux, $oTypeInscription, $oPersonnesInscrites, $oBinetInscrit), 'form.action.suscribe');

		$this->setAttrib('class', CSS_FORM_LARGE);
		$this->setDefaultDecorators();
	}
}