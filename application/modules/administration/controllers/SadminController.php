<?php
/**
 * Controlleur page d'accueil.
 *
 *
 * @package    modules_main
 * @subpackage controllers
 */
class Administration_SadminController extends Projet_Controller_Action_Ssl {

	public function phpinfoAction() {
		$this->view->config = phpinfo();
	}

	public function indexAction() {

	}

	public function gestionutilisateursAction() {

	}

	public function listerutilisateursAction() {
		$oService = new Application_Service_Login();
		$this->view->aUsers = $oService->getAllUsers();
	}

	public function ajouterutilisateurAction() {
		$this->formCreer(new Form_FullRegister());
	}

	public function binetsAction() {
		$oLdap = new Projet_Ldap('posixAccount', array('baseDn' => 'ou=groups,dc=frankiz,dc=net'));
		$oLdap->select(array('brns', 'uid'))
			  ->where('brNS = ?', ' binet');
		die(var_dump($oLdap->fetchAll(true)));
	}

	public function controlpanelAction() {

	}

	public function changermdputilisateurAction() {
		$nIdUtilisateur = $this->getParam('uidUtilisateur');
		$this->formCreer(new Form_ChangeUserPasswd($nIdUtilisateur));
	}



}
