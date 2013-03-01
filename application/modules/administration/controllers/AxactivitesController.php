<?php
/**
 * Administration des activites
 *
 * @category   Projet
 * @package    modules_administration
 * @subpackage controllers
 */
class Administration_AxactivitesController extends Projet_Controller_Action_Ajax {

	public function modifieractiviteAction() {
		$nIdActi = $this->getParam('idActivite');
		$oService = new Application_Service_Activites();
		$oForm = new Form_ModifierActivite($oService->getJours(), $oService->getHeures(), $oService->getTypesActivites());
		$oForm->setAction($this->_helper->Url->url(array('controller' => $this->getRequest()->getControllerName(),
														"action" => $this->getRequest()->getActionName())).'?idActivite='.$nIdActi);
		$this->formModifier($oForm, $nIdActi);
	}


}