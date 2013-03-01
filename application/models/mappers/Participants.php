<?php

class Application_Model_Mapper_Participants extends Projet_Mapper {

	public function __construct() {
		parent::__construct('Application_Model_DbTable_Participants');
	}

	public function getLibelles() {
		return $this->listerIdPair('NOM_PRENOM');
	}

	public function saveInscriptionTournoi($aMembers, $nIdInscription, $nIdActivite) {
		$this->deleteInscription($nIdInscription);
		$this->addRaw(array('NOM_PRENOM' => join(SQL_CONCAT_SEPARATOR, $aMembers), 'ID_INSCRIPTION' => $nIdInscription, 'ID_ACTIVITE' => $nIdActivite));

	}

	public function saveInscriptionEquipe($aMembers, $nIdInscription, $nIdActivite) {
		$this->deleteInscription($nIdInscription);
		$this->addRaw(array('NOM_PRENOM' => join(SQL_CONCAT_SEPARATOR, $aMembers), 'ID_INSCRIPTION' => $nIdInscription, 'ID_ACTIVITE' => $nIdActivite));

	}

	public function saveInscriptionFilRouge($aMembers, $nIdInscription, $nIdActivite) {
		$this->deleteInscription($nIdInscription);
		$this->addRaw(array('NOM_PRENOM' => join(SQL_CONCAT_SEPARATOR, $aMembers), 'ID_INSCRIPTION' => $nIdInscription, 'ID_ACTIVITE' => $nIdActivite));
	}

	public function saveInscriptionFilRougeBinet($sBinet, $nIdInscription, $nIdActivite) {
		$this->deleteInscription($nIdInscription);
		$this->addRaw(array('NOM_PRENOM' => $sBinet, 'ID_INSCRIPTION' => $nIdInscription, 'ID_ACTIVITE' => $nIdActivite));
	}

	protected function deleteInscription($nIdInscription) {
		$this->getDbTable()->delete(array('ID_INSCRIPTION = ?' => (int) $nIdInscription));
	}

	function getParticipantsByIdInscriptionAndIdActivite($nIdInscription, $nIdActivite) {
		$oSelect = $this->getDbTable()->select()->from(array('P' => 'PARTICIPANTS'), array('P.NOM_PRENOM'))
												->where('ID_INSCRIPTION = ?', $nIdInscription)
												->where('ID_ACTIVITE = ?', $nIdActivite);

		$aRes = $this->getDbTable()->fetchAll($oSelect);
		return explode(SQL_CONCAT_SEPARATOR, $aRes[0]['NOM_PRENOM']);

	}
}