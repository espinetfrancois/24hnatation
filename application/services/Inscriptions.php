<?php

class Application_Service_Inscriptions {

	public function getTypesInscription() {
		return array(
				INSCRIPTIONS_TYPE_PERSO => Projet_DataHelper::translate(
						'inscriptions.type.perso'),
				INSCRIPTIONS_TYPE_BINET => Projet_DataHelper::translate(
						'inscriptions.type.binet'));
	}

	/**
	 * FIL ROUGE
	 */

	/**
	 *
	 * @author francois.espinet
	 * @param unknown $aData
	 * @throws Projet_Exception_Activite_MaxReservation
	 */
	public function saveFilRouge($aData) {
		$oIdent = Zend_Auth::getInstance()->getIdentity();
		if (count($aData[Form_FilRouge::CRENAUX]) > ACTI_TYPE_FIL_ROUGE_MAX_CRENEAUX && (int) $oIdent->getRole() < ACL_ROLE_ADMIN) {
			throw new Projet_Exception_Activite_MaxReservation("Le nombre de créneaux est limité à ".ACTI_TYPE_FIL_ROUGE_MAX_CRENEAUX);
			return;
		}

		//enregistrement de l'inscription
		$oMapper = new Application_Model_Mapper_InscriptionsFilRouges();

		$oInscription = new Application_Model_InscriptionFilRouge();
		$oInscription->setUid($oIdent->getUid());
// 		die(var_export($aData));
		$oInscription->setIdActivite($aData[Form_FilRouge::ID_ACTIVITE]);
		$oInscription->setTypeInscription($aData[Form_FilRouge::TYPE_INSCRIPTION]);
		if (!empty($aData[Form_Bapteme::ID])) {
			$oInscription->setId($aData[Form_FilRouge::ID]);
		}

		$oMapper->save($oInscription);

		if ($oInscription->getTypeInscription() == INSCRIPTIONS_TYPE_PERSO && count($aData[Form_FilRouge::PERSONNES_INSCRITES]) > 0) {
			//enregistrement des participants le cas echéant
			$oMapperParticipants = new Application_Model_Mapper_Participants();
			$oMapperParticipants->saveInscriptionFilRouge($aData[Form_FilRouge::PERSONNES_INSCRITES], $oInscription->getId(), $oInscription->getIdActivite());

		} elseif ($oInscription->getTypeInscription() == INSCRIPTIONS_TYPE_BINET) {
			$oMapperParticipants = new Application_Model_Mapper_Participants();
			$oMapperParticipants->saveInscriptionFilRougeBinet($aData[Form_FilRouge::BINET_INSCRIT], $oInscription->getId(), $oInscription->getIdActivite());
		}
		//marquage des creneaux comme reservés
		$oMapperCreneaux = new Application_Model_Mapper_RefCreneaux();
		$oMapperCreneaux->desinscriptionCreneauByIdActiviteAndIdInscription($oInscription->getIdActivite(), $oInscription->getId());

		$oCreneau = new Application_Model_Creneau();
		$oCreneau->setIdInscription($oInscription->getId());
		$oCreneau->setIdActivite($aData[Form_FilRouge::ID_ACTIVITE]);

		foreach ($aData[Form_FilRouge::CRENAUX] as $idCreneau) {
			$oCreneau->setId($idCreneau);
			$oMapperCreneaux->update($oCreneau);
		}
	}

	public function getFilRouge($nId) {
		$aRet[Form_FilRouge::ID] = $nId;
		$oMapper = new Application_Model_Mapper_InscriptionsFilRouges();
		$aRes = $oMapper->getInscriptionById($nId);
		$aRes = $aRes[0];
		$aRet[Form_FilRouge::TYPE_INSCRIPTION] = $aRes['TYPE_INSCRIPTION'];
		if ($aRet[Form_FilRouge::TYPE_INSCRIPTION] == INSCRIPTIONS_TYPE_PERSO) {
			$aRet[Form_FilRouge::PERSONNES_INSCRITES] = explode(SQL_CONCAT_SEPARATOR, $aRes['NOM_PRENOM']);

		} else {
			$aRet[Form_FilRouge::BINET_INSCRIT] = $aRes['NOM_PRENOM'];
		}
// 		die(var_export($aRes));
		return $aRet;
	}

