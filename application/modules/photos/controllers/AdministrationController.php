<?php

class Photos_AdministrationController extends Projet_Controller_Action {

	public function indexAction() {

	}

	public function gerercategoriesAction() {
		$oForm = new Form_AjouterCategorie();
		$this->formCreer($oForm);
	}

	public function gererphotosAction() {
		$oMapper = new Application_Model_Mapper_RefCategories();
		$oForm = new Form_SelectCategorie($oMapper->getLibelles());
		$this->view->form = $oForm;

		$oService = new Application_Service_Photos();
		$this->view->photos = $oService->getAllPhotos();
	}

	public function ajouterphotoAction() {
		$oMapper = new Application_Model_Mapper_RefCategories();
		$oForm = new Form_AjouterPhoto($oMapper->getLibelles());

		$oLien = new Projet_Xml('a', array("href" => $this->_helper->Url->url(array(), 'photos-admin_photo_add')), $this->view->translate("photo.add.new"));

		// Vérification de la réponse au formulaire.
		if ($this->getRequest()->isPost()) {
			if( $oForm->isValid($this->getRequest()->getPost() ) ) {
				// Lorsque la réponse est valide, on proc√®de à l'enregistrement.
				$sSaveMethode = $oForm->getSvcSaveMethode();
				try {
					$oForm->getService()->$sSaveMethode($oForm->getValues(),$oForm);
					$this->view->message = $oLien->render();
					// on ne donne pas le formulaire à la vue

					return self::FORM_SUCCES;

				} catch (Projet_Exception_Doublon $e) {
					$this->view->errors = true;
					$this->view->message = $msgInvalid;
					$ret = self::FORM_DOUBLON;
				} catch (Exception $e) {
					if (APP_DEBUG) {
						throw new Zend_Exception('FORM_SAVE', "cf service form Save ou équivalent", $e);
					} else {
						$this->view->message = 'message.enregistrement.echec';
						return self::FORM_INVALID;
					}
				}
			} else  {
				$this->view->errors = true;
				// Lorsque la réponse est invalide, un message est donné au Layout qui le détecte et l'affiche.
				$this->view->message = $this->view->translate('photo.doublon');
				$ret = self::FORM_INVALID;
			}
		} else {
			// Lorsque la réponse n'existe pas, un message est donné au Layout qui le détecte et l'affiche.
			$this->view->message = "";
			$ret = self::FORM_RIEN;
		}
		// On donne le formulaire à la vue.
		$this->view->form = $oForm;
		return $ret;
		$this->formCreer($oForm, "photo.add", $oLien->render());
	}
}