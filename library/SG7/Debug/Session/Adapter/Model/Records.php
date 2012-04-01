<?php
/**
 * reprezentace tabulky zaznamu ladicich relaci
 * 
 * @author Petr Jindra
 * @category SG7
 * @package SG7_Debug
 *
 */
class SG7_Debug_Session_Adapter_Model_Records extends Zend_Db_Table_Abstract {
	protected $_name = "records";
	
	protected $_primary = "id";
	
	protected $_sequence = true;
	
	protected $_referenceMap = array(
			"session" => array(
					"columns" => "session_id",
					"refTableClass" => "SG7_Debug_Session_Adapter_Sessions",
					"refColumns" => "id"
			)
	);
	
	public function __construct($config = array()) {
		parent::__construct($config);
	}
}