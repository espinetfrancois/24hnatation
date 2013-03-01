<?php

class Form_AjouterPhoto extends Projet_Form {

	const CATEGORIE = 'Categorie';
	const FILE = 'Fichier';

	public function __construct($aCategories) {
		parent::__construct('SelectionCategorie');
		$this->createForm($aCategories);
		$this->setEnctype(self::ENCTYPE_URLENCODED);
		$this->setSrvMethodes('Application_Service_Photos', 'ajouterPhoto');
	}

	public function createForm($aCategories) {

		$oFile = new Projet_Form_Element_File(self::FILE);
		$oFile->setRequired(true)
			  ->setLabel('img.upload')
			  ->addValidator('Count', false, 1)
			  ->addValidator('Size', false, array('min' => '0B', 'max' => '5MB'))
			  ->addValidator('IsImage', false)
			  ->setDestination(UPLOAD_PATH);

		$oCategorie = new Projet_Form_Element_Select(self::CATEGORIE);
		$oCategorie->setRequired(true);
		$oCategorie->setLabel('photo.cat');
		$oCategorie->setMultiOptions($aCategories);

		$this->addElementsWithSubmit(array($oFile,$oCategorie), 'form.action.add');

		$this->setAttrib('class', CSS_FORM_MEDIUM);
		$this->setDefaultDecorators();
	}


}