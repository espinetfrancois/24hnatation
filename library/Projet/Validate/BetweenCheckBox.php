<?php

/**
 * FIXME : get an array
 * TODO : fixit
 * @author francois.espinet
 *
 */
class Projet_Validate_BetweenCheckBox extends Zend_Validate_Abstract {

	/**
     * Sets the value to be validated and clears the messages and errors arrays
     *
     * @param  mixed $value
     * @return void
     */
    protected function _setValue($value)
    {
        $this->_value    = count($value);
        $this->_messages = array();
        $this->_errors   = array();
    }
}
