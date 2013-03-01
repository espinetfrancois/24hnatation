<?php

class Application_Model_Mapper_RefJours extends Projet_Mapper {


	public function __construct() {
		parent::__construct('Application_Model_DbTable_RefJours');
	}

	public function getJours() {
		$oSelect = $this->getDbTable()->select()->from(array('RJ' => 'REF_JOURS'), array('RJ.ID','RJ.NO_JOUR', 'RJ.LIBELLE', 'RJ.MOIS'))
												->order('RJ.ID');

		return $this->getDbTable()->fetchAll($oSelect);
	}
}