<?php

class Application_Service_Resultats {

	public function saveResultat($aData) {
		$oMapper = new Application_Model_Mapper_Resultats();
		$oResult = new Application_Model_Resultat();
		$oResult->setIdActivite($aData[Form_ModifierResultat::ACTI]);
		$oResult->setContenu($aData[Form_ModifierResultat::CONTENU]);
		$oResult->setId($aData[Form_ModifierResultat::ID]);
		$oMapper->save($oResult);
	}

	public function getResultat($nId) {
		$oMapper = new Application_Model_Mapper_Resultats();

		$aResult = $oMapper->find($nId);
		$aResult = $aResult[0];
		$ret[Form_ModifierResultat::ID] = $nId;
		$ret[Form_ModifierResultat::ACTI] = $aResult['ID_ACTIVITE'];
		$ret[Form_ModifierResultat::CONTENU] = $aResult['CONTENU'];
		return $ret;
	}


	public function getFullResultats() {
		$oMapper = new Application_Model_Mapper_Resultats();

		$aResults = $oMapper->getFullResultats();
		$ret = array();
		foreach($aResults as $result) {

			$oResultat = new Application_Model_Resultat();
			$oResultat->setContenu($result['CONTENU']);
			$oResultat->setNomActivite($result['NOM']);
			// 			$ret[$oResultat->getDateDebut()][] = $oResultat;
			$oResultat->setId($result['ID']);
			$ret[] =$oResultat;
		}

		return $ret;
	}
}