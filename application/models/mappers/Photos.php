<?php

class Application_Model_Mapper_Photos extends Projet_Mapper {


	public function __construct() {
		parent::__construct('Application_Model_DbTable_Photos');
	}

	public function getAllPhotos() {
		$oSelect = $this->selectPhotos();
		return $this->getDbTable()->fetchAll($oSelect);
	}

	public function getPhotosByIdCategories($idCategorie) {
		$oSelect = $this->selectPhotos()->where('P.ID_CATEGORIE = ?', $idCategorie);
		return $this->getDbTable()->fetchAll($oSelect);
	}

	protected function selectPhotos() {
		return $this->getDbTable()->select()->from(array('P' => 'PHOTOS'), array('P.ID','P.UID_UTILISATEUR', 'P.NOM_FICHIER', 'P.ID_CATEGORIE'));
	}

	public function photoWithSameNameExists($sName) {
		if (count($this->findPhotoByName($sName)) > 0)
			return true;
		return false;
	}

	public function findPhotoByName($sName) {
		$oSelect = $this->getDbTable()->select()->from(array('P' => 'PHOTOS'), array())
												->where('P.NOM_FICHIER = ?', $sName);
		return $this->getDbTable()->fetchAll($oSelect);
	}

}