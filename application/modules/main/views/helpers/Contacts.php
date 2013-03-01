<?php

class views_helpers_Contacts extends Zend_View_Helper_Abstract {

	public function contacts($aContacts = array()) {
		$sRes = new Projet_Xml('div', array('class' => 'contacts'));
		foreach ($aContacts as $sRole => $aContact) {
			$sRes->append($this->generateContact($aContact, $sRole));
		}

		return $sRes->render();
	}

	protected function generateContact($aContact,$sRole) {
		$oSpanTitre = new Projet_Xml('span', array('class' => 'titre'), $this->view->translate($sRole));
		$oDivContact = new Projet_Xml('div', array('class' => 'contact'));
		$oDivContact->append($oSpanTitre);
		$oDivContact->append('<br/>');
		foreach ($aContact as $oContact) {
			$oSpan = new Projet_Xml('span', array('class'=> 'personne'));
			$oSpanNomPrenom = new Projet_Xml('span', array('class' => 'nomprenom'), strtoupper($oContact->getNom()).' '.$oContact->getPrenom());
			$oSpanNum = new Projet_Xml('span', array('class' => 'numero'), $oContact->getTelephone());

			$oSpan->append(array($oSpanNomPrenom, $oSpanNum));

			$oDivContact->append($oSpan);

		}

		return $oDivContact;
	}



}
