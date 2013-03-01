<?php

/**
 * Décoration brute des Elements MultiInput
 * Il s'agit des élément qui comporte plusieurs champs input (aux nombre parmétrable par exemple)
 * @author	francoisespinet
 */
class Projet_Form_Decorator_MultiInput extends Projet_Form_Decorator_Abstract {

	const TOPLEVEL_CLASS = 'MultiInput champ';
	const SUBLEVEL_CLASS	= 'champsMultiInput';

	//tableau des adresses invalides
	protected $_aInvalidAdresses = array();

	protected function render_element() {
		//récuperation des attributs utiles
		$oElement = $this->getElement();
		$aValues = $oElement->getValue();
		$sName = $oElement->getName();
		$sTitre = $oElement->getLabel();
		//récuperation des id des adresses invalides
		$this->_aInvalidAdresses = $oElement->getInvalidChamps();

		//création de la div entourante
		$oDiv = new Projet_Xml('div',array('class' => self::TOPLEVEL_CLASS));
		$oDiv->setAttr('id', $sName.'-element');
		//création du label
		$oLabel = new Projet_Xml('label', array('for' => $sName), $sTitre);
		//attachement du label dans la div
		$oDiv->append($oLabel);
		//s'il y à plusieurs champs
		$oDivIn = new Projet_Xml('div', array('class' => self::SUBLEVEL_CLASS));
		$oDiv->append($oDivIn);
		if ($aValues) {
			//on extrait la première adresse au du traitement générique
			$sFirstAdresse = array_shift($aValues);
			//on construit l'input et on l'ajout
			$oInput = new Projet_Xml('input',array('name' => $sName.'[]',
													'type'=> 'text',
													'value' => $sFirstAdresse,
													'id'	=> $sName));
			//on ajoute les erreurs s'il y en a
			$oInput = $this->addErrorDeco($oInput, 0);
			$oDivIn->append($oInput);

			$i=0;
			//on parcours les autres champs et on les construit comme précedement
			foreach ($aValues as $sAdresse) {
				$i++;
				$oInput2 = new Projet_Xml('input', array('name'  => $sName.'[]',
														 'type'  => 'text',
														 'value' => $sAdresse,
														 'id' 	 => $sName.'-'.$i));
				$oInput2 = $this->addErrorDeco($oInput2, $i);
				$oDivIn->append($oInput2);
			}
		} else {
			//s'il n'y avait aucun champ, on construit un champ vide
			$oInput = new Projet_Xml('input',array('name' => $sName.'[]',
												   'type' => 'text',
												   'id'	  => $sName));
			$oInput = $this->addErrorDeco($oInput, 0);
			$oDivIn->append($oInput);
		}
		if ($oElement->hasBoutons()) {
			$oDiv->append($oElement->getBoutons()->render());
		}

		return $oDiv->render();
	}

	/**
	 * @brief	Ajout des erreurs sur les champs incriminés
	 *
	 * @author		francoisespinet
	 * @version		13 avr. 2012 - 12:04:19
	 *
	 * @param 	Symbol_Input $oSymbol le symbol input comme construit
	 * @param 	int $nId l'id du champ incriminé
	 * @return	return_type
	 */
	protected function addErrorDeco(Projet_Xml $oSymbol, $nId = null) {
		//si il y a des erreurs sur cet ensemble de champs
		if ($this->_aInvalidAdresses) {
			//on sauvegarde l'ancien input
			$oInput = $oSymbol;
			//on réécrit le nouveau avec une décoration classique des erreurs
			$oSymbol = new Projet_Xml('span', array('class' => CSS_POS_RELATIVE));
			//s'il y a une erreur sur ce champ en particulier
			if ($nId !== null && in_array($nId, $this->_aInvalidAdresses)) {
				$oSpan = new Projet_Xml('span', array('class' => CSS_INPUT_CHECK_ERROR));
				$oInput->addToAttr('class', CSS_INPUT_ERROR);
			} else {
				//sinon on met ok
				$oSpan = new Projet_Xml('span', array('class' => CSS_INPUT_CHECK_OK));
			}
			//on retourne le symbol décoré
			return $oSymbol->append(array($oInput, $oSpan));
		} else {
			//on renvoie le symbole identique s'il n'y avait pas d'erreur
			return $oSymbol;
		}
	}

}
