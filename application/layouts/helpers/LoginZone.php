<?php

/**
 * Helper de vue permettant de créer la zone d'identification, en haut à droite.
 * Elle crée les liens vers les url d'authentification (ext et frankiz) en ajoutant un paramètre get sur l'url.
 * Ce paramètre est l'url courante, cela permet de rediriger l'utilisateur sur l'url demandée après l'avoir authentifié.
 * @author francois.espinet
 *
 */
class Layout_Helper_LoginZone extends Zend_View_Helper_Abstract {

	/**
	 * l'identité de l'utilisateur
	 * @var Application_Model_Utilisateur
	 */
	protected $oIdent;

	/**
	 *
	 * @author francois.espinet
	 * @param Projet_Xml $oLogin l'objet xml de login
	 * @param Application_Model_Utilisateur $oIdent l'identité de l'utilisateur
	 */
	public function loginZone(Projet_Xml $oLogin = null, Application_Model_Utilisateur $oIdent) {
		$this->oIdent = $oIdent;
		//s'il n'est pas connecté, on met les liens de connexion
		//sinon on lui met un lien pour la deconnexion et un span caché avec l'id de son role (javascript)
		if ($oIdent == null ) {
			$oLogin->append($this->connexion());
		} else {
			$oLogin->append($this->connected());
			$oLogin->append(new Projet_Xml('span', array('class' => CSS_LAYOUT_NONE, 'id' => 'role'), $this->oIdent->getRole()));
		}
	}

	/**
	 *
	 * @author francois.espinet
	 * @return string
	 */
	public function connexion() {
		$oBoutonFkz = new Projet_Xml('a', array('href'  => $this->view->url(array(), 'main-login_ext'),
												   'class' => CSS_BOUTON), $this->view->translate('reg.connect'));
		$oBoutonExt = new Projet_Xml('a', array('href'  => $this->view->url(array(), 'main-login_fkz').'?location='.Zend_Controller_Front::getInstance()->getRequest()->getRequestUri(),
												   'class' => CSS_BOUTON), $this->view->translate('fkz.connect'));
		return $oBoutonFkz->render().$oBoutonExt->render();

	}

	/**
	 * Retourne un bouton avec nom et prénom de l'utilisateur et lien vers la deconnexion.
	 * @author francois.espinet
	 * @return Projet_Xml
	 */
	public function connected() {
		$oBouton = new Projet_Xml('a', array('href' => $this->view->url(array(), 'main-logout'),
												'class' => CSS_BOUTON), $this->oIdent->getNomPrenom());

		return $oBouton;
	}


}