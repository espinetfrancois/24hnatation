<?php

class Projet_View_Helper_MentionLegales extends Zend_View_Helper_Abstract {


	public function mentionLegales() {
		$this->view->headLink()->appendStylesheet(STYLES_PATH.'/MentionsLegales.css');

		$oDiv = new Projet_Xml('div', array('id' => 'mentions-legales'));

		$oSpanTitre = new Projet_Xml('span',array( 'class' => 'titre'), $this->view->translate('mentions.legales.title'));

		$oDivContent = new Projet_Xml('div', array(), $this->view->translate('mentions.legales.content'));

		$oDiv->append(array($oSpanTitre, $oDivContent));

		return $oDiv->render();

	}

}