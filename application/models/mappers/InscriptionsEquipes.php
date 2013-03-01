<?php

class Application_Model_Mapper_InscriptionsEquipes extends Projet_Mapper {

	public function __construct() {
		parent::__construct('Application_Model_DbTable_InscriptionsEquipes');
	}

	public function getIdInscriptionByUid($uid) {
		$oSelect = $this->getDbTable()->select()->from(array('IE' => 'INSCRIPTIONS_EQUIPES'), array('IE.ID'))
		->where('IE.UID = ?', $uid);

		return $this->getDbTable()->fetchOne($oSelect);
	}

	public function getAllEquipesWithPersonnes($nIdActivite) {
		$oSelect = $this->getDbTable()->select()->setIntegrityCheck(false)
						->from(array('IE' => 'INSCRIPTIONS_EQUIPES'), array('PARTICIPANTS_NOM_PRENOM' => 'P.NOM_PRENOM', 'IE.NOM_EQUIPE', 'U.UID', 'U.NOM_PRENOM', 'IE.ID_ACTIVITE', 'P.ID_INSCRIPTION'))
						->joinLeft(array('U' => 'UTILISATEURS'), 'U.UID = IE.UID', array())
						->joinLeft(array('P' => 'PARTICIPANTS'), 'P.ID_INSCRIPTION = IE.ID AND P.ID_ACTIVITE = IE.ID_ACTIVITE', array())
						->where('IE.ID_ACTIVITE = ?', $nIdActivite);

		return $this->getDbTable()->fetchAll($oSelect);
	}
}