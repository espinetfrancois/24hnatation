<?php

class Application_Model_Mapper_RefExterieurs extends Projet_Mapper {

	public function __construct() {
		parent::__construct('Application_Model_DbTable_RefExterieurs');
	}

	public function getChallengeByUid($uid) {
		$oSelect = $this->getDbTable()->select()->from(array('RE' => 'REF_EXTERIEURS'), array('RE.CHALLENGE'))
												->where('RE.UID = ?', $uid);
		return $this->getDbTable()->fetchOne($oSelect);
	}

	public function validateUserByUid($uid) {
		$where = $this->getDbTable()->getAdapter()->quoteInto('UID = ?', $uid);
		$oSelect = $this->getDbTable()->update(array('VALID' => true), $where);
	}

	public function getSaltByEmail($email) {
		$oSelect = $this->getDbTable()->select()->from(array("RE" => 'REF_EXTERIEURS'), array('RE.SALT'))
												->join(array('U' => 'UTILISATEURS'), 'U.UID = RE.UID', array())
												->where('U.EMAIL = ?', $email);
		return $this->getDbTable()->fetchOne($oSelect);
	}

	public function getUidByEmail($email) {
		$oSelect = $this->getDbTable()->select()->from(array("RE" => 'REF_EXTERIEURS'), array('RE.UID'))
							->join(array('U' => 'UTILISATEURS'), 'U.UID = RE.UID', array())
							->where('U.EMAIL = ?', $email);
		return $this->getDbTable()->fetchOne($oSelect);
	}

	public function getSaltByUid($uid) {
		$oSelect = $this->getDbTable()->select()->from(array("RE" => 'REF_EXTERIEURS'), array('RE.SALT'))
							->where('RE.UID = ?', $uid);
		return $this->getDbTable()->fetchOne($oSelect);
	}

	public function updatePasswd($uid, $passwd) {
		return $this->getDbTable()->update(array('MDP' => $passwd), array('UID = ?' => $uid));
	}
}