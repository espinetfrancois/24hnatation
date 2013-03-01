<?php

/**
 * Gestion de l'authentification via frankiz
 * @author francois.espinet
 * @TODO : throws exceptions
 * @TODO : externaliser le nom du binet
 */
class Projet_Controller_Action_Helper_Frankiz extends Zend_Controller_Action_Helper_Abstract {

	/**
	 * Temps maxima pour la requete
	 * @var int
	 */
	const TIMEOUT = 600;
	protected $_fkzKey;
	protected $_site;
	protected $_urlRemote;
	protected $_request;

	public $aResponse = null;

	public $location = "/";

	const BINET_NAME = "24hnatation";

	public function __construct($key, $site, $urlRemote, $aRequest) {
		$this->_fkzKey = $key;
		$this->_site = $site;
		$this->_urlRemote = $urlRemote;
		$this->_request = json_encode($aRequest);
	}

	function doAuth() {
		/**
		 * Prendre le timestamp permet d'éviter le rejet de la requête
		 */
		$timestamp = time();

		/**
		 * Nature de la requête.
		 * Fkz renverra ici à la fois les noms de la personne mais aussi ses droits dans différents groupes.
		 * Il faut cependant que le site ait les droits sur les informations en question (à définir lors de son inscription).
		 */
		//$request = json_encode(array('names', 'rights', 'email', 'sport', 'promo', 'photo'));


		$hash = md5($timestamp . $this->_site . $this->_fkzKey . $this->_request);
		$remote  = $this->_urlRemote.'?timestamp=' . $timestamp .
		'&site=' . $this->_site .
		'&location=' . $this->location .
		'&hash=' . $hash .
		'&request=' . $this->_request;
// 		Zend_Controller_Front::getInstance()->getResponse()->setHeader('Location', $remote);
// 		header("Location:" . $remote);
		$this->getResponse()->setRedirect($remote);
		$this->getResponse()->sendResponse();
// 		exit();
	}

	function getReponse() {
		$this->parseRawResponse();

		$oUser = new Application_Model_Eleve();
		$oUser->setUid($this->aResponse['hruid']);
		$oUser->setBinetsAdmin($this->aResponse['binets_admin']);
		$oUser->setDroits($this->aResponse['rights']);
		$oUser->setEmail($this->aResponse['email']);
		$oUser->setNom($this->aResponse['lastname']);
		$oUser->setPrenom($this->aResponse['firstname']);
		$oUser->setSport($this->aResponse['sport']);

// 		die(var_dump($oUser->getDroits()));
		//on donne le rôle admin si la personne est admin
		if ( $oUser->getBinetsAdmin() != null && array_key_exists(self::BINET_NAME, $oUser->getBinetsAdmin())) {
			$oUser->setRole('10');
			//on check si par hasard ça ne serait pas un webmaster
			$oMapper = new Application_Model_Mapper_Webmasters();
			if ($oMapper->isWebmaster($oUser->getUid())) {
				$oUser->setRole('11');
			}
		} else {
			$oUser->setRole('2');
		}

		$this->aResponse = null;

		$oService = new Application_Service_Login();
		$oService->saveEleve($oUser);

		Zend_Auth::getInstance()->getStorage()->write($oUser);
		//redirection vers la page demandée
		$this->getResponse()->setRedirect(str_replace("'", "", $this->location));

	}

	function parseRawResponse() {
			// Read request
			$timestamp = (isset($_GET['timestamp']) ? $this->getRequest()->getParam('timestamp') : 0);
			$response  = (isset($_GET['response'])  ? urldecode($this->getRequest()->getParam('response'))  : null);
			$hash      = (isset($_GET['hash'])      ? $this->getRequest()->getParam('hash')      : null);
			$location  = (isset($_GET['location'])  ? $this->getRequest()->getParam('location')  : $this->location);

			if ($response === null || $hash == null) {
				$this->doAuth();
			}

			// Frankiz security protocol
			if (abs($timestamp - time()) > self::TIMEOUT)
				die("Délai de réponse dépassé. Annulation de la requête");
			if (md5($timestamp . $this->_fkzKey . $response) != $hash)
				die("Session compromise.");

			$this->aResponse = json_decode($response, true);
			$this->location = $location;

			// Set empty fields
			$fields = array('hruid', 'rights');

			foreach ($fields as $k) {
				if (!isset($this->aResponse[$k]))
					$this->aResponse[$k] = null;
			}
	}
}
