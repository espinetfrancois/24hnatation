<?php
/**
 * Administration des activites
 *
 * @category   Projet
 * @package    modules_administration
 * @subpackage controllers
 */
class Administration_AxresultatsController extends Projet_Controller_Action_Ajax {

	public function modifierresultatAction() {
		$nIdResult = $this->getParam('idResultat');
		$oMapper = new Application_Model_Mapper_Activites();
		$oForm = new Form_ModifierResultat($oMapper->getLibelles());
		$oForm->setAction($this->_helper->Url->url(array('controller' => $this->getRequest()->getControllerName(),
														"action" => $this->getRequest()->getActionName())).'?idResultat='.$nIdResult);
		$this->formModifier($oForm, $nIdResult);
	}


}