<?php

class Application_Model_Mapper_InscriptionsIndividuelles extends Projet_Mapper {

	public function __construct() {
		parent::__construct('Application_Model_DbTable_InscriptionsIndividuelles');
	}

	public function getIdInscriptionByUid($uid) {
		$oSelect = $this->getDbTable()->select()->from(array('II' => 'INSCRIPTIONS_INDIVIDUELLES'), array('II.ID'))
		->where('II.UID = ?', $uid);

		return $this->getDbTable()->fetchOne($oSelect);
	}

	public function getAllInscrits($nIdActivite) {
		$oSelect = $this->getDbTable()->select()->setIntegrityCheck(false)
												->from(array('II' => 'INSCRIPTIONS_INDIVIDUELLES'), array('U.UID', 'U.NOM_PRENOM'))
												->joinLeft(array('U' => 'UTILISATEURS'), 'U.UID = II.UID', array())
												->where('II.ID_ACTIVITE = ?', $nIdActivite);

		return $this->getDbTable()->fetchAll($oSelect);
	}

	public function desinscrireById($nId = 0) {
		$this->getDbTable()->delete(array('ID = ?' => $nId));
	}
}