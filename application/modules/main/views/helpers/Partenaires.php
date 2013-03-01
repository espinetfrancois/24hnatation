<?php

class views_helpers_Partenaires extends Zend_View_Helper_Abstract {


	const NB_COLORS = 3;

	public function partenaires(array $aPartenaires = array()) {
		$oPartenaires = new Projet_Xml('div', array('id' => 'partenaires'));
		foreach($aPartenaires as $categorie) {
			$oPartenaires->append($this->generateCategorie($categorie));
		}

		return $oPartenaires;
	}

	protected function generateCategorie($aCategorie) {
		$oPartenaires = new Projet_Xml('div', array('class' => 'categorie'));
		$oSpan = new Projet_Xml('span', array(), $aCategorie['label']);
		$oPartenaires->append($oSpan);
		$oContainer = new Projet_Xml('div', array('class' => 'container'));

		$oPartenaires->append($oContainer);
		foreach($aCategorie['content'] as $aPartenaire) {
			$oContainer->append($this->generatePartenaires($aPartenaire));
		}
		return $oPartenaires;
	}

	protected function generatePartenaires($aPartenaire) {
		$oDiv = new Projet_Xml('div', array('class' => 'partenaire'));
		$oImg = new Projet_Xml('img', array('src' => IMAGES_PATH.'/partenaires/'.$aPartenaire['img']));
		$oSpan = new Projet_Xml('span', array(), $aPartenaire['label']);

		$oDiv->append(array($oImg, $oSpan));

		return $oDiv;
	}

}
