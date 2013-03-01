<?php

class Photos_View_Helper_AfficherPhotos extends Zend_View_Helper_Abstract {

	/**
	 * @var Projet_Form
	 */
	private $_form = null;
	private $_aPhotos;
	private $_isAdmin = false;
	private $_height;
	private $_width;

	public function afficherPhotos($isAdmin = false, $height = "200", $width = "200") {
		$this->_isAdmin = $isAdmin;
		$this->_height = $height;
		$this->_width = $width;

		return $this;
	}

	public function setForm(Projet_Form $oForm) {
		$this->_form = $oForm;
	}

	public function setPhotos(array $aPhotos) {
		$this->_aPhotos = $aPhotos;
	}

	private function constructTag(Application_Model_Photo $photo) {
		$sPhoto = "<img class='photo' src='".PHOTOS_PATH .'/'. $photo->getNomFichier() . "' width='"
				. $this->_width . "' height='" . $this->_height . "'>";
		if ($this->_isAdmin && $this->_form !== null) {
			$element = $this->_form->getElement(Form_SelectCategorie::CATEGORIE);
			$element->setValue($photo->getIdCategorie());
			$oDImg = new Projet_Xml('div', array('class' => 'photo', 'id' => "photo_".$photo->getId()), $sPhoto.$this->_form->render());
			$oSpanUploader = new Projet_Xml('span', array('class' => 'uploader'), $photo->getUidUtilisateur());
			$oSpanSuppr = new Projet_Xml('span', array('class' => CSS_BOUTON.' photo_delete'), $this->view->translate("act.suppr"));

			$oDImg->append(array($oSpanUploader, $oSpanSuppr));
			$sPhoto = $oDImg->render();
		}

		return $sPhoto;
	}

	public function __toString() {
		$sPhoto = "";
		if (count($this->_aPhotos) > 0) {
			foreach ($this->_aPhotos as $photo) {
				$sPhoto .= $this->constructTag($photo);
			}
		} else {
			$sPhoto = $this->view->translate("no.photo");
		}
		return $sPhoto;
	}
}
