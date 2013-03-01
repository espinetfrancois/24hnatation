<?php

class Application_Service_Login {

	public function getUserByEmail($email="") {
		$oMapper = new Application_Model_Mapper_Utilisateurs();
		$res = $oMapper->getUserByEmail($email);
		if (count($res) != 1) {
			throw new Exception();
			return;
		} else {
			$res = $res[0];
		}
		$oUser = new Application_Model_Utilisateur();
		$oUser->setUid($res['UID']);
		$oUser->setEmail($res['email']);
		$oUser->setNom($res['NOM']);
		$oUser->setPrenom($res['PRENOM']);
		$oUser->setNomPrenom($res['NOM_PRENOM']);
		$oUser->setRole($res['ROLE']);

		return $oUser;
	}

	public function getUserSalt($email = "") {
		$oMapper = new Application_Model_Mapper_RefExterieurs();
		return $oMapper->getSaltByEmail($email);
	}

	public function getUserUidByEmail($email = "") {
		$oMapper = new Application_Model_Mapper_RefExterieurs();
		return $oMapper->getUidByEmail($email);
	}

	public function saveEleve(Application_Model_Eleve $oEleve) {
		$oMapU = new Application_Model_Mapper_Utilisateurs();

		if (!$oMapU->existsInDatabase($oEleve->getUid())) {
			$oMapE = new Application_Model_Mapper_RefEleves();
			$oMapE->save($oEleve, false);
			$oMapU->save($oEleve);
		}
	}


	public function addUserManualy($aData) {
// 		die(var_dump($aData));
		$oMapper = new Application_Model_Mapper_Utilisateurs();
		$oMapperExt = new Application_Model_Mapper_RefExterieurs();

		$oUtil = new Application_Model_Exterieur();
		$oUtil->setNom($aData[Form_FullRegister::NOM]);
		$oUtil->setPrenom($aData[Form_FullRegister::PRENOM]);
		$oUtil->setEmail($aData[Form_FullRegister::LOGIN]);
		$oUtil->prepareForInscription();
		$oUtil->setMdp($aData[Form_FullRegister::PASSWD]);
		$oUtil->setRole(ACL_ROLE_ELEVE);
		if ($aData[Form_FullRegister::UID] != "") {
			$oUtil->setUid($aData[Form_FullRegister::UID]);
		}
		//opération sensible : double check
		$oMapperWeb = new Application_Model_Mapper_Webmasters();
		if ($oMapperWeb->isWebmaster(Zend_Auth::getInstance()->getIdentity()->getUid())) {
			$oMapper->save($oUtil, false);
			$oMapperExt->save($oUtil);

			Application_Service_Inscriptions::sendChallengeToUser($oUtil, Zend_Layout::getMvcInstance()->getView());
		}
	}


	/**
	 *
	 *
	 *
	 * Super admin
	 *
	 *
	 */

	function getAllUsers() {
		$oMap = new Application_Model_Mapper_Utilisateurs();
		$aRes = $oMap->getAllUsers();

		$aRet = array();
		foreach ($aRes as $aUser) {
			if ($aUser['SPORT'] == null) {
				$oUser = new Application_Model_Exterieur();
				$oUser->setValid($aUser['VALID']);
			} else {
				$oUser = new Application_Model_Eleve();
				$oUser->setSport($aUser['SPORT']);
			}
			$oUser->setEmail($aUser['EMAIL']);
			$oUser->setId($aUser['ID']);
			$oUser->setNomPrenom($aUser['NOM_PRENOM']);
			$oUser->setUid($aUser['UID']);
			$aRet[$aUser['ID']] = $oUser;
		}
		return $aRet;
	}

	function changeUserPasswd($aData) {
		$oMapper = new Application_Model_Mapper_RefExterieurs();
		$oUser = new Application_Model_Exterieur();
		$oUser->setUid($aData[Form_ChangeUserPasswd::ID]);
		$oUser->setSalt($oMapper->getSaltByUid($oUser->getUid()));
		$oUser->setMdp($aData[Form_ChangeUserPasswd::PASSWD]);
		$oMapper->updatePasswd($oUser->getUid(), $oUser->getMdp());
	}
}