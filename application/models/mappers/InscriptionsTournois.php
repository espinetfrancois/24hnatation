<?php

class Application_Model_Mapper_InscriptionsTournois extends Projet_Mapper {

	public function __construct() {
		parent::__construct('Application_Model_DbTable_InscriptionsTournois');
	}

	public function getIdInscriptionByUid($uid) {
		$oSelect = $this->getDbTable()->select()->from(array('IT' => 'INSCRIPTIONS_TOURNOIS'), array('IT.ID'))
												->where('IT.UID = ?', $uid);

		return $this->getDbTable()->fetchOne($oSelect);
	}

	public function getAllEquipesWithPersonnes($nIdActivite) {
		$oSelect = $this->getDbTable()->select()->setIntegrityCheck(false)
												->from(array('IT' => 'INSCRIPTIONS_TOURNOIS'), array('PARTICIPANTS_NOM_PRENOM' => 'P.NOM_PRENOM', 'IT.NOM_EQUIPE', 'U.UID', 'U.NOM_PRENOM', 'IT.ID_ACTIVITE', 'P.ID_INSCRIPTION'))
												->joinLeft(array('U' => 'UTILISATEURS'), 'U.UID = IT.UID', array())
												->joinLeft(array('P' => 'PARTICIPANTS'), 'P.ID_INSCRIPTION = IT.ID AND P.ID_ACTIVITE = IT.ID_ACTIVITE', array())
												->where('IT.ID_ACTIVITE = ?', $nIdActivite);

		return $this->getDbTable()->fetchAll($oSelect);
	}
}