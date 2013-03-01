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
class Inscriptions_AdministrationController extends Projet_Controller_Action {

	public function indexAction() {
		$oService = new Application_Service_Activites();
		$this->view->aActis = $oService->getInscriptibleActivites();
		$this->view->aJours = $oService->getJours();
	}

	public function voirAction() {
		// 		$nIdActivite = $this->getParam('idActivite');

		// 		$oService = new Application_Service_Activites();
		// 		$oActi = $oService->getActiviteInscriptibleById($nIdActivite);
		// 		$this->view->oActi = $oActi;

		// 		$oServiceI = new Application_Service_Inscriptions();
		// 		$oIdent = Zend_Auth::getInstance()->getIdentity();
		// 		$sMsgEdition = "";
		// 		$nId = null;
		// // 		die($oActi->getType());
		// 		switch ($oActi->getType()) {
		// 			case ACTI_TYPE_FILROUGE:
		// // 				$sMsgEdition = $this->view->translate('inscriptions.howto.filrouge');
		// 				$sMsgEdition = $oActi->getDescription();
		// 				$nId = $oServiceI->getIdInscriptionFilRouge();
		// 				$aCrenaux = $oServiceI->getAllFilRougeWithInscription($nIdActivite);
		// 				if ($oIdent->getRole() == ACL_ROLE_ELEVE || $oIdent->getRole() >= ACL_ROLE_ADMIN) {
		// 					$aBinets = $oIdent->getBinetsAdmin();
		// 				} else {
		// 					$aBinets = array();
		// 				}

		// 				$oForm = new Form_AdminFilRouge($aCrenaux['creneaux'], $aCrenaux['pris'], $nIdActivite);
		// 			break;

		// 			case ACTI_TYPE_TOURNOI:
		// 				$oForm = new Form_Tournoi($nIdActivite);
		// 				$this->view->headScript()->appendFile(SCRIPTS_PATH.'/forms/tournoi.js');
		// 				$nId = $oServiceI->getIdInscriptionTournoi();
		// 			break;

		// 			case ACTI_TYPE_CHALLENGE_EQUIPE:
		// 				$nId = $oServiceI->getIdInscriptionEquipe();
		// 				$oForm = new Form_AdminEquipe($nIdActivite);
		// 				$this->view->headScript()->appendFile(SCRIPTS_PATH.'/forms/equipe.js');
		// 			break;

		// 			case ACTI_TYPE_CHALLENGE_INDIVIDUEL:
		// 				$nId = $oServiceI->getIdInscriptionIndividuelle();
		// 				$sMsgEdition = "S'inscrire à cette activité";
		// 				$oForm = new Form_AdminIndividuel($nIdActivite);
		// 			break;

		// 			case ACTI_TYPE_BAPTEME:
		// 				$this->view->headScript()->appendFile(SCRIPTS_PATH.'/forms/bapteme.js');
		// 				$nId = $oServiceI->getIdInscriptionBapteme();
		// 				$aCrenaux = $oServiceI->getCreneauxLibresBaptemeByUid($oIdent->getUid(), $nIdActivite);
		// 				$oForm = new Form_AdminBapteme($aCrenaux['creneaux'], $aCrenaux['pris'], $nIdActivite);
		// 			break;

		// 			default:
		// 				die("not Implemented");
		// 			break;
		// 		}

		// 		$this->formModifier($oForm, $nId,$sMsgEdition);
	}

	public function listingsAction() {
		$nIdActivite = $this->getParam('idActivite');

		$oService = new Application_Service_Activites();
		$oActi = $oService->getActiviteInscriptibleById($nIdActivite);
		$this->view->oActi = $oActi;

		$oServiceI = new Application_Service_Inscriptions();

		switch ($oActi->getType()) {
		case ACTI_TYPE_FILROUGE:
		// 				$sMsgEdition = $this->view->translate('inscriptions.howto.filrouge');
		// 				$sMsgEdition = $oActi->getDescription();
			$nId = $oServiceI->getIdInscriptionFilRouge();
			$aCrenaux = $oServiceI->getAllFilRougeWithPersonne($nIdActivite);
			$oListe = $this->view
					->listingCreneaux($aCrenaux['creneaux'], $aCrenaux['pris']);
			break;

		case ACTI_TYPE_TOURNOI:
		// 				$oForm = new Form_Tournoi($nIdActivite);
		// 				$this->view->headScript()->appendFile(SCRIPTS_PATH.'/forms/tournoi.js');
			$aEquipes = $oServiceI
					->getAllEquipesTournoiWithPersonnes($nIdActivite);
			$oListe = $this->view->listingEquipes($aEquipes);
			break;

		case ACTI_TYPE_CHALLENGE_EQUIPE:
			$aEquipes = $oServiceI
					->getAllEquipesChallengeWithPersonnes($nIdActivite);
			$oListe = $this->view->listingEquipes($aEquipes);
			break;

		case ACTI_TYPE_CHALLENGE_INDIVIDUEL:
			$aPersonnes = $oServiceI->getAllInscritsIndividuels($nIdActivite);
			$oListe = $this->view->listingPersonnes($aPersonnes);
			break;

		case ACTI_TYPE_BAPTEME:
			$aCrenaux = $oServiceI->getAllBaptemeWithPersonne($nIdActivite);
			$oListe = $this->view
					->listingCreneaux($aCrenaux['creneaux'], $aCrenaux['pris']);
			break;

		default:
			die("not Implemented");
			break;
		}

		$this->view->liste = $oListe;
	}

	public function printAction() {
		$this->_helper->layout->disableLayout();
		$nIdActivite = $this->getParam('idActivite');

		$oService = new Application_Service_Activites();
		$oActi = $oService->getActiviteInscriptibleById($nIdActivite);
		$this->view->oActi = $oActi;

		$oServiceI = new Application_Service_Inscriptions();

		switch ($oActi->getType()) {
		case ACTI_TYPE_FILROUGE:
		// 				$sMsgEdition = $this->view->translate('inscriptions.howto.filrouge');
		// 				$sMsgEdition = $oActi->getDescription();
			$nId = $oServiceI->getIdInscriptionFilRouge();
			$aCrenaux = $oServiceI->getAllFilRougeWithPersonne($nIdActivite);
			$oListe = $this->view
					->listingCreneaux($aCrenaux['creneaux'], $aCrenaux['pris']);
			break;

		case ACTI_TYPE_TOURNOI:
		// 				$oForm = new Form_Tournoi($nIdActivite);
		// 				$this->view->headScript()->appendFile(SCRIPTS_PATH.'/forms/tournoi.js');
			$aEquipes = $oServiceI
					->getAllEquipesTournoiWithPersonnes($nIdActivite);
			$oListe = $this->view->listingEquipes($aEquipes);
			break;

		case ACTI_TYPE_CHALLENGE_EQUIPE:
			$aEquipes = $oServiceI
					->getAllEquipesChallengeWithPersonnes($nIdActivite);
			$oListe = $this->view->listingEquipes($aEquipes);
			break;

		case ACTI_TYPE_CHALLENGE_INDIVIDUEL:
			$aPersonnes = $oServiceI->getAllInscritsIndividuels($nIdActivite);
			$oListe = $this->view->listingPersonnes($aPersonnes);
			break;

		case ACTI_TYPE_BAPTEME:
			$aCrenaux = $oServiceI->getAllBaptemeWithPersonne($nIdActivite);
			$oListe = $this->view
					->listingCreneaux($aCrenaux['creneaux'], $aCrenaux['pris']);
			break;

		default:
			die("not Implemented");
			break;
		}
		$this->view->liste = $oListe;

	}
}
