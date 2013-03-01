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
class IndexController extends Projet_Controller_Action {

	public function indexAction() {
		#echo "AUTH HS";
	}

	public function contactsAction() {
		$oMapper = new Application_Service_Contacts();
		$this->view->orga = $oMapper->getEquipe();
	}

	public function partenairesAction() {

	}

	public function programmeAction() {
		$oService = new Application_Service_Activites();
		$oMapper = new Application_Model_Mapper_RefJours();
		$this->view->aActis = $oService->getFullActivites();
		$this->view->aJours = $oMapper->getJours();
		$this->view->urlInscription = $this->_helper->Url
				->url(array(), 'inscriptions-accueil');
	}

	public function reglementAction() {

	}

	public function resultatsAction() {
		if (STATE_RESULT) {
			$oService = new Application_Service_Resultats();
			$this->view->aResults = $oService->getFullResultats();
		} else {
			$this->view->messageFerme = "resultats.closed";
		}
	}

	public function mentionslegalesAction() {

	}

	public function loginAction() {
		if (Zend_Auth::getInstance()->hasIdentity()) {
			$this->view->logged = true;
		} else {
			//récupération de l'url demandée à la base
			$this->view->location = new Zend_Session_Namespace('location');
		}
	}
}
