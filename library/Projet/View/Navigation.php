<?php

/**
 * Création d'un menu de navigation Zend
 *
 * @category   Projet
 * @package    library_Projet
 * @subpackage View
 */
class Projet_View_Navigation extends Zend_View_Helper_Navigation {

	// Stockage de l'objet Zend_Navigation_Container
	protected $oMenu;

	// Stockage de l'objet Zend_Config_Xml
	protected $oMenuXml;

	// Booléen affirmant la présence d'un menu dans les résultats
	protected $bPresence;

	/**
	 * Constructeur de classe
	 *
	 * @param $section
	 * @param $xml
	 */
	public function __construct($section, $xml) {
		$this->createMenu($section, $xml);
	}

	/**
	 * Création d'un menu de navigation Zend grâce aux arguments désignant le fichier de menu et la section à utiliser.
	 *
	 * @param string $xml le fichier xml a lancer. Défaut = "/layouts/scripts/navigation.xml"
	 * @param string $section la section de menu à lancer depuis le fichier.
	 *
	 * @var objet Zend_Navigation $oMenu
	 */
	public function createMenu($section, $xml) {
		try {
			// On vérifie la présence de menu.
			$this->bPresence = $this->hasMenu($section, $xml);

			// Si c'est le cas, on crée le menu avec Zend_Navigation.
			if ($this->bPresence) {
				// Page customisé qui dit bien si la page est active en fonction de la route
				Zend_Navigation_Page::setDefaultPageType('Projet_Navigation_Page');

				$this->oMenu = new Zend_Navigation($this->oMenuXml);
	 		}
		} catch (Zend_Navigation_Exception $e) {
			throw new Zend_Exception("Chargement du menu impossible.", "", $e);
		}
	}

	/**
	 * On vérifie si le menu existe dans la demande ou s'il est vide.
	 *
	 * @param string $xml le fichier xml a lancer.
	 * @param string $section la section de menu à lancer depuis le fichier.
	 *
	 * @return boolean
	 */
	public function hasMenu($section, $xml) {

		try {
			$this->oMenuXml = new Zend_Config_Xml($xml, $section);
			$sMenuPresent = $this->oMenuXml->current();

			if (!empty($sMenuPresent)) {
			  	return true;
			} else {
				return false;
			}
		} catch(Exception $e) {
			return false;
		}
	}

	/**
	 * Getter pour la variable de Présence des menus
	 *
	 * @return boolean $bPresence
	 */
	public function isValid() {
		return $this->bPresence;
	}

	/**
	 * Getter pour l'objet menu Zend_Navigation
	 *
	 * @return Zend_Navigation $oMenu (objet)
	 */
	public function getMenu() {
		return $this->oMenu;
	}
}
