<?php

class Application_Model_DbTable_Participants extends Projet_Db_Table {
	const NAME = 'PARTICIPANTS';


	public function __construct() {
		parent::__construct(self::NAME);
	}

}
