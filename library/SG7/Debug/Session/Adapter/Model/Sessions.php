<?php
/**
 * reprezentace tabulky debugovacich relaci
 * 
 * @author Patr Jindra
 * @category SG7
 * @package SG7_Debug
 *
 */
class SG7_Debug_Session_Adapter_Model_Sessions extends Zend_Db_Table_Abstract {
	protected $_name = "sessions";
	
	protected $_primary = "id";
	
	protected $_sequence = true;
	
	public function __construct($config = array()) {
		parent::__construct($config);
	}
}