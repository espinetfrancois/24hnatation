<?php

class Photos_View_Helper_AfficherCategories extends Zend_View_Helper_Abstract {

	public function afficherCategories($aCategories = array()) {
		$sCategories = "<table><thead><tr><th>".$this->view->translate("libelle")."</th></thead></tr><tbody>";
		if (count($aCategories) > 0) {
			foreach ($aCategories as $id=>$lib) {
				$sCategories .= "<tr><td>".$lib."</td><td>"."<span class='supprimer bouton' id='cat_".$id."'>" .$this->view->translate("act.suppr").'</span>'."</td></tr>";
			}
		} else {
			$sCategories = $this->view->translate("cat.no");
		}
		return $sCategories.'</tbody></table>';
	}
}
