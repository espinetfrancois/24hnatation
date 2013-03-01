<?php

class Application_Model_Mapper_Resultats extends Projet_Mapper {

	public function __construct() {
		parent::__construct('Application_Model_DbTable_Resultats');
	}

	public function getFullResultats() {
		$oSelect = $this->getDbTable()->select()->setIntegrityCheck(false)
												->from(array('R' => 'RESULTATS'), array('R.CONTENU', 'A.NOM', 'R.ID_ACTIVITE','R.ID'))
												->joinLeft(array('A' => 'ACTIVITES'), 'R.ID_ACTIVITE = A.ID', array())
												->order('A.NOM');

		return $this->getDbTable()->fetchAll($oSelect);
	}

// 	public function find($nIdActivite) {
// 		$oSelect = $this->getDbTable()->select()->from(array('R' => 'RESULTATS'), array('R.ID_ACTIVITE', 'R.CONTENU'));

// 		$aRes = $this->getDbTable()->fetchRow($oSelect)->toArray();
// 		if (count($aRes) != 2) {
// 			return false;
// 		} else {
// 			return $aRes;
// 		}
// 	}
}