<?php

class Application_Model_Mapper_InscriptionsBaptemes extends Projet_Mapper {

	public function __construct() {
		parent::__construct('Application_Model_DbTable_InscriptionsBaptemes');
	}

	public function getCrenauxLibresByUid($uid, $id_activite) {
		$nUid = $this->getIdInscriptionByUid($uid);
		$oMap = new Application_Model_Mapper_RefCreneaux();
		return $oMap->getCreneauxBapteme($nUid, $id_activite);
		//si c'est libre
// 		$sWhereInscription = $this->getDbTable()->getAdapter()->quoteInto('RC.ID_INSCRIPTION = ?', 0);
// 		$sWhereActi = $this->getDbTable()->getAdapter()->quoteInto('RC.ID_ACTIVITE = ?', $id_activite);
// 		$sWhereUid = $this->getDbTable()->getAdapter()->quoteInto('IB.UID = ?', $uid);

// 		$sWhere = $sWhereActi.' AND ('.$sWhereInscription.' OR '.$sWhereUid.')';
// 		$oSelect = $this->getDbTable()->select()->setIntegrityCheck(false)
// 												->from(array('IB' => 'INSCRIPTIONS_BAPTEMES'), array('RC.ID_INSCRIPTION', 'RC.ID','RC.ID_JOUR', 'RC.HEURE_DEBUT', 'RC.HEURE_FIN'))
// 												->joinRight(array('RC' => 'REF_CRENEAUX'), 'RC.ID_ACTIVITE = IB.ID_ACTIVITE', array())
// 												->joinLeft(array('RJ' => 'REF_JOURS'), 'RJ.ID = RC.ID_JOUR', array())
// 												->where($sWhere);
// // 												->where('IB.UID = ?', $uid)
// // 												->orWhere('RC.ID_INSCRIPTION = ?', 0)
// // 												->where('IB.ID_ACTIVITE = ?', $id_activite);
// // 		die($oSelect);
// 		return $this->getDbTable()->fetchAll($oSelect);
	}

	public function getInscriptionById($nId) {
		$oSelect = $this->getDbTable()->select()->setIntegrityCheck(false)
												->from(array('IB' =>'INSCRIPTIONS_BAPTEMES'), array('RC.ID'))
												->joinLeft(array('RC' => 'REF_CRENEAUX'), 'RC.ID_INSCRIPTION = IB.ID', array())
												->where('IB.ID = ?', $nId);

		return $this->getDbTable()->fetchAll($oSelect);
	}

	public function getIdInscriptionByUid($uid) {
		$oSelect = $this->getDbTable()->select()->from(array('IB' => 'INSCRIPTIONS_BAPTEMES'), array('IB.ID'))
												->where('IB.UID = ?', $uid);

		return $this->getDbTable()->fetchOne($oSelect);
	}

	public function getAllCreneauxWithPerson($nIdActivite) {
		$oSelect = $this->getDbTable()->select()->setIntegrityCheck(false)
										->from(array('IB' => 'INSCRIPTIONS_BAPTEMES'), array('U.NOM_PRENOM', 'U.NOM', 'U.PRENOM','IB.UID','RC.HEURE_DEBUT', 'RC.ID_JOUR', 'RC.HEURE_FIN' , 'RC.ID', 'RC.ID_INSCRIPTION', 'REV.SPORT'))
										->joinRight(array('RC' => 'REF_CRENEAUX'), 'IB.ID = RC.ID_INSCRIPTION', array())
										->joinLeft(array('U' => 'UTILISATEURS'), 'U.UID = IB.UID', array())
										->joinLeft(array('REV' => 'REF_ELEVES'), 'REV.UID = U.UID', array())
										->where('RC.ID_ACTIVITE = ?', $nIdActivite);

		return $this->getDbTable()->fetchAll($oSelect);
	}

}