	public function getCreneauxLibresFilRougeByUid($uid, $idActivite) {
		$oMapper = new Application_Model_Mapper_InscriptionsFilRouges();
		$aRes = $oMapper->getCrenauxLibresByUid($uid, $idActivite);
		$aPris = array();
		foreach ($aRes as $creneau) {
			if ($creneau['ID_INSCRIPTION'] != 0) {
				$aPris[] = $creneau['ID'];
			}
			$aCrenaux[$creneau['ID']] = $creneau['HEURE_DEBUT'] . ' - '
					. $creneau['HEURE_FIN'];
		}

		return array('creneaux' => $aCrenaux, 'pris' => $aPris);
	}

	public function getIdInscriptionFilRouge() {
		$oIdent = Zend_Auth::getInstance()->getIdentity();
		$oMapper = new Application_Model_Mapper_InscriptionsFilRouges();
		return $oMapper->getIdInscriptionByUid($oIdent->getUid());
	}

	/**
	 * TOURNOI
	 */

	public function saveTournoi($aData) {
		$oIdent = Zend_Auth::getInstance()->getIdentity();
		$oMapper = new Application_Model_Mapper_InscriptionsTournois();
		$oInscription = new Application_Model_InscriptionTournoi();

		$oInscription->setUid($oIdent->getUid());
		if ($aData[Projet_Form::ID] != "") {
			$oInscription->setId($aData[Form_Tournoi::ID]);
		}
		$oInscription->setIdActivite($aData[Form_Tournoi::ID_ACTIVITE]);
		$oInscription->setNomEquipe($aData[Form_Tournoi::NOM_EQUIPE]);
		$idInscription = $oMapper->save($oInscription);

		// 		die(var_dump($idInscription));
		$oLien = new Application_Model_Mapper_Participants();
		$oLien->saveInscriptionTournoi($aData[Form_Tournoi::MEMBRES],
						$idInscription, $oInscription->getIdActivite());
	}

	public function getTournoi($nId) {
// 		echo ($nId);
		$oMapper = new Application_Model_Mapper_InscriptionsTournois();
		$aData = $oMapper->find($nId);
		$aData = $aData[0];
		$oParticipants = new Application_Model_Mapper_Participants();
		$aDataP = $oParticipants->getParticipantsByIdInscriptionAndIdActivite($nId, $aData['ID_ACTIVITE']);
		$aRet[Form_Tournoi::ID] = $nId;
		$aRet[Form_Tournoi::MEMBRES] = $aDataP;
		$aRet[Form_Tournoi::ID_ACTIVITE] = $aData['ID_ACTIVITE'];
		$aRet[Form_Tournoi::NOM_EQUIPE] = $aData['NOM_EQUIPE'];
		return $aRet;
	}

	public function getIdInscriptionTournoi() {
		$oMapperT = new Application_Model_Mapper_InscriptionsTournois();
		return $oMapperT->getIdInscriptionByUid(Zend_Auth::getInstance()->getIdentity()->getUid());
	}


	/**
	 * CHALLENGES PAR EQUIPE
	 */

	public function saveEquipe($aData) {
		$oIdent = Zend_Auth::getInstance()->getIdentity();
		$oMapper = new Application_Model_Mapper_InscriptionsEquipes();
		$oInscription = new Application_Model_InscriptionEquipe();

		$oInscription->setUid($oIdent->getUid());
		if ($aData[Projet_Form::ID] != "") {
			$oInscription->setId($aData[Form_Equipe::ID]);
		}
		$oInscription->setNomEquipe($aData[Form_Equipe::NOM_EQUIPE]);
		$oInscription->setIdActivite($aData[Form_Equipe::ID_ACTIVITE]);
		$idInscription = $oMapper->save($oInscription);

		// 		die(var_dump($idInscription));
		$oLien = new Application_Model_Mapper_Participants();
		$oLien
				->saveInscriptionEquipe($aData[Form_Equipe::MEMBRES],
						$idInscription, $oInscription->getIdActivite());

	}

