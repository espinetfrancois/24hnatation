<?php

class Administration_View_Helper_ListeUtilisateurs extends
		Zend_View_Helper_Abstract {

	public function listeUtilisateurs($aUsers = array()) {
		$oListe = new Projet_Xml('table', array('class' => 'listing'));
		$oListeHead = new Projet_Xml('thead', array(),
				array(new Projet_Xml('td', array(), 'Id'),
						new Projet_Xml('td', array(), 'UID'),
						new Projet_Xml('td', array(), 'Email'),
						new Projet_Xml('td', array(), 'Nom Prenom'),
						new Projet_Xml('td', array(), 'Sport'),
						new Projet_Xml('td', array(), 'Compte activé ?'),
						new Projet_Xml('td', array(), "Changer le mot de passe")
					));
		$oListeBody = new Projet_Xml('tbody', array());
		$oListe->append(array($oListeHead, $oListeBody));

		foreach ($aUsers as $oUser) {
			$oListeBody->append($this->getRow($oUser));
		}

		return $oListe;
	}

	public function getRow(Application_Model_Utilisateur $oUser) {
		$oRow = new Projet_Xml('tr');
		$oRow
				->append(
						array(
								new Projet_Xml('td', array(),
										$oUser->getId()),
								new Projet_Xml('td', array(),
										$oUser->getUid()),
								new Projet_Xml('td', array(), $oUser->getEmail()),
								new Projet_Xml('td', array(),
										$oUser->getNomPrenom())
						// 				new Projet_Xml('td', array(), $oEquipe->getInscription()->get)
						));

		if ($oUser instanceof Application_Model_Eleve) {
			$oRow->append(array(new Projet_Xml('td', array(), $oUser->getSport()),new Projet_Xml('td')));
		} elseif ($oUser instanceof Application_Model_Exterieur) {
			$oRow->append(array(new Projet_Xml('td'), new Projet_Xml('td', array(), $oUser->getValid())));
		} else {
			$oRow->append(array(new Projet_Xml('td'), new Projet_Xml('td')));
		}
		if ($oUser instanceof Application_Model_Exterieur) {
			$oLien = new Projet_Xml('a', array('class' => CSS_BOUTON, 'href' => $this->view->url(array(), 'superadmin-changeuserpasswd').'?uidUtilisateur='.$oUser->getUid()), $this->view->translate('sadmin.change.passwd'));
			$oCase = new Projet_Xml('td', array(), $oLien);
			$oRow->append($oCase);
		} else {
			$oRow->append(new Projet_Xml('td'));
		}

		return $oRow;
	}
}
