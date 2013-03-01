<?php

class Application_Model_DbTable_RefExterieurs extends Projet_Db_Table {
	const NAME = 'REF_EXTERIEURS';


	public function __construct() {
		parent::__construct(self::NAME);
	}

}
