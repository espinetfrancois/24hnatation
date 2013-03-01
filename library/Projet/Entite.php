<?php

class Projet_Entite extends ArrayObject {

	protected $_id = null;

	public function getId() {
		return $this->_id;
	}

	public function setId($id) {
		//vide c'est comme null!
		if ($id == "") {
			$this->_id = null;
		} else {
			$this->_id = $id;
		}

	}

}