<?php

class Inscriptions_View_Helper_InscriptionsActi extends
		Zend_View_Helper_Abstract {

	protected $aActis = null;
	protected $aJours = array();

	public function inscriptionsActi(array $aActis = array(), array $aJours = array(),
			$isAdmin = false) {
		$this->aActis = $aActis;
		$this->aJours = $aJours;
		$oRes = new Projet_Xml('div', array('id' => 'inscriptions'));

		$this->addActivites($oRes, $isAdmin);
		return $oRes->render();
	}

	protected function addActivites($oGlob, $isAdmin) {
		foreach ($this->aActis as $oActi) {
			$oDivActi = new Projet_Xml('div', array('class' => 'activite'));
			$oDivActi->setAttr('title', $oActi->getDescription());
			if ($isAdmin) {
				$oDivActi->addToAttr('class', 'admin');
			}
			$oTitreActi = new Projet_Xml('span', array('class' => 'titre'),
					$oActi->getNom());
			$oDivActi->append($oTitreActi);

			$oLienInscription = new Projet_Xml('a',
					array(
							'href' => $this->view
									->url(array(), 'inscriptions-start')
									. '?idActivite=' . $oActi->getId()),
					$this->view->translate('inscriptions.sinscrire'));

// 			if ($isAdmin) {
// 				$oLienInscription->setContent($this->view->translate('inscriptions.admin.voir'));
// 				$oLienInscription->setAttr('href', $this->view->url(array(), 'inscriptions-admin_acti'). '?idActivite=' . $oActi->getId());
// 			}
			$oDivActi->append($oLienInscription);
			$oDivActi->append(new Projet_Xml('a',
					array('href' => $this->view->url(array(), 'inscriptions-admin_listings').'?idActivite=' . $oActi->getId()),
					$this->view->translate("inscriptions.admin.listings")));
			if ($isAdmin) {
				$oDivActi->append(new Projet_Xml('a',
									array('href' => $this->view->url(array(), 'inscriptions-admin_print').'?idActivite=' . $oActi->getId()),
									$this->view->translate("inscriptions.admin.print")));
			}
			$oGlob->append($oDivActi);
		}

	}

}
