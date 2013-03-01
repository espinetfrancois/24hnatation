<?php
/**
 * Administration des activites
 *
 * @category   Projet
 * @package    modules_administration
 * @subpackage controllers
 */
class Administration_ActivitesController extends Projet_Controller_Action {

	public function ajouteractiviteAction() {
		$oService = new Application_Service_Activites();
		$oForm = new Form_ModifierActivite($oService->getJours(), $oService->getHeures(), $oService->getTypesActivites());
		$this->formCreer($oForm);
	}

	public function consulteractiviteAction() {
		$oService = new Application_Service_Activites();
		$oMapper = new Application_Model_Mapper_RefJours();
		$this->view->aActis = $oService->getFullActivites();
		$this->view->aJours = $oMapper->getJours();
	}


}