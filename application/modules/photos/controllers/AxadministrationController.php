<?php

class Photos_AxadministrationController extends Projet_Controller_Action_Ajax {

	public function getallcategoriesAction() {
		$oMapper = new Application_Model_Mapper_RefCategories();
		$this->view->categories = $oMapper->getLibelles();
	}

	public function supprcategoriebyidAction() {
		$nId = $this->getParam('idCategorie');
		$oMapper = new Application_Model_Mapper_RefCategories();
		try {
			$oMapper->deleteRaw($nId);
			$this->view->message = "cat.suppr";
		} catch (Exception $e) {
			$this->view->message = $this->view->translate("err.suppr").$e->getMessage();
		}

	}

	public function updatecategoriebyidphotoAction() {
		$nIdPhoto = $this->getParam('idPhoto');
		$nIdCat = $this->getParam('idCategorie');
		$oMapper = new Application_Model_Mapper_Photos();
		$oPhoto = new Application_Model_Photo();
		$oPhoto->setId($nIdPhoto);
		$oPhoto->setIdCategorie($nIdCat);
		try {
			$oMapper->update($oPhoto);
			$this->view->message= "photo.maj";
		} catch (Exception $e) {
			$this->view->message = "err.update";
		}
	}

	public function supprimerphotobyidAction() {
		$nId = $this->getParam('idPhoto');
		$oService = new Application_Service_Photos();
		try {
			$oService->supprimerPhotoById($nId);
			$this->view->message = "photo.suppr";
		} catch (Projet_Exception_NoRecord $e) {
			$this->view->message = "photo.not.exist";
		} catch (Exception $e) {
			$this->view->message = "err.suppr";
		}
	}
}