	public function getEquipe($nId) {
		$oMapper = new Application_Model_Mapper_InscriptionsEquipes();
		$aData = $oMapper->find($nId);
		$aData = $aData[0];
		$oParticipants = new Application_Model_Mapper_Participants();
		$aDataP = $oParticipants->getParticipantsByIdInscriptionAndIdActivite($nId, $aData['ID_ACTIVITE']);
		$aRet[Form_Equipe::ID] = $nId;
		$aRet[Form_Equipe::MEMBRES] = $aDataP;
		$aRet[Form_Equipe::ID_ACTIVITE] = $aData['ID_ACTIVITE'];
		$aRet[Form_Equipe::NOM_EQUIPE] = $aData['NOM_EQUIPE'];

		return $aRet;
	}

	public function getIdInscriptionEquipe() {
		$oMapperT = new Application_Model_Mapper_InscriptionsEquipes();
		return $oMapperT->getIdInscriptionByUid(Zend_Auth::getInstance()->getIdentity()->getUid());
	}

	/**
	 * CHALLENGES INDIVIDUELS
	 */

	public function saveIndividuel($aData) {
		$oMapper = new Application_Model_Mapper_InscriptionsIndividuelles();
		if (array_key_exists(Form_Individuel::DESINSCRIPTION, $aData)) {
			if ($aData[Form_Individuel::DESINSCRIPTION] == 1) {
				$oMapper->desinscrireById($aData[Projet_Form::ID]);
			}
		}
		$oInscription = new Application_Model_InscriptionIndividuelle();
		if (array_key_exists(Projet_Form::ID, $aData)) {
			$oInscription->setId($aData[Form_Equipe::ID]);
		}
		$oInscription->setIdActivite($aData[Form_Individuel::ID_ACTIVITE]);
		$oIdent = Zend_Auth::getInstance()->getIdentity();
		$oInscription->setUid($oIdent->getUid());

		$oMapper->save($oInscription);
	}

	public function getIdInscriptionIndividuelle() {
		$oMapperT = new Application_Model_Mapper_InscriptionsIndividuelles();
		return $oMapperT->getIdInscriptionByUid(Zend_Auth::getInstance()->getIdentity()->getUid());
	}

	/**
	 * TODO : fix
	 * @author francois.espinet
	 * @param unknown $nId
	 * @return multitype:unknown
	 */
	public function getIndividuel($nId) {
		return array('ID' => $nId);
	}

	/**
	 * BAPTEMES
	 */

	public function saveBapteme($aData) {
// 		die(var_dump($aData));
		//gros fake
		if (count($aData[Form_Bapteme::CRENAUX]) == 0 && $aData[Form_Bapteme::IS_DESINSCRIPTION] == "") {
			return;
		}

		$oIdent = Zend_Auth::getInstance()->getIdentity();
		//enregistrement de l'inscription
		$oMapper = new Application_Model_Mapper_InscriptionsBaptemes();



		$oInscription = new Application_Model_InscriptionBapteme();
		$oInscription->setUid($oIdent->getUid());
		$oInscription->setIdActivite($aData[Form_Bapteme::ID_ACTIVITE]);

		//modification de l'inscription
		if (!empty($aData[Form_Bapteme::ID])) {
			$oInscription->setId($aData[Form_Bapteme::ID]);
			//suppression du creneau précédement reservé
			$oMapperCreneaux = new Application_Model_Mapper_RefCreneaux();
			$oMapperCreneaux->desinscriptionCreneauByIdActiviteAndIdInscription($oInscription->getIdActivite(), $oInscription->getId());
			//si c'est une désinscription
			if (count($aData[Form_Bapteme::CRENAUX]) == 0 && $aData[Form_Bapteme::IS_DESINSCRIPTION] == "1") {
				$oMapper->delete($oInscription);
				return;
			}
		}

		$oMapper->save($oInscription);
		//marquage du creneau comme reservé
		$oMapperCreneaux = new Application_Model_Mapper_RefCreneaux();

		$oCreneau = new Application_Model_Creneau();
		$oCreneau->setId($aData[Form_Bapteme::CRENAUX]);
		$oCreneau->setIdInscription($oInscription->getId());
		$oCreneau->setIdActivite($aData[Form_Bapteme::ID_ACTIVITE]);

		$oMapperCreneaux->update($oCreneau);
	}

