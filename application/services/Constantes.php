<?php
class Application_Service_Constantes {


	public static function css() {
		Application_Service_Constantes::_form();
		self::_actions();
		self::_layout();
	}

	public static function images() {
		Application_Service_Constantes::_images();
	}

	public static function metier() {
		self::_contacts();
		self::_actis();
		self::_inscriptions();
		self::_roles();
		self::_sql();
	}

	public static function _sql() {
		define('SQL_CONCAT_SEPARATOR', '|');
	}

	public static function _layout() {
		define('CSS_LAYOUT_TEXT', ' text');
		define('CSS_LAYOUT_EMPH', ' emph');
		define('CSS_LAYOUT_CLEAR_BOTH', 'clearboth');
		define('CSS_LAYOUT_NONE', 'no-show');
	}
	public static function _form() {
		define('CSS_FORM_ERREUR', 'FormErreur');
		define('CSS_ELEMENT_CLEAR_LEFT', 'clearleft');
		define('CSS_ELEMENT_CLEAR_RIGHT', 'clearright');
		define('CSS_FORM_CHAMP', 'champ');
		define('CSS_FORM_SMALL', 'small');
		define('CSS_FORM_MEDIUM', 'medium');
		define('CSS_FORM_LARGE', 'large');
		define('CSS_LABEL', 'label');
		define('CSS_CHAMP', 'champ');
		define('CSS_ACCUEIL', 'accueil');
		define('CSS_CHAMP_MAIL', 'mail');

		define('CSS_INPUT_ERROR', 'error');
	}

	public static function _actions() {
		define('CSS_BOUTON', 'bouton');
	}

	public static function _images() {
		define('PHOTOS_PATH', IMAGES_PATH.'/photos');
		define('FULL_PHOTOS_PATH', PUBLIC_PATH.'/'.PHOTOS_PATH);
	}

	public static function _contacts() {
		//attention modifier en bdd le cas échéant
		define('ID_PREZ', 1);
		define('ID_VPREZ', 2);
		define('ID_TREZ', 3);
	}

	public static function _actis() {
		define('DUREE_CRENAUX', 10);
		define('HEURE_DEBUT', '12:00');

		define('ACTI_TYPE_FILROUGE', 1);
		define('ACTI_TYPE_CHALLENGE_INDIVIDUEL', 2);
		define('ACTI_TYPE_TOURNOI', 3);
		define('ACTI_TYPE_BAPTEME', 4);
		define('ACTI_TYPE_CHALLENGE_EQUIPE', 5);

		define('ACTI_TYPE_FIL_ROUGE_MAX_CRENEAUX', 10);
		define('ACTI_TYPE_BAPTEME_MAX_PAR_CRENEAUX', 4);
	}

	public static function _inscriptions() {
		define('INSCRIPTIONS_TYPE_PERSO', 1);
		define('INSCRIPTIONS_TYPE_BINET', 2);
	}

	public static function _roles() {
		define('ACL_ROLE_INVITE', 1);
		define('ACL_ROLE_CADRE', 4);
		define('ACL_ROLE_ELEVE', 2);
		define('ACL_ROLE_ADMIN', 10);
		define('ACL_ROLE_WEBMASTER', 11);
	}

}