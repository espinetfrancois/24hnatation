<?php

class Application_Model_DbTable_Webmasters extends Projet_Db_Table {
	const NAME = 'WEBMASTERS';


	public function __construct() {
		parent::__construct(self::NAME);
	}

}
