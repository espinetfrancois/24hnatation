<?php

class views_helpers_Resultats extends Zend_View_Helper_Abstract {

	protected $aResultats = null;

	const NB_COLORS = 3;

	public function resultats(array $aResultats = array(), $isAdmin=false) {
		$this->aResultats = $aResultats;

		$oRes = new Projet_Xml('div', array('class' => 'resultats'));
		$oRes->append($this->addResultats($isAdmin));
		return $oRes->render();
	}

	protected function addResultats($isAdmin) {
		$color = 0;
		$aRet = array();
		foreach ($this->aResultats as  $oResultat) {
			$oDivActi = new Projet_Xml('div', array('class' => 'resultat'));
			$oDivActi->setAttr('color', $color%self::NB_COLORS);
			$oTitreActi = new Projet_Xml('span', array('class'  => 'titre'), $oResultat->getNomActivite());
			$oDivActi->append(array($oTitreActi, $oResultat->getContenu()));
			if ($isAdmin) {
				$oDivActi->setAttr('id', 'acti_'.$oResultat->getId());
				$oDivActi->addToAttr('class', 'admin');
			}
			$aRet[] = $oDivActi;
			$color++;
		}
		return $aRet;

	}

}
