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
class Administration_ContactsController extends Projet_Controller_Action {

	public function modifierorganisateursAction() {
		$oMapper = new Application_Model_Mapper_RefOrgaRoles();

		if ($this->getParam('idRole') == null) {
			$oForm = new Projet_Form_Element_Select('role');
			$oForm->setMultiOptions($oMapper->getLibelles())
				  ->setLabel('role')
				  ->setDecorators(array('ViewHelper'));
			$oSpan = new Projet_Xml('span', array('id' => 'valid', 'class'=>CSS_BOUTON), $this->view->translate('form.action.next'));
			$this->view->form = $oForm->render().$oSpan->render();
			return;
		}
		$nIdRole = $this->getParam('idRole');

		$oMapperOrga = new Application_Model_Mapper_Organisateurs();
		$nId = $oMapperOrga->getIdOrganisateurByIdRole($nIdRole);


		$oForm = new Form_ModifierOrganisateur($oMapper->getLibelles(), $nIdRole, $nId);



		//si personne pour le poste
		if ($nId == false) {
			$this->formCreer($oForm);
			return;
		}

		$this->formModifier($oForm, $nId);
	}
}