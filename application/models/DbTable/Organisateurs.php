<?php

class Application_Model_DbTable_Organisateurs extends Projet_Db_Table {
	const NAME = 'ORGANISATEURS';


	public function __construct() {
		parent::__construct(self::NAME);
	}

}
