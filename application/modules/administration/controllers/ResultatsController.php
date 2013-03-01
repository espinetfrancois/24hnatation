<?php
/**
 * Administration des activites
 *
 * @category   Projet
 * @package    modules_administration
 * @subpackage controllers
 */
class Administration_ResultatsController extends Projet_Controller_Action {

	public function ajouterresultatAction() {
		$oMapper = new Application_Model_Mapper_Activites();
		$oForm = new Form_ModifierResultat($oMapper->getLibelles());
		$this->formCreer($oForm);
	}

	public function consulterresultatAction() {
		$oService = new Application_Service_Resultats();
		$this->view->aResults = $oService->getFullResultats();
	}


}