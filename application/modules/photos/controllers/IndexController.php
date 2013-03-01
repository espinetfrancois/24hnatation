<?php
/**
 * Controlleur page d'accueil.
 *
 * @remark	ATTENTION : seul contrôleur sans nameSpace "Main_"
 *
 * @category   Projet
 * @package    modules_main
 * @subpackage controllers
 */
class Photos_IndexController extends Projet_Controller_Action {

	public function indexAction() {
		$oMapper = new Application_Model_Mapper_RefCategories();
		$oForm = new Form_SelectCategorie($oMapper->getLibellesReels());
		$this->view->form = $oForm;

// 		$oSrvPhoto = new Application_Service_Photos();
// 		$this->view->photos = $oSrvPhoto->getAllPhotos();
	}

}