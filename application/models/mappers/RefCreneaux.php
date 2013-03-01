<?php

class Application_Model_Mapper_RefCreneaux extends Projet_Mapper {

	public function __construct() {
		parent::__construct('Application_Model_DbTable_RefCreneaux');
	}

	public function suppressionCreneauxByIdActivite($nIdActivite) {
		return $this->getDbTable()->delete(array('ID_ACTIVITE = ?' => $nIdActivite));
	}

	public function update(Application_Model_Creneau $oCreneau) {
		$this->updateRaw($oCreneau->getId(), array('ID_ACTIVITE' => $oCreneau->getIdActivite(), 'ID_INSCRIPTION' => $oCreneau->getIdInscription()));
	}

	/**
	 * TODO
	 * FIXME
	 * @author francois.espinet
	 * @param unknown $uid
	 * @param unknown $nIdActivite
	 * @return multitype:
	 */
	public function getCreneauxFilRouge($uid, $nIdActivite) {
		$sWhereInscription = $this->getDbTable()->getAdapter()->quoteInto('RC.ID_INSCRIPTION = ?', 0);
		$sWhereActi = $this->getDbTable()->getAdapter()->quoteInto('RC.ID_ACTIVITE = ?', $nIdActivite);
		$sWhereUid = $this->getDbTable()->getAdapter()->quoteInto('RC.ID_INSCRIPTION = ?', (int) $uid);

		$sWhere = $sWhereActi.' AND ('.$sWhereInscription.' OR '.$sWhereUid.')';
		$oSelect = $this->getDbTable()->select()->setIntegrityCheck(false)
									  ->from(array('RC' => 'REF_CRENEAUX'), array('RC.ID_INSCRIPTION', 'RC.ID','RC.ID_JOUR', 'RC.HEURE_DEBUT', 'RC.HEURE_FIN'))
									  ->joinLeft(array('IFR' => 'INSCRIPTIONS_FIL_ROUGES'), 'IFR.ID = RC.ID_INSCRIPTION', array())
									  ->where($sWhere);
		return $this->getDbTable()->fetchAll($oSelect);
	}

	public function getCreneauxBapteme($uid, $nIdActivite) {
		$sWhereInscription = $this->getDbTable()->getAdapter()->quoteInto('RC.ID_INSCRIPTION = ?', 0);
		$sWhereActi = $this->getDbTable()->getAdapter()->quoteInto('RC.ID_ACTIVITE = ?', $nIdActivite);
		$sWhereUid = $this->getDbTable()->getAdapter()->quoteInto('RC.ID_INSCRIPTION = ?', (int) $uid);

		$sWhere = $sWhereActi.' AND ('.$sWhereInscription.' OR '.$sWhereUid.')';
		$oSelect = $this->getDbTable()->select()->setIntegrityCheck(false)
					->from(array('RC' => 'REF_CRENEAUX'), array('RC.ID_INSCRIPTION', 'RC.ID','RC.ID_JOUR', 'RC.HEURE_DEBUT', 'RC.HEURE_FIN'))
					->joinLeft(array('IB' => 'INSCRIPTIONS_BAPTEMES'), 'IB.ID = RC.ID_INSCRIPTION', array())
					->where($sWhere);
		return $this->getDbTable()->fetchAll($oSelect);
	}

	public function desinscriptionCreneauByIdActiviteAndIdInscription($nIdActivite, $nIdInscription) {
		$sWhere = $this->getDbTable()->getAdapter()->quoteInto('ID_INSCRIPTION = ?', $nIdInscription);
		$sWhere .= ' AND '.$this->getDbTable()->getAdapter()->quoteInto('ID_ACTIVITE = ?', $nIdActivite);

		return $this->getDbTable()->update(array('ID_INSCRIPTION' => 0), $sWhere);
	}
}