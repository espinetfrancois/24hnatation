<?php

class Application_Model_Mapper_RefEleves extends Projet_Mapper {

	public function __construct() {
		parent::__construct('Application_Model_DbTable_RefEleves');
	}

	public function existsInDatabase($sUid) {
		return $this->getDbTable()->isRecordExists($sUid, 'UID');
	}
}