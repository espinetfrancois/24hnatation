<?php

class Projet_View_Helper_FormLogin extends Zend_View_Helper_Abstract {


	public function formLogin(Zend_Session_Namespace $location = null) {
		$oSpanConnexion = new Projet_Xml('span', array(), $this->view->translate('connect.yourself')." :");
		$oForm = new Projet_Xml('div', array('id' => 'login'));
		$oBoutonFkz = new Projet_Xml('a', array('href'  => $this->view->url(array(), 'main-login_ext').$this->setParam('location',$location),
				'class' => CSS_BOUTON), $this->view->translate('reg.connect'));
		$oBoutonExt = new Projet_Xml('a', array('href'  => $this->view->url(array(), 'main-login_fkz').$this->setParam('location',$location),
				'class' => CSS_BOUTON), $this->view->translate('fkz.connect'));
		$oForm->append(array($oSpanConnexion,$oBoutonExt, $oBoutonFkz));
		return $oForm->render();
	}

	protected function setParam($key, Zend_Session_Namespace $session = null) {
		if ($session == null ) {
			return "?".$key."='/'";
		}
		return "?".$key."='".$session->location."'";
	}


}