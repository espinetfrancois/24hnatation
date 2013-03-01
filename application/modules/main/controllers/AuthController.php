<?php
/**
 * Controlleur page d'accueil.
 *
 * @remark	ATTENTION : seul contrôleur sans nameSpace "Main_"
 *
 * @package    modules_main
 * @subpackage controllers
 */
class AuthController extends Projet_Controller_Action_Ssl {

	public function frankizAction() {
		if (($location = $this->getParam('location')) != "") {
			$this->_helper->Frankiz->location = $this->getParam('location');
		}
		// 		die($this->_helper->Frankiz->location);
		$this->_helper->Frankiz->getReponse();
	}

// 	public function loginAction() {
// 		if (Zend_Auth::getInstance()->hasIdentity()) {
// 			$this->view->logged = true;
// 		} else {
// 			//récupération de l'url demandée à la base
// 			$this->view->location = new Zend_Session_Namespace('location');
// 		}
// 	}

	public function logoutAction() {
		Zend_Auth::getInstance()->clearIdentity();
		$this->_helper->redirector->gotoRoute(array(), 'main-accueil');
	}

	public function loginextAction() {
		$oForm = $this->getLoginForm();
		$this->view->registerUrl = $this->_helper->Url
				->url(array(), 'main-register');
		$this->view->oForm = $oForm;
	}

	public function registerAction() {
		$this->view->oForm = $this->getRegisterForm();
	}

	public function registerchallengeAction() {
		//vérification du mail par un lien
		$uid = $this->getParam('uid');
		$challenge = $this->getParam('challenge');

		$oMapper = new Application_Model_Mapper_RefExterieurs();
		if ($challenge != $oMapper->getChallengeByUid($uid)) {
			die("erreur");
		} else {
			$oMapper->validateUserByUid($uid);
			$this->view->message = "register.valid.inscription";
		}
	}

	public function registerprocessAction() {
		//remplissage des informations
		$request = $this->getRequest();
		// Check if we have a POST request
		if (!$request->isPost()) {
			return $this->_helper->redirector
					->gotoRoute(array(), 'main-accueil');
		}

		$form = $this->getRegisterForm();
		$aData = $request->getPost();
		if (!$form->isValid($aData)) {
			// Invalid entries
			$this->view->oForm = $form;
			return $this->render('register'); // re-render the login form
		}

		$mail = $aData[Form_Register::LOGIN];

		//récupération des information du ldap
		$ldap = new Projet_Ldap();
		$ldap->select(array('uid', 'displayName', 'sn', 'givenName', 'mail'))
				->where('mail = ?', $mail);
		$aResult = $ldap->fetchAll();
		if (count($aResult) < 1) {
			$form->addError('register.user.not_exists');
			$this->view->oForm = $form;
			return $this->render('register');
		} else {
			$aLdap = $aResult[0];
		}

		//traitement des informations
		$oUser = new Application_Model_Exterieur();
		$oUser->setNom($aLdap['sn']);
		$oUser->setPrenom($aLdap['givenname']);
		$oUser->setEmail($aLdap['mail']);
		$oUser->setUid($aLdap['uid']);
		$oUser->setNomPrenom($aLdap['displayname']);
		$oUser->setRole(ACL_ROLE_CADRE);

		$oUser->assignSalt();
		$oUser->assignChallenge();

		$oUser->setMdp($aData[Form_Register::PASSWD]);
		//enregistrement de l'utilisateur dans la BDD
		$oMapper = new Application_Model_Mapper_Utilisateurs();
		$oMapExt = new Application_Model_Mapper_RefExterieurs();

		try {
			$oMapper->save($oUser, false);
			$oMapExt->save($oUser);

			//envoi d'un mail avec le challenge
			Application_Service_Inscriptions::sendChallengeToUser($oUser, $this->view);
			$this->view->message = 'register.success.blabla';
			return $this->render();
		} catch (Projet_Exception_Doublon $e) {
			$form->addError($this->view->translate('user.already.registered'));
			$this->view->oForm = $form;
			return $this->render('register');
		}
	}

	protected function getRegisterForm() {
		return new Form_Register(
				$this->_helper->Url->url(array(), 'main-registerprocess'));
	}

	protected function getLoginForm() {
		return new Form_Login(
				$this->_helper->Url->url(array(), 'main-authenticate'),
				$this->getParam('location'));
	}

	public function authenticateAction() {
		$request = $this->getRequest();
		// Check if we have a POST request
		if (!$request->isPost()) {
			return $this->_helper->redirector
					->gotoRoute(array(), 'main-login_ext');
		}

		// Get our form and validate it
		$form = $this->getLoginForm();
		if (!$form->isValid($request->getPost())) {
			// Invalid entries
			$this->view->oForm = $form;
			return $this->render('loginext'); // re-render the login form
		}

		$aValues = $form->getValues();
		// Get our authentication adapter and check credentials
		$adapter = $this->getAuthAdapter($aValues);
		$auth = Zend_Auth::getInstance();
		//authentification
		$result = $auth->authenticate($adapter);
		if (!$result->isValid()) {
			// Invalid credentials
			$form->addError($this->view->translate('login.fail'));
			$this->view->oForm = $form;
			return $this->render('loginext'); // re-render the login form
		}
		$oService = new Application_Service_Login();
// 		$mail = $adapter->getResultRowObject('EMAIL')->EMAIL;
		$oUser = $oService->getUserByEmail($aValues[Form_Login::LOGIN]);

		$auth->getStorage()->write($oUser);

		// We're authenticated! Redirect to the home page
		$this->_helper->redirector->gotoUrlandExit(str_replace("'", "", $form->getValue(Form_Login::LOCATION)));
	}


	protected function getAuthAdapter(array $params) {
		$oUser = new Application_Model_Exterieur();
		$oUser->setEmail($params[Form_Login::LOGIN]);

		$oService = new Application_Service_Login();
		$oUser->setUid($oService->getUserUidByEmail($oUser->getEmail()));
		$oUser->setSalt($oService->getUserSalt($oUser->getEmail()));

		$oUser->setMdp($params[Form_Login::PASSWD]);

		$oAuth = new Zend_Auth_Adapter_DbTable();
		$oAuth->setTableName('REF_EXTERIEURS')->setIdentityColumn('UID')
				->setCredentialColumn('MDP')
				->setIdentity($oUser->getUid())
				->setCredential($oUser->getMdp())
				->setCredentialTreatment('? AND VALID = 1');

		return $oAuth;
	}

}
