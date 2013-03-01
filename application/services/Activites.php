<?php

class Application_Service_Activites {

	protected $aHeures = null;

	public function saveActivite($aData) {
		$oMapper = new Application_Model_Mapper_Activites();
		$oActi = new Application_Model_Activite();

		$oActi->setDescription($aData[Form_ModifierActivite::DESCRIPTION]);
		$oActi->setNom($aData[Form_ModifierActivite::NOM]);
		$oActi->setId($aData[Form_ModifierActivite::ID]);
		$oActi->setInscriptible($aData[Form_ModifierActivite::INSCRIPTIBLE]);

		if ($oActi->getInscriptible()) {
			$oActi->setType($aData[Form_ModifierActivite::TYPE]);
		}
		//on ne change les dates que si les inscriptions ne sont pas encore ouvertes ou si l'activite n'est pas inscriptible
		if ($oActi->getType() != ACTI_TYPE_FILROUGE || $oActi->getType() != ACTI_TYPE_BAPTEME || !STATE_INSCRIPTIONS) {
			$oActi->setDateDebut($aData[Form_ModifierActivite::DATE_DEBUT]);
			$oActi->setDateFin($aData[Form_ModifierActivite::DATE_FIN]);
			$oActi->setHeureDebut($aData[Form_ModifierActivite::HEURE_DEBUT]);
			$oActi->setHeureFin($aData[Form_ModifierActivite::HEURE_FIN]);
		}
		//on récupère l'id de l'activite
		$oMapper->save($oActi);
		//si les inscriptions ne sont pas encore ouvertes
		if ($oActi->getType() !== null && !STATE_INSCRIPTIONS ) {
			if ( $oActi->getType() == ACTI_TYPE_FILROUGE ) {
				$this->createCreneauxFilRouge($oActi);
			} elseif ( $oActi->getType() == ACTI_TYPE_BAPTEME ) {
				$this->createCreneauxBapteme($oActi);
			}
		}
	}

	protected function createCreneauxBapteme(Application_Model_Activite $oActi) {
		$this->createCreneaux($oActi, 3*DUREE_CRENAUX, ACTI_TYPE_BAPTEME_MAX_PAR_CRENEAUX);
	}

	protected function createCreneauxFilRouge(Application_Model_Activite $oActi) {
		$this->createCreneaux($oActi);
	}

	protected function createCreneaux(Application_Model_Activite $oActi,$duree_creneau = DUREE_CRENAUX, $multiplier = 1) {
		$oMapper = new Application_Model_Mapper_RefCreneaux();
		$oMapper->suppressionCreneauxByIdActivite($oActi->getId());
		$aJours = range($oActi->getDateDebut(), $oActi->getDateFin());
		$aCrenaux = $this->getHeureFromToWithJours($aJours, $oActi->getHeureDebut(), $oActi->getHeureFin(), $duree_creneau);
		$oCreneau = new Application_Model_Creneau();
		$oCreneau->setIdActivite($oActi->getId());
		$oCreneau->setIdJour($oActi->getDateDebut());
		foreach ($aCrenaux as $idJour => $aCrenauxJours) {
			$first = true;
			$oCreneau->setIdJour($idJour);
			$oCreneau->setHeureFin();
			foreach ( $aCrenauxJours as $heure => $sHeure ) {
				//initialisation
				if ($first) {
					$oCreneau->setHeureFin($heure);
					$first = false;
					continue;
				}
				$oCreneau->setHeureDebut($oCreneau->getHeureFin());
				$oCreneau->setHeureFin($heure);
				for ($i=0; $i<$multiplier;$i++) {
					$oCreneau->setId(null);
					$oMapper->save($oCreneau);
				}
			}
		}
	}

	public function getActivite($nId) {
		$oMapper = new Application_Model_Mapper_Activites();
		$aResult = $oMapper->find($nId);
		$aResult = $aResult[0];
		$ret[Form_ModifierActivite::ID] = $nId;
		$ret[Form_ModifierActivite::NOM] = $aResult['NOM'];
		$ret[Form_ModifierActivite::DESCRIPTION] = $aResult['DESCRIPTION'];
		$ret[Form_ModifierActivite::DATE_DEBUT] = $aResult['DATE_DEBUT'];
		$ret[Form_ModifierActivite::DATE_FIN] = $aResult['DATE_FIN'];
		$ret[Form_ModifierActivite::HEURE_DEBUT] = $aResult['HEURE_DEBUT'];
		$ret[Form_ModifierActivite::HEURE_FIN] = $aResult['HEURE_FIN'];
		$ret[Form_ModifierActivite::INSCRIPTIBLE] = $aResult['INSCRIPTIBLE'];
		$ret[Form_ModifierActivite::TYPE] = $aResult['TYPE'];
		return $ret;
	}

	public function getFullActivites() {
		$oMapper = new Application_Model_Mapper_Activites();
		return $this->processRawActivites($oMapper->getFullActivites());
	}

	protected function processRawActivites($aResults) {
		$ret = array();
		//calclul du tableau de référence des heures
		$this->setHeures();
		foreach($aResults as $result) {
			$ret[] =$this->processRawActivite($result);
		}
		return $ret;
	}

	protected function processRawActivite($result) {
		$oActi = new Application_Model_Activite();
		$oActi->setDateDebut($result['DATE_DEBUT']);
		$oActi->setDateFin($result['DATE_FIN']);
		$oActi->setHeureDebut($this->aHeures[$result['HEURE_DEBUT']]);
		$oActi->setHeureFin($this->aHeures[$result['HEURE_FIN']]);
		$oActi->setDescription($result['DESCRIPTION']);
		$oActi->setNom($result['NOM']);
		$oActi->setInscriptible($result['INSCRIPTIBLE']);
		$oActi->setType($result['TYPE']);
		// 			$ret[$oActi->getDateDebut()][] = $oActi;
		$oActi->setId($result['ID']);
		return $oActi;
	}

	public function getInscriptibleActivites() {
		$oMapper = new Application_Model_Mapper_Activites();
		return $this->processRawActivites($oMapper->getInscriptibleActivites());
	}

	public function getActiviteInscriptibleById($nIdActi) {
		$oMapper = new Application_Model_Mapper_Activites();
		$aRes = $oMapper->getFullActiviteInscriptibleById($nIdActi);
		return $this->processRawActivite($aRes[0]);
	}

	public function getJours() {
		$oMapper = new Application_Model_Mapper_RefJours();
		return $oMapper->getLibelles();
	}

	public function setHeures() {
		if ($this->aHeures == null) {
			$this->aHeures = $this->getHeures();
		}
	}

	public function getHeures() {
		$aHeures = array();
		for ($heure = 0; $heure<24; $heure++) {
			for ($minutes=0; $minutes<60; $minutes+= DUREE_CRENAUX) {
				$sMinute = $minutes;
				$sHeure = $heure;
				if ($heure < 10) {
					$sHeure = "0".$heure;
				}
				if ($minutes < 10) {
					$sMinute = "0".$minutes;
				}
				$aHeures[$sHeure.":".$sMinute] = $sHeure."h".$sMinute;
			}
		}
		return $aHeures;
	}


	protected function getHeureFromToWithJours($aJours, $sHeureDebut = "00:00", $sHeureFin = "23:50", $duree_creneau = DUREE_CRENAUX) {
		$aHeures = array();
		if (count($aJours) == 1) {
			$aHeures[$aJours[0]] = $this->getHeureFromTo($sHeureDebut, $sHeureFin, $duree_creneau);
			return $aHeures;
		}
		foreach ($aJours as $nJour => $idJour) {
			if ($nJour == 0)  {
				$aHeures[$idJour] = $this->getHeureFromTo($sHeureDebut, "23:59", $duree_creneau);
				continue;
			} elseif ($nJour == count($aJours)-1) {
				$aHeures[$idJour] = $this->getHeureFromTo("00:00",  $sHeureFin, $duree_creneau);
				continue;
			}
			$aHeures[$idJour] = $this->getHeureFromTo("00:00", "23:59", $duree_creneau);
		}
		return $aHeures;
	}

	protected function getHeureFromTo($sHeureDebut = "00:00", $sHeureFin = "23:50", $duree_creneau = DUREE_CRENAUX) {
		//récupération des heure et minutes en numéral
		$aHeureDebut = explode(':', $sHeureDebut);
		$aHeureFin	 = explode(':', $sHeureFin);

		$iHeureDebut = (int) $aHeureDebut[0];
		$iMinutesDebut = (int) $aHeureDebut[1];

		$iHeureFin = (int) $aHeureFin[0];
		$iMinutesFin = (int) $aHeureFin[1];

		if ($iHeureFin == "00:00" && $iHeureDebut == "00:00") {
			return;
		}
		//cas ou l'heure de fin est le lendemain
		if ( ($iHeureFin < $iHeureDebut) || ($iHeureFin == $iHeureDebut && $iMinutesDebut>$iMinutesFin)
				||  ($iHeureFin == $iHeureDebut && $iMinutesDebut == $iMinutesFin)) {
			/*
			 * double appel :
			 * première tableau de l'heure de debut à 23:50
			 * deuxième tableau de 00:00 à l'heure de fin
			 */
			return array_merge($this->getHeureFromTo($sHeureDebut, '23:50', $duree_creneau), $this->getHeureFromTo("00:00", $sHeureFin, $duree_creneau));
		}
		if ($iHeureFin == $iHeureDebut && $iMinutesDebut <= $iMinutesFin) {
		}


		$aHeures = $this->getMinutesFromTo($iHeureDebut, $iMinutesDebut, 60, $duree_creneau);
		for ($heure = $iHeureDebut+1; $heure<$iHeureFin; $heure++) {
			$aHeures = array_merge($aHeures, $this->getMinutesFromTo($heure, 0, 60, $duree_creneau));
		}
		return array_merge($aHeures, $this->getMinutesFromTo($iHeureFin, 0, $iMinutesFin+$duree_creneau, $duree_creneau));
	}

	protected function getMinutesFromTo($heure, $iMinutesDebut = 0, $iMinutesFin = 60, $duree_creneau = DUREE_CRENAUX) {
		for ($minutes=$iMinutesDebut; $minutes<$iMinutesFin; $minutes+= $duree_creneau) {
			$sMinute = $minutes;
			$sHeure = $heure;
			if ($heure < 10) {
				$sHeure = "0".$heure;
			}
			if ($minutes < 10) {
				$sMinute = "0".$minutes;
			}
			$aHeures[$sHeure.":".$sMinute] = $sHeure."h".$sMinute;
		}
		return $aHeures;
	}

	function getTypesActivites() {
		return array(
				ACTI_TYPE_BAPTEME 	=> 'acti.bapteme',
				ACTI_TYPE_CHALLENGE_EQUIPE	=> 'acti.challenge_equipe',
				ACTI_TYPE_FILROUGE	=> 'acti.fil_rouge',
				ACTI_TYPE_TOURNOI	=> 'acti.tournoi',
				ACTI_TYPE_CHALLENGE_INDIVIDUEL => 'acti.challenge_individuel'
				);
	}
}