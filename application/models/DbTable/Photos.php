<?php

class Application_Model_DbTable_Photos extends Projet_Db_Table {
	const NAME = 'PHOTOS';


	public function __construct() {
		parent::__construct(self::NAME);
	}

}
