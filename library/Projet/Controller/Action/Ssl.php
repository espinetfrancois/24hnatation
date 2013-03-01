<?php
class Projet_Controller_Action_Ssl extends Projet_Controller_Action {

	public function init() {
		if ( !isset($_SERVER['HTTPS']) ) {
			$response = $this->getResponse();
			$response->setRedirect('https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
		}
	}
}
