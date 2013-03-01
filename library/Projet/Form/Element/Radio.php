<?php

class Projet_Form_Element_Radio extends Zend_Form_Element_Radio {

	protected $_ajax			= null;
	protected $_bInline			= false;
	protected $_msgEmpty		= null;

	protected $_champs 	= null;
	//redefinition de la classe de Zend
	public function __construct($spec, $aOptions = array()) {
		if(isset($aOptions['ajax'])) {
			$this->_ajax = $aOptions['ajax'];
			unset($aOptions['ajax']);
		}
		if (isset($aOptions['champs'])) {
			$this->_champs = $aOptions['champs'];
			unset($aOptions['champs']);
		}
		parent::__construct($spec, $aOptions);
	}

	public function loadDefaultDecorators() {
        if ($this->loadDefaultDecoratorsIsDisabled()) {
        	die("coucou");
            return $this;
        }

        $decorators = $this->getDecorators();
        if (empty($decorators)) {
            $this->addDecorator('ViewHelper');
//             $this->addDecorator('Label');
            if ($this->_ajax !== null) {
            	$this->addDecorator('Ajax', array('tag' => $this->_ajax));
            }
            $this->addDecorator('Label')
           		 ->addDecorator('HtmlTag', array('tag' => 'span', 'class' => CSS_LABEL))
            	 ->addDecorator('HtmlTag', array('tag' => 'div', 'id' => 'champ-'.$this->getName(), 'class' => 'champ-radio '.CSS_CHAMP))
            	 ->addDecorator('Errors');
        }
        return $this;
    }

    public function render(Zend_View_Interface $view = null) {
    	if(!count($this->getMultiOptions())) {
    		return $view->translate($this->getMsgEmpty());
    	}
    	return parent::render($view);
    }

	/**
	 * @brief		Getter de $this->_bInline
	 * @return	the $_bInline
	 */
	public function getInline() {
		return $this->_bInline;
	}

	/**
	 * @brief		Setter de $this->_bInline
	 * @param	$_bInline the $_bInline to set
	 */
	public function setInline($_bInline = true) {
		$this->_bInline = $_bInline;
		return $this;
	}



	public function getMsgEmpty()
	{
	    return $this->_msgEmpty;
	}

	public function setMsgEmpty($_msgEmpty)
	{
	    $this->_msgEmpty = $_msgEmpty;
	    return $this;
	}
}