	public function getBapteme($nId) {
		// 		$oMapper = new Application_Model_Mapper_InscriptionsBaptemes();
		// 		$aRes = $oMapper->getInscriptionById($nId);
		$aRet[Form_Bapteme::ID] = $nId;
		return $aRet;
	}

	public function getIdInscriptionBapteme() {
		$oIdent = Zend_Auth::getInstance()->getIdentity();
		$oMapper = new Application_Model_Mapper_InscriptionsBaptemes();
		return $oMapper->getIdInscriptionByUid($oIdent->getUid());
	}


	/**
	 * GENERALITES
	 */


	public function getCreneauxLibresBaptemeByUid($uid, $idActivite) {
		$oMapper = new Application_Model_Mapper_InscriptionsBaptemes();
		$aRes = $oMapper->getCrenauxLibresByUid($uid, $idActivite);

		$aPris = array();
		foreach ($aRes as $creneau) {
			if ($creneau['ID_INSCRIPTION'] != 0) {
				$aPris[] = $creneau['ID'];
			}
			$aCrenaux[$creneau['ID']] = $creneau['HEURE_DEBUT'] . ' - '
					. $creneau['HEURE_FIN'];
		}

		return array('creneaux' => $aCrenaux, 'pris' => $aPris);
	}

	public function getCrenaux() {
		$aHeures = array();
		$aDebut = explode(':', HEURE_DEBUT);
		$oService = new Application_Service_Activites();
		$aHeures = $oService->getHeures();
		$a1 = array();
		$a2 = array();
		foreach ($aHeures as $h => $sH) {
			$aH = explode(':', $h);

			if ($aH[0] > $aDebut[0]) {
				if ($aH[1] > $aDebut[1]) {
					$a1[$h] = $sH;
				}
			} else {
				$a2[$h] = $sH;
			}
		}

		return array_merge($a1, $a2);
	}


	/**
	 *
	 *
	 * MAILS
	 *
	 *
	 *
	 */

	public static function sendChallengeToUser(Application_Model_Exterieur $oUser,Zend_View $view) {
		$oMail = new Projet_Mail();
		$oMail->setBodyText(
				Projet_DataHelper::varTranslate('mail.register.challenge.txt',
												array('APP_NAME'		=> APP_NAME,
													  'CHALLENGE_LINK' 	=> self::createChallengeLink($oUser, $view, false),
													  'DISPLAY_NAME'	=> $oUser->getNomPrenom()
												))
				);
		$oMail->setBodyHtml(Projet_DataHelper::varTranslate('mail.register.challenge.html',
															array('APP_NAME'	   => APP_NAME,
																  'CHALLENGE_LINK' => self::createChallengeLink($oUser, $view),
																  'DISPLAY_NAME'   => $oUser->getNomPrenom()
														))
				);
		$oMail->addTo($oUser->getEmail(), $oUser->getNomPrenom());
		$oMail->setSubject(Projet_DataHelper::varTranslate('mail.register.challenge.subject', array('APP_NAME' => APP_NAME)));
		$oMail->send();
	}

	public static function createChallengeLink(Application_Model_Exterieur $oUser,Zend_View $view, $isHtml = true) {
		//creation du lien
		$sRaw = $view->serverUrl().$view->url(array(), 'main-registerchallenge');
		//ajout des paramètres en get
		$sRaw = $sRaw."?uid=".$oUser->getUid().'&challenge='.$oUser->getChallenge();

		if ($isHtml) {
			$oA = new Projet_Xml('a', array('href' => $sRaw), $sRaw);
			return $oA->render();
		}

		return $sRaw;
	}

	/**
	 *
	 * ADMINISTRATION
	 *
	 */

