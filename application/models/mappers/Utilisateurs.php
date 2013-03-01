<?php

class Application_Model_Mapper_Utilisateurs extends Projet_Mapper {

	public function __construct() {
		parent::__construct('Application_Model_DbTable_Utilisateurs');
	}

	public function getLibelles() {
		return $this->listerPair('UID', 'NOM');
	}

	public function save(Projet_Entite $oUser, $bUpdateEntity = true) {
		try {
			parent::save($oUser, $bUpdateEntity);
		} catch (Zend_Db_Exception $e) {
			if ($e->getCode() == Projet_Exception_Doublon::MYSQL_DOUBLON || $e->getCode() == Projet_Exception_Doublon::ORA_DOUBLON) {
				throw new Projet_Exception_Doublon();
			} else {
				throw $e;
			}
		}
	}

	public function getUserByEmail($email) {
		$oSelect = $this->getDbTable()->select()->from(array('U' => 'UTILISATEURS'), array('U.UID', 'U.NOM', 'U.PRENOM', 'U.NOM_PRENOM', 'U.EMAIL', 'U.ROLE'))
												->where('U.EMAIL = ?', $email);

		return $this->getDbTable()->fetchAll($oSelect);
	}

	public function existsInDatabase($sUid) {
		return $this->getDbTable()->isRecordExists($sUid, 'UID');
	}

	public function getAllUsers() {
		$oSelect = $this->getDbTable()->select()->setIntegrityCheck(false)
									->from(array('U' => 'UTILISATEURS'), array('U.ID', 'U.UID', 'U.NOM_PRENOM', 'U.EMAIL', 'REX.VALID', 'REV.SPORT'))
									->joinLeft(array('REV' => 'REF_ELEVES'),'REV.UID = U.UID', array())
									->joinLeft(array('REX' => 'REF_EXTERIEURS'), 'REX.UID = U.UID', array());
		return $this->getDbTable()->fetchAll($oSelect);
	}
}