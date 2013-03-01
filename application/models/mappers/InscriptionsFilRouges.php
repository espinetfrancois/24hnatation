<?php

class Application_Model_Mapper_InscriptionsFilRouges extends Projet_Mapper {

	public function __construct() {
		parent::__construct('Application_Model_DbTable_InscriptionsFilRouges');
	}

	/**
	 * TODO
	 * FIXME
	 * @author francois.espinet
	 * @param unknown $uid
	 * @param unknown $id_activite
	 * @return Ambigous <multitype:, multitype:>
	 */
	public function getCrenauxLibresByUid($uid, $id_activite) {
		$nInscriptionUid = $this->getIdInscriptionByUid($uid);
// 		die(var_dump($nInscriptionUid));
		$oMap = new Application_Model_Mapper_RefCreneaux();
		return $oMap->getCreneauxFilRouge($nInscriptionUid, $id_activite);

		//si c'est libre
// 		$sWhereInscription = $this->getDbTable()->getAdapter()->quoteInto('RC.ID_INSCRIPTION = ?', 0);
// 		$sWhereActi = $this->getDbTable()->getAdapter()->quoteInto('RC.ID_ACTIVITE = ?', $id_activite);
// // 		$sWhereUid = $this->getDbTable()->getAdapter()->quoteInto('IFR.UID = ?', $uid);
// 		$sWhereUid = $this->getDbTable()->getAdapter()->quoteInto('RC.ID_INSCRIPTION = ?', (int) $nInscriptionUid);


// 		$sWhere = $sWhereActi.' AND ('.$sWhereInscription.' OR '.$sWhereUid.')';
// 		$oSelect = $this->getDbTable()->select()->setIntegrityCheck(false)
// 												->from(array('IFR' => 'INSCRIPTIONS_FIL_ROUGES'), array('RC.ID_INSCRIPTION', 'RC.ID','RC.ID_JOUR', 'RC.HEURE_DEBUT', 'RC.HEURE_FIN'))
// 												->joinRight(array('RC' => 'REF_CRENEAUX'), 'RC.ID_INSCRIPTION = IFR.ID OR RC.ID_ACTIVITE = IFR.ID_ACTIVITE', array())
// 												->joinLeft(array('RJ' => 'REF_JOURS'), 'RJ.ID = RC.ID_JOUR', array())
// 												->where($sWhere);
// // 												->where('RC.ID_INSCRIPTION = ?', 0)
// // 												->orWhere('RC.ID_INSCRIPTION = ?', (int) $nInscriptionUid);
// // 												->where('IFR.ID_ACTIVITE = ?', $id_activite);
// 		die($oSelect);
// 		return $this->getDbTable()->fetchAll($oSelect);
	}

	public function getInscriptionById($nId) {
		$oSelect = $this->getDbTable()->select()->setIntegrityCheck(false)
												->from(array('IFR' => 'INSCRIPTIONS_FIL_ROUGES'), array('IFR.TYPE_INSCRIPTION', 'P.NOM_PRENOM'))
												->joinLeft(array('P' => 'PARTICIPANTS'), 'P.ID_INSCRIPTION = IFR.ID AND P.ID_ACTIVITE = IFR.ID_ACTIVITE', array())
												->where('IFR.ID = ?', $nId);

		return $this->getDbTable()->fetchAll($oSelect);
	}

	public function getIdInscriptionByUid($uid) {
		$oSelect = $this->getDbTable()->select()->from(array('IFR' => 'INSCRIPTIONS_FIL_ROUGES'), array('IFR.ID'))
												->where('IFR.UID = ?', $uid);

		return $this->getDbTable()->fetchOne($oSelect);
	}

	public function getAllCreneauxWithPerson($nIdActivite) {
		$oSelect = $this->getDbTable()->select()->setIntegrityCheck(false)
												->from(array('IFR' => 'INSCRIPTIONS_FIL_ROUGES'), array('PARTICIPANTS_NOM_PRENOMS' => 'P.NOM_PRENOM', 'U.NOM_PRENOM', 'U.NOM', 'U.PRENOM','IFR.UID','RC.HEURE_DEBUT', 'RC.ID_JOUR', 'RC.HEURE_FIN' , 'RC.ID', 'RC.ID_INSCRIPTION', 'IFR.TYPE_INSCRIPTION'))
												->joinRight(array('RC' => 'REF_CRENEAUX'), 'IFR.ID = RC.ID_INSCRIPTION', array())
												->joinLeft(array('U' => 'UTILISATEURS'), 'U.UID = IFR.UID', array())
												->joinLeft(array('RE' => 'REF_ELEVES'), 'RE.UID = U.UID', array('RE.SPORT'))
												->joinLeft(array('P' => 'PARTICIPANTS'), 'P.ID_ACTIVITE = IFR.ID_ACTIVITE AND IFR.ID = P.ID_INSCRIPTION', array())
												->where('RC.ID_ACTIVITE = ?', $nIdActivite);

		return $this->getDbTable()->fetchAll($oSelect);
	}

	public function getAllCreneauxPrisWithIdInscription($nIdActivite) {
		$oSelect = $this->getDbTable()->select()->setIntegrityCheck(false)
									  ->from(array('IFR' => 'INSCRIPTIONS_FIL_ROUGES'), array( 'RC.ID_INSCRIPTION' ,'RC.ID','RC.HEURE_DEBUT', 'RC.ID_JOUR', 'RC.HEURE_FIN'))
									  ->joinRight(array('RC' => 'REF_CRENEAUX') , 'IFR.ID = RC.ID_INSCRIPTION', array())
									  ->where('IFR.ID_ACTIVITE = ?', $nIdActivite);

		return $this->getDbTable()->fetchAll($oSelect);
	}

	public function getAllCreneauxWithIdInscription($nIdActivite) {
		$oSelect = $this->getDbTable()->select()->setIntegrityCheck(false)
												->from(array('IFR' => 'INSCRIPTIONS_FIL_ROUGES'), array( 'RC.ID_INSCRIPTION' ,'RC.ID','RC.HEURE_DEBUT', 'RC.ID_JOUR', 'RC.HEURE_FIN'))
												->joinRight(array('RC' => 'REF_CRENEAUX') , 'IFR.ID_ACTIVITE = RC.ID_ACTIVITE', array())
												->where('IFR.ID_ACTIVITE = ?', $nIdActivite);

		return $this->getDbTable()->fetchAll($oSelect);
	}

	public function countCreneauxPris($nIdActivite) {
		$oSelect = $this->getDbTable()->select()->setIntegrityCheck(false)
												->from(array('IFR' => 'INSCRIPTIONS_FIL_ROUGES'), array())
												->joinLeft(array('RC' => 'REF_CRENEAUX'), 'RC.ID_INSCRIPTION = IFR.ID', array())
												->where('RC.ID_INSCRIPTION <> ?', 0)
												->where('IFR.ID_ACTIVITE = ?', $nIdActivite);

		return count($this->getDbTable()->fetchAll($oSelect));
	}

}