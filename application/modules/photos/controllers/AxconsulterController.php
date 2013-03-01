<?php
/**
 *
 * @package    modules_photos
 * @subpackage controllers
 */
class Photos_AxconsulterController extends Projet_Controller_Action_Ajax {

	public function getphotosbycategorieAction() {
		$nIdCategorie = $this->getParam('idCategorie');
		$oService = new Application_Service_Photos();
		$aPhotos = array();
		if ($nIdCategorie == 0) {
			$aPhotos = $oService->getAllPhotos();
		} else {
			$aPhotos = $oService->getPhotosByIdCategorie($nIdCategorie);
		}
		$this->view->photos = $aPhotos;
	}

}