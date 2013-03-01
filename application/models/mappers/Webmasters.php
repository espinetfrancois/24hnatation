<?php

class Application_Model_Mapper_Webmasters extends Projet_Mapper {

	public function __construct() {
		parent::__construct('Application_Model_DbTable_Webmasters');
	}

	public function isWebmaster($sUid) {
		return $this->getDbTable()->isRecordExists($sUid, 'UID');
	}
}