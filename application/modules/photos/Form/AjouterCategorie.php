<?php

class Form_AjouterCategorie extends Projet_Form {

	const CATEGORIE = 'Categorie';

	public function __construct() {
		parent::__construct('SelectionCategorie');
		$this->createForm();

		$this->setSrvMethodes('Application_Service_Photos', 'ajouterCategorie');
	}

	public function createForm() {

		$oCategorie = new Projet_Form_Element_Text(self::CATEGORIE);
		$oCategorie->setRequired(true);
		$oCategorie->setLabel('cat.nom')
				   ->setAllowEmpty(false)
				   ->addValidator('StringLength', false, array('max' => 100));

		$this->addElementsWithSubmit(array($oCategorie), 'form.action.add');

		$this->setAttrib('class', CSS_FORM_SMALL);
		$this->setDefaultDecorators();
	}


}