<?php

class Application_Model_DbTable_Activites extends Projet_Db_Table {
	const NAME = 'ACTIVITES';


	public function __construct() {
		parent::__construct(self::NAME);
	}

}
