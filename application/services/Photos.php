<?php

class Application_Service_Photos {


	public function getAllPhotos() {
		$oMapper = new Application_Model_Mapper_Photos();
		$aResult = $oMapper->getAllPhotos();

		return $this->processRawPhotos($aResult);
	}

	public function getPhotosByIdCategorie($nIdCategorie) {
		$oMapper = new Application_Model_Mapper_Photos();
		$aResult = $oMapper->getPhotosByIdCategories($nIdCategorie);
		return $this->processRawPhotos($aResult);
	}

	protected function processRawPhotos($aResult = array()) {
		$aReturn = array();
		foreach ($aResult as $result) {
			$photo = new Application_Model_Photo();
			$photo->setNomFichier($result['NOM_FICHIER']);
			$photo->setIdCategorie($result['ID_CATEGORIE']);
			$photo->setUidUtilisateur($result['UID_UTILISATEUR']);
			$photo->setId($result['ID']);
			$aReturn[] = $photo;
		}
		return $aReturn;
	}

	public function ajouterCategorie($aData) {
		$oMapper = new Application_Model_Mapper_RefCategories();
		$oCat = new Application_Model_Categorie();
		$oCat->setLibelle($aData[Form_AjouterCategorie::CATEGORIE]);
		$oMapper->save($oCat);
	}

	public function ajouterPhoto($aData, Projet_Form $oForm) {
		$oMapper = new Application_Model_Mapper_Photos();
		$oPhoto = new Application_Model_Photo();
		$oPhoto->setIdCategorie($aData[Form_AjouterPhoto::CATEGORIE]);
		$oPhoto->setNomFichier(strtolower($aData[Form_AjouterPhoto::FILE]));

		$oIdent = Zend_Auth::getInstance()->getIdentity();
		$oPhoto->setUidUtilisateur($oIdent->getUid());
		$filedest = FULL_PHOTOS_PATH.'/'.$oPhoto->getNomFichier();

		if ($oMapper->photoWithSameNameExists($oPhoto->getNomFichier()) && file_exists($filedest)) {
			throw new Projet_Exception_Doublon();
			return;
		}
		$oMapper->add($oPhoto);

		//reception et bougeage du fichier
		/**
		 * @var Projet_Form_Element_File
		 */
		$file = $oForm->getElement(Form_AjouterPhoto::FILE);
		if ($file->isReceived() && $file->isFiltered()) {
			$filename = $file->getFileName();

			copy($filename, $filedest);
			if (file_exists($filedest))
				unlink($filename);
		}
	}

	public function supprimerPhotoById($nId) {
		$oMapper = new Application_Model_Mapper_Photos();
		$aResult = $oMapper->find($nId);
		if (count($aResult) < 1 || ! array_key_exists('NOM_FICHIER', $aResult[0])) {
			throw new Zend_Exception('La photo n\'existe plus');
			return;
		}
		unlink(FULL_PHOTOS_PATH.'/'.$aResult[0]['NOM_FICHIER']);
		$oMapper->deleteRaw($nId);

	}
}