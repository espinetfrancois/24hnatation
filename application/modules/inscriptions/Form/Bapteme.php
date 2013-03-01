<?php

class Form_Bapteme extends Projet_Form_Inscription {

	const CRENAUX 			= 'Crenaux';
	const ID_ACTIVITE		= 'activite';
	const DESINSCRIPTION	= 'desinscription';
	const IS_DESINSCRIPTION	 = "is_desinscription";

	public function __construct(array $aCrenaux = array(),array $aCrenauxPris = array(), $nIdActivite = null) {
		parent::__construct('Bapteme');
		$this->createForm($aCrenaux, $aCrenauxPris, (int) $nIdActivite);

		$this->setSrvMethodes('Application_Service_Inscriptions', 'saveBapteme', 'getBapteme');
	}

	public function createForm($aCrenaux, $aCrenauxPris, $nIdActivite) {

		$oIdActi = new Projet_Form_Element_Hidden(self::ID_ACTIVITE);
		$oIdActi->setValue($nIdActivite);

		$oDesinscriptionC = new Projet_Form_Element_Hidden(self::IS_DESINSCRIPTION);

		$oCrenaux = new Projet_Form_Element_Radio(self::CRENAUX, array('ajax' => 'div'));
		$oCrenaux->setValue($aCrenauxPris)
				 ->setLabel('inscriptions.bapteme.selection_creneau')
				 ->setMsgEmpty("inscriptions.bapteme.no_more_creneaux")
				 ->setMultiOptions($aCrenaux)
				 ->setSeparator(' ');

		$oDesinscription = new Zend_Form_Element_Button(self::DESINSCRIPTION);
		$oDesinscription->setLabel("inscriptions.desinscription");

		$this->addElementsWithSubmit(array($oIdActi, $oCrenaux, $oDesinscription, $oDesinscriptionC), 'form.action.suscribe');

		$this->setAttrib('class', CSS_FORM_LARGE);
		$this->setDefaultDecorators();
	}

}