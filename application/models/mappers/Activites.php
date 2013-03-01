<?php

class Application_Model_Mapper_Activites extends Projet_Mapper {

	public function __construct() {
		parent::__construct('Application_Model_DbTable_Activites');
	}

	public function getFullActivites() {

		return $this->getDbTable()->fetchAll($this->genericSelect());
	}

	public function genericSelect() {
		return $this->getDbTable()->select()->setIntegrityCheck(false)
		->from(array('A' => 'ACTIVITES'), array('A.TYPE','A.ID','A.NOM', 'A.DESCRIPTION', 'A.DATE_DEBUT','A.HEURE_DEBUT' ,'A.DATE_FIN', 'A.HEURE_FIN','A.INSCRIPTIBLE'))
		->order('A.DATE_DEBUT')
		->order('A.HEURE_DEBUT');
	}

	public function getLibelles() {
		return $this->listerIdPair('NOM');
	}

	public function getInscriptibleActivites() {
		return $this->getDbTable()->fetchAll($this->genericSelect()->where('A.INSCRIPTIBLE = ?', 1));
	}

	public function getFullActiviteInscriptibleById($nIdActi) {
		$oSelect = $this->genericSelect()->where('A.ID = ?', $nIdActi)->where('A.INSCRIPTIBLE = ?', 1);

		$aRet = $this->getDbTable()->fetchAll($oSelect);
		if (count($aRet) != 1 ) {
			throw new Projet_Exception_Activite_NotInscriptible();
			return;
		}
		return $aRet;
	}

}