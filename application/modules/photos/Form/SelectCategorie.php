<?php

class Form_SelectCategorie extends Projet_Form {

	const CATEGORIE = 'Categorie';

	public function __construct($aCategories) {
		parent::__construct('SelectionCategorie');
		$this->createForm($aCategories);
	}

	public function createForm($aCategories = array()) {

		$oCategorie = new Projet_Form_Element_Select(self::CATEGORIE);
		$oCategorie->addMultiOption(0, Projet_DataHelper::translate("categories.toutes"));
		$oCategorie->addMultiOptions($aCategories);
		$oCategorie->setLabel('form.categorie');

		$this->addElement($oCategorie);

		$this->setAttrib('class', CSS_FORM_SMALL);
		$this->setDefaultDecorators();
	}


}