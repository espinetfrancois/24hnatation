<?php
/**
 * Controlleur page d'accueil.
 *
 * @remark	ATTENTION : seul contrôleur sans nameSpace "Main_"
 *
 * @package    modules_main
 * @subpackage controllers
 */
class Administration_AxsadminController extends
		Projet_Controller_Action_Ajax_Ssl {

	public function rmutilisateurbyuidAction() {

	}

	public function majmdpbyuidAction() {

	}

	public function cleartranslatecacheAction() {
		if (APP_CACHE) {
			try {
				Zend_Translate::getCache()->clean(Zend_Cache::CLEANING_MODE_ALL);
				$this->view->message = "Cache des traductions nettoyé";
			} catch (Exception $e) {
				$this->view->message = "Echec : " . $e->getMessage();
			}
		} else {
			$this->view->message = "Le cache n'est pas actif";
		}

	}

	public function testmailAction() {
		$oMail = new Projet_Mail();

		$oMail->addTo("francois.espinet@polytechnique.edu");
		$oMail->setSubject("Test de mail de l'application 24hnatation");
		$oMail->setBodyHtml("Ceci est un test.");

		try {
			$oMail->send();
			$this->view->message = "Envoi réussit";
		} catch (Exception $e) {
			$this->view->message = $e->getMessage();
			$this->view->exception = $e;
		}
	}
}
