<?php
/**
 * Controlleur page d'accueil.
 *
 * @remark	ATTENTION : seul contrôleur sans nameSpace "Main_"
 * TODO : désinscription pour les individuel
 * @category   Projet
 * @package    modules_main
 * @subpackage controllers
 */
class Inscriptions_IndexController extends Projet_Controller_Action {

	public function indexAction() {
		if (STATE_INSCRIPTIONS) {
			$oService = new Application_Service_Activites();
			$this->view->aActis = $oService->getInscriptibleActivites();
			$this->view->aJours = $oService->getJours();
		} else {
			$this->view->messageFerme = "inscriptions.closed";
		}
	}

	public function commencerAction() {
		if (!STATE_INSCRIPTIONS) {
			$this->view->message = "incsriptions.closed";
			return;
		}
		$nIdActivite = $this->getParam('idActivite');
		$oService = new Application_Service_Activites();
		$oActi = $oService->getActiviteInscriptibleById($nIdActivite);
		$this->view->oActi = $oActi;

		$oServiceI = new Application_Service_Inscriptions();
		$oIdent = Zend_Auth::getInstance()->getIdentity();
		$sMsgEdition = "";
		$nId = null;
// 		die($oActi->getType());
		switch ($oActi->getType()) {
			case ACTI_TYPE_FILROUGE:
// 				$sMsgEdition = $this->view->translate('inscriptions.howto.filrouge');
				$sMsgEdition = $oActi->getDescription().'<br/>'.$this->view->translate('inscriptions.howto.filrouge');
				$nId = $oServiceI->getIdInscriptionFilRouge();
				$aCrenaux = $oServiceI->getCreneauxLibresFilRougeByUid($oIdent->getUid(), $nIdActivite);
				$oForm = new Form_FilRouge($aCrenaux['creneaux'], $aCrenaux['pris'], $oServiceI->getTypesInscription(), $nIdActivite);
			break;

			case ACTI_TYPE_TOURNOI:
				$oForm = new Form_Tournoi($nIdActivite);
				$this->view->headScript()->appendFile(SCRIPTS_PATH.'/forms/tournoi.js');
				$nId = $oServiceI->getIdInscriptionTournoi();
			break;

			case ACTI_TYPE_CHALLENGE_EQUIPE:
				$nId = $oServiceI->getIdInscriptionEquipe();
				$oForm = new Form_Equipe($nIdActivite);
				$this->view->headScript()->appendFile(SCRIPTS_PATH.'/forms/equipe.js');
			break;

			case ACTI_TYPE_CHALLENGE_INDIVIDUEL:
				$nId = $oServiceI->getIdInscriptionIndividuelle();
				$this->view->headScript()->appendFile(SCRIPTS_PATH.'/forms/individuel.js');
				$sMsgEdition = "En cliquant sur le bouton ci-dessous, vous vous inscrivez à l'évènement.";
				$oForm = new Form_Individuel($nIdActivite);
			break;

			case ACTI_TYPE_BAPTEME:
				$this->view->headScript()->appendFile(SCRIPTS_PATH.'/forms/bapteme.js');
				$nId = $oServiceI->getIdInscriptionBapteme();
				$aCrenaux = $oServiceI->getCreneauxLibresBaptemeByUid($oIdent->getUid(), $nIdActivite);
				$oForm = new Form_Bapteme($aCrenaux['creneaux'], $aCrenaux['pris'], $nIdActivite);
			break;

			default:
				die("not Implemented");
			break;
		}
		//s'il s'est deja inscrit
		if ($nId != null) {
			$this->formModifier($oForm, $nId,$sMsgEdition);
		} else {
			$this->formCreer($oForm, $sMsgEdition);
		}
// 		$this->view->form = $oForm;

	}

}
