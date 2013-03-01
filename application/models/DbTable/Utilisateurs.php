<?php

class Application_Model_DbTable_Utilisateurs extends Projet_Db_Table {
	const NAME = 'UTILISATEURS';


	public function __construct() {
		parent::__construct(self::NAME);
	}

}
