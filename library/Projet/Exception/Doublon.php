<?php

/**
 * Gestion des messages d'erreur de l'application.
 *
 * @category   Projet
 * @package    library_Projet
 * @subpackage
 */
class Projet_Exception_Doublon extends Zend_Db_Exception {

	const ORA_DOUBLON	= 'ORA-00001';
	const MYSQL_DOUBLON = 23000;
}
