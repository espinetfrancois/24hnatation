<?php

class Projet_Mail extends Zend_Mail {

	public function __construct($charset = null) {
		parent::__construct('utf8');
		$this->setDefaultFrom(APP_MAIL_ADDRESS, APP_NAME);
	}
	public function send($transport = null) {
		if (APP_MAIL) {
// 			$oTransport = $transport | new Zend_Mail_Transport_Sendmail();
			parent::send(new Zend_Mail_Transport_Sendmail());
		} else {
			die(var_dump($this));
		}
	}

}