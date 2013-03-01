<?php

class Projet_Form_Element_File extends Zend_Form_Element_File {

	protected $_ajax = null;
	protected $_deco = null;
	//redefinition de la classe de Zend
	public function __construct($spec, $aOptions = array()) {
		if(isset($aOptions['ajax'])) {
			$this->_ajax = $aOptions['ajax'];
			unset($aOptions['ajax']);
		}
		if(isset($aOptions['deco'])) {
			$this->_deco = $aOptions['deco'];
			unset($aOptions['deco']);
		}
		parent::__construct($spec, $aOptions);
	}

	public function loadDefaultDecorators() {
        if ($this->loadDefaultDecoratorsIsDisabled()) {
            return $this;
        }

        $decorators = $this->getDecorators();
        if (empty($decorators)) {
        	$this//->addDecorator('ErreurPrimer')
           		->addDecorator('File');
            	//->addDecorator('Erreurs');
            if ($this->_ajax !== null) {
            	$this->addDecorator('Ajax', array('tag' => $this->_ajax));
            }
            if ($this->_deco !== null) {
            	$this->addDecorator($this->_deco);
            }
            $this->addDecorator('Label')
            	 ->addDecorator('Paragraphe')
            	 ->addDecorator('Errors');
        }
        return $this;
    }

}