	public function getAllFilRougeWithInscription($nIdActivite) {
		$oMapper = new Application_Model_Mapper_InscriptionsFilRouges();
		$aRes = $oMapper->getAllCreneauxWithIdInscription($nIdActivite);

		$aRet = array();
		$aPris = array();
		foreach ($aRes as $aCreneau) {
			$aRet[$aCreneau['ID']] = $aCreneau['HEURE_DEBUT'].' - '.$aCreneau['HEURE_FIN'];
			if ($aCreneau['ID_INSCRIPTION'] != 0) {
				$aPris[] = $aCreneau['ID'];
			}

		}
		return array('creneaux' => $aRet, 'pris' => $aPris);
// 		die(var_dump($aRes));

	}

	public function getAllFilRougeWithPersonne($nIdActivite) {
		$oMapper = new Application_Model_Mapper_InscriptionsFilRouges();
		$aRes = $oMapper->getAllCreneauxWithPerson($nIdActivite);
// 		die(var_dump($aRes));
		return $this->parseRawCreneaux($aRes, $nIdActivite);

	}

	public function getAllBaptemeWithPersonne($nIdActivite) {
		$oMapper = new Application_Model_Mapper_InscriptionsBaptemes();
		$aRes = $oMapper->getAllCreneauxWithPerson($nIdActivite);
// 		die(var_dump($aRes));
		return $this->parseRawCreneaux($aRes);
	}

	protected function parseRawCreneaux($aRes, $nIdActivite = 0) {
		$aRet = array();
		$aPris = array();
		foreach ($aRes as $aCreneau) {
			$oCreneau = new Application_Model_Creneau();

			$oCreneau->setId($aCreneau['ID']);
			$oCreneau->setHeureDebut($aCreneau['HEURE_DEBUT']);
			$oCreneau->setHeureFin($aCreneau['HEURE_FIN']);
			$oCreneau->setIdActivite($nIdActivite);
			$oCreneau->setIdJour($aCreneau['ID_JOUR']);
			if ($aCreneau['ID_INSCRIPTION'] != 0) {
// 				$oUtilisateur = new Application_Model_Utilisateur();
				//cas d'un élève
				if ($aCreneau['SPORT'] != null) {
					$oUtilisateur = new Application_Model_Eleve();
					$oUtilisateur->setSport($aCreneau['SPORT']);
				} else {
					$oUtilisateur = new Application_Model_Exterieur();
				}
				$oUtilisateur->setUid($aCreneau['UID']);
				$oUtilisateur->setNom($aCreneau['NOM']);
				$oUtilisateur->setPrenom($aCreneau['PRENOM']);
				$oUtilisateur->setNomPrenom($aCreneau['NOM_PRENOM']);
				$oCreneau->setUtilisateur($oUtilisateur);
				$oCreneau->setIdInscription($aCreneau['ID_INSCRIPTION']);
				$oParticipants = new Application_Model_Participants();
				$oParticipants->setNomPrenoms($aCreneau['PARTICIPANTS_NOM_PRENOMS']);
				$oCreneau->setParticipants($oParticipants);
// 				$oCreneau->
				$aPris[] = $oCreneau->getId();
			}
			$aRet[$aCreneau['ID']] = $oCreneau;
		}
		return array('creneaux' => $aRet, 'pris' => $aPris);
	}

	public function getAllEquipesTournoiWithPersonnes($nIdActivite) {
		$oMapper = new Application_Model_Mapper_InscriptionsTournois();

		$aRes = $oMapper->getAllEquipesWithPersonnes($nIdActivite);
		return $this->parseRawEquipes($aRes);
	}

	function getAllEquipesChallengeWithPersonnes($nIdActivite) {
		$oMapper = new Application_Model_Mapper_InscriptionsEquipes();
		$aRes = $oMapper->getAllEquipesWithPersonnes($nIdActivite);
		return $this->parseRawEquipes($aRes);
	}

	protected function parseRawEquipes($aRes) {
		$aEquipes = array();
		foreach ($aRes as $aEquipe) {
			$oEquipe = new Application_Model_Equipe($aEquipe);
			$aEquipes[$aEquipe['ID_INSCRIPTION']] = $oEquipe;
		}

		return $aEquipes;
	}

	function getAllInscritsIndividuels($nIdActivite) {
		$oMapper = new Application_Model_Mapper_InscriptionsIndividuelles();
		return $oMapper->getAllInscrits($nIdActivite);
	}
}
