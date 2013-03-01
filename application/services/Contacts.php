<?php

class Application_Service_Contacts {

	public function saveOrganisateur($aData) {
		$oOrganisateur = new Application_Model_Organisateur();
		$oOrganisateur->setId($aData[Form_ModifierOrganisateur::ID]);
		$oOrganisateur->setIdRole($aData[Form_ModifierOrganisateur::ROLE]);
		$oOrganisateur->setNom($aData[Form_ModifierOrganisateur::NOM]);
		$oOrganisateur->setPrenom($aData[Form_ModifierOrganisateur::PRENOM]);
		$oOrganisateur->setTelephone($aData[Form_ModifierOrganisateur::TELEPHONE]);

		$oMapper = new Application_Model_Mapper_Organisateurs();
		$oMapper->save($oOrganisateur);
	}

	public function getOrganisateur($nId) {
		$oMapper = new Application_Model_Mapper_Organisateurs();
		$aRes = $oMapper->find($nId);
		$aRes = $aRes[0];
		$aRet[Form_ModifierOrganisateur::ID] = $nId;
		$aRet[Form_ModifierOrganisateur::NOM] = $aRes['NOM'];
		$aRet[Form_ModifierOrganisateur::PRENOM] = $aRes['PRENOM'];
		$aRet[Form_ModifierOrganisateur::ROLE] = $aRes['ID_ROLE'];
		$aRet[Form_ModifierOrganisateur::TELEPHONE] = $aRes['TELEPHONE'];

		return $aRet;
	}

	public function getEquipe() {
		$oMapper = new Application_Model_Mapper_Organisateurs();
		$aRes = $oMapper->getEquipe();
		$aRet = array();
		foreach ($aRes as $aResult) {
			$oOrganisateur = new Application_Model_Organisateur();
			$oOrganisateur->setNom($aResult['NOM']);
			$oOrganisateur->setPrenom($aResult['PRENOM']);
			$oOrganisateur->setTelephone($aResult['TELEPHONE']);

			$aRet[$aResult['LIBELLE']][] = $oOrganisateur;
		}

		return $aRet;

	}

}