<?php

/**
 * Effectue les requete 'LDAP'
 * Etend la classe Zend_Ldap
 *
 * @name		Ldap
 * @category	Projet
 * @package		application
 * @subpackage	Service_Ldap
 * @author		$LastChangedBy: jean-christophe.fraillon $
 * @version		$LastChangedRevision: 704 $
 */
class Projet_Ldap extends Zend_Ldap {

	/**
	 * Attribut objectclass, filtre supplémentaire par defaut
	 * @var string
	 */
	protected $sObjectClass = "";

	/**
	 * Instance de Service_Ldap_Select()
	 * @var object
	 */
	protected $_select = null;

	/**
	 * liste des attributs recherchés
	 * @var array
	 */
	public $aAttributs = array('*');

	protected $bIntegrity = true;

	/**
	 * filtres
	 * @var string
	 */
	protected $sWhere = "";

	/**
	 * filtre lié à l'object class
	 * @var string
	 */
	protected $sFrom = "";

	/**
	 * Limit de resultats
	 * @var integer
	 */
	protected $nScope = 200;

	/**
	 * dn de connexion
	 * @var string
	 */
	protected $sDn;

	/**
	 * port de connexion
	 * @var integer
	 */
	protected $sPort;

	/**
	 * host|ip de connexion
	 * @var string
	 */
	protected $sHost;

	/**
	 * Instance de Zend_Db_Profileur
	 * @var object
	 */
	private $_profiler;

	/**
	 * Instance de Zend_Session_Namespace
	 * @var object
	 */
	private $_session;

	/**
	 * Instance du CacheManager par default
	 * @var $_cache object
	 */
	protected $_cache;

	private $sCacheId = "none";

	/**
	 * Constructeur de la classe
	 */
	public function __construct($sObjectClass = '*', array $aParams = array()) {
		$aParam = Zend_Registry::get('ldap');
		$this->sDn = ($aParams['baseDn'] ? $aParams['baseDn'] : $aParam['baseDn'] );
		$this->sPort = $aParam['port'];
		$this->sHost = $aParam['host'];
		parent::__construct($aParam);
		$this->sObjectClass = $sObjectClass;
		$db = Zend_Db_Table_Abstract::getDefaultAdapter();
		$this->_profiler = $db->getProfiler();
		$this->_cache = Zend_Db_Table_Abstract::getDefaultMetadataCache();
		$this->_session = new Zend_Session_Namespace(Zend_Registry::get("ldap_query"));
		if (! isset($this->_session->query)) {
			$this->_session->query = array("ldap" => array(), "db" => array());
		}

	}

	public function select($aAttributs) {
		if ($aAttributs) {
			$this->aAttributs = $aAttributs;
		}

		$this->from($this->sObjectClass);

		return $this;
	}

	/**
	 * Permet de definir la classe de recherche (filtre supplémentaire)
	 * @param string $sObjectClass attribut objectclass, person|organizationalUnit
	 * @return void
	 */
	public function from($sObjectClass) {
		$this->sFrom .= "(objectclass=" . $sObjectClass . ")";

		return $this;
	}

	/**
	 * permet de supprimer le filtre objectclass par defaut si definit à false
	 * @param boolean $bIntegrity
	 * @return object self
	 */
	public function setIntegrityCheck($bIntegrity = true) {
		$this->sFrom = "";

		return $this;
	}

	/**
	 * Ajoute un filtre de recherche à la requete
	 * @param string $sCondition exemple ->where("uid = ?", "sam")
	 * @param object self
	 */
	public function where($sCondition, $sValue) {
		$sCondition = preg_replace("/ /", "", $sCondition);
		$sWhere = "(" . preg_replace("/\?/", $sValue, $sCondition) . ")";
		$this->sWhere .= $sWhere;
		return $this;
	}

	/**
	 * Renvoi la chaine concernant les filtres
	 */
	public function __toString() {
		$sSelect = "(&";
		$sSelect .= $this->sFrom;
		$sSelect .= $this->sWhere;
		$sSelect .= ")";
		return $sSelect;
	}

	/**
	 * Effectue la requete, si le select est donné, il convertit en string, sinon, prend celui créé
	 * @param string|object $sSelect filtre de recherche
	 * @param boolean $bDebug permet d'imprimer la requete en mode debug si true
	 * @return array $aResult resultat de la requete
	 */
	public function fetchAll($bDebug = false) {

		$sFilters = $this->__toString();
		$aAttributs = $this->aAttributs;

		if ($bDebug) {
			echo $sFilters;
			$this->printRequete();
		}

		$sReq = "LDAP :--SELECT " . implode(", ", $aAttributs) . " WHERE " . $sFilters;

		/**
		 * On charge un éventuel resulat en cache
		 */
		$aResult = $this->loadQuery($sReq);
		if ($aResult === false) {
#			$s = $this->_profiler->queryStart($sReq, Projet_Db_Profiler_Ldap::LDAP);
			$aResultTmp = $this->search($sFilters, $this->sDn, $this->nScope, $aAttributs)->toArray();
			$aResult = array();
			foreach ($aResultTmp as $i => $aValue) {
				foreach ($aValue as $key => $aVal) {
					if ($key == "objectclass") {
						$aResult[$i][$key] = $aVal[1];
					} elseif ($key == "dn") {
						$aResult[$i][$key] = $aVal;
					} else {
						$aResult[$i][$key] = $aVal[0];
					}
				}
			}
#			$this->_profiler->queryEnd($s);
#			$this->saveQuery($sReq, $aResult);
		}
		return $aResult;
	}

	/**
	 * Affiche la requete à lancer
	 *
	 */
	public function printRequete() {
		print "requête ldap:<br />";
		print $this->_select . "<br />";
		print "attributs: <br />";
		print implode(", ", $this->aAttributs) . "<br />";
	}

	/**
	 * Fixe une nouvelle limite aux quantité de données retournées
	 * @param unknown_type $nLimit
	 */
	protected function limit($nLimit) {
		$this->nScope = $nLimit;
	}

	/**
	 * Vérifie si la requete a déjà été joué.
	 * un id est stocké en session
	 * @param string $sReq requete serialisée
	 * @return mixed resultat de requete ou false si pas en cache
	 */
	private function loadQuery($sReq) {
		if (in_array($sReq, $this->_session->query["ldap"])) {
			$sIdCache = array_search($sReq, $this->_session->query["ldap"]);
			if ($sIdCache === false) {
				return false;
			} else {
				return $this->_cache->load($sIdCache);
			}
		} else {
			return false;
		}
	}

	/**
	 * Met dans le cache le resultat de la requete
	 * @param string $sReq string
	 * @param array $aResult resultat de requete
	 * @return void
	 */
	private function saveQuery($sReq, $aResult) {
		/* on crée un id unique*/
		/*on recupère le dernier id, contenu dans un fichier de cache unique*/
		$sId = $this->_cache->load("keycacheldap");
		if ($sId === false) {
			$sId = 1;
		} else {
			$sId ++;
		}
		$this->_cache->save($sId, "keycacheldap");

		$sId = "LDAPquery" . $sId;
		$this->_session->query["ldap"][$sId] = $sReq;
		$this->_cache->save($aResult, $sId);
	}

}
