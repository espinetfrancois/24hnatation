<?php

/** @brief	element de formulaire trigramme
 *
 * Element de formulaire trigramme
 * ---- à utiliser lorsque l'élement à rentrer est un trigramme quelconque ----
 *
 * cf form/element/multicase.js pour l'API javascript
 *
 * @author	francoisespinet
 */
class Projet_Form_Element_MultiInput extends Zend_Form_Element_Multi {

	/**
	 * Tableau des erreurs relatives au champ input
	 * @var	array
	 */
	protected $_InvalidChamps = array();
	protected $_boutons = null;

	public function __construct($sId = 'MultiInput', $aOptions = array(), $sType = '') {
		parent::__construct($sId);
		$this->setRegisterInArrayValidator(false);
		$this->setDecorators(array('MultiInput', 'Errors'));
		//s'il s'agit d'un type de champ mail, alors on ajoute le validateur MultiMail
		if ($sType == 'mail') {
			$this->addValidator(new Projet_Validate_MultiMail(), true, array());
		}
		if (array_key_exists('boutons', $aOptions)) {
			$this->setBoutons($aOptions['boutons']);
			unset($aOptions['boutons']);
		}
	}

	/**
	 * @brief	Redéfinition de la méthode isValid pour permettre l'affichage des erreurs propres à chaque champ
	 * @see Zend_Form_Element_Multi::isValid()
	 * @author		francoisespinet
	 * @version		13 avr. 2012 - 11:51:14
	 */
	public function isValid($value, $context = null) {
        $aResult = parent::isValid($value, $context);
        /*
         * Dans le cas ou le validateur MultiMail est présent (et que le formulaire à des erreurs),
         * on transfére ces erreur dans les atributs de l'objet multimail pour y acceder dans le décorateur
         */
         if (($oValid = $this->getValidator('MultiMail')) && $this->hasErrors()) {
         	$this->_InvalidChamps = $oValid->getAdressesInvalides();
         }
         return $aResult;
    }
	/**
	 * @brief		Getter de $this->_InvalidChamps
	 * @return	the $_InvalidChamps
	 */
	public function getInvalidChamps() {
		return $this->_InvalidChamps;
	}

	/**
	 * @brief		Setter de $this->_InvalidChamps
	 * @param	$_InvalidChamps the $_InvalidChamps to set
	 */
	public function setInvalidChamps($_InvalidChamps) {
		$this->_InvalidChamps = $_InvalidChamps;
	}

	public function getBoutons()
	{
	    return $this->_boutons;
	}

	public function setBoutons($_boutons)
	{
	    $this->_boutons = $_boutons;
	}

	public function hasBoutons() {
		return ($this->_boutons !== null);
	}
}
