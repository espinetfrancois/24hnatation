<?php

class Application_Model_Mapper_Organisateurs extends Projet_Mapper {

	public function __construct() {
		parent::__construct('Application_Model_DbTable_Organisateurs');
	}

	public function getIdOrganisateurByIdRole($nIdRole) {
		$oSelect = $this->getDbTable()->select()->from(array('O' => 'ORGANISATEURS'), 'O.ID')
												->where('ID_ROLE = ?', $nIdRole);
		$aResult = $this->getDbTable()->fetchOne($oSelect);
		if (count($aResult) == 0) {
			return false;
		}
		return $aResult;
	}

	public function getEquipe() {
		$oSelect = $this->getDbTable()->select()->setIntegrityCheck(false)
												->from(array('O' => 'ORGANISATEURS'), array('O.NOM', 'O.PRENOM', 'O.TELEPHONE', 'ROR.LIBELLE'))
												->joinLeft(array('ROR' => 'REF_ORGA_ROLES'), 'ROR.ID = O.ID_ROLE', array())
												->order('ROR.ID');
		$aResult = $this->getDbTable()->fetchAll($oSelect);

		return $aResult;
	}

}