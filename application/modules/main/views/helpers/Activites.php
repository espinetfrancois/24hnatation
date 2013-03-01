<?php

class views_helpers_Activites extends Zend_View_Helper_Abstract {

	protected $aActis = null;
	protected $aJours = array();
	protected $arJours = array();

	const NB_COLORS = 3;

	public function activites(array $aActis = array(), array $aJours = array(), $isAdmin=false) {
		$this->aActis = $aActis;

		$this->generateJours($aJours);
		$this->addActivites($isAdmin);
		$sRes = new Projet_Xml('div', array('class' => 'programme'));
		foreach ($this->aJours as $oJour) {
			$sRes->append($oJour);
		}
		return $sRes->render();
	}

	protected function addActivites($isAdmin) {
		$color = 0;
		foreach ($this->aActis as  $oActi) {
			$oDivActi = new Projet_Xml('div', array('class' => 'activite'));
			$oDivActi->setAttr('color', $color%self::NB_COLORS);
			$oDivActi->setAttr('title', $oActi->getDescription());
			$oTitreActi = new Projet_Xml('span', array('class'  => 'titre'), $oActi->getNom());
			$oDivActi->append($oTitreActi);
			$oDivActi->append($this->generateDates($oActi));
			$this->aJours[$oActi->getDateDebut()]->append($oDivActi);
			if ($oActi->getInscriptible()) {
				$oDivActi->addToAttr('class', 'inscriptible');
			}
			if ($isAdmin) {
				$oDivActi->setAttr('id', 'acti_'.$oActi->getId());
				$oDivActi->addToAttr('class', 'admin');
			}
			$color++;
		}
	}


	protected function generateJours($aJours) {
		foreach ($aJours as $jour) {
			//construction de l'objet xml
			$oJour = new Projet_Xml('div', array('class' => 'jour'));
			$oTitre = new Projet_Xml('span', array('class' => 'titre'), $jour['LIBELLE'].' '.$jour['NO_JOUR'].' '.$jour['MOIS']);
			$oJour->append($oTitre);
			$this->aJours[$jour['ID']] = $oJour;

			//construction d'un tableau de réferences
			$this->arJours[$jour['ID']]['LIBELLE'] = $jour['LIBELLE'];
		}
	}

	protected function generateDates(Application_Model_Activite $oActi) {
		$sPrefix = $this->view->translate('acti.de');
		if ($oActi->getDateDebut() != $oActi->getDateFin()) {
			//acti sur plusieurs jours
			$sLiaison = $this->view->translate('acti.au');
			$sFinActi = $this->arJours[$oActi->getDateFin()]['LIBELLE'].' '.$oActi->getHeureFin();
		} else {
			if ($oActi->getHeureDebut() == $oActi->getHeureFin()) {
				$sPrefix = $this->view->translate("acti.a");
				$sLiaison = "";
				$sFinActi = "";
			} else {
				//acti sur un seul jour
				$sLiaison = $this->view->translate('acti.a');
				$sFinActi = $oActi->getHeureFin();
			}
		}

		$sDebutActi = $oActi->getHeureDebut();


		return new Projet_Xml('span', array('class' => 'dates'), $sPrefix." ".$sDebutActi." ".$sLiaison." ". $sFinActi);
	}



}
