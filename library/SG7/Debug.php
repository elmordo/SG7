<?php
/**
 * staticka trida pro zaznam ladicich logu
 * 
 * @author Petr Jindra
 * @category SG7
 * @package SG7_Debug
 *
 */
class SG7_Debug {
	/**
	 * adapter uloziste
	 * 
	 * @var SG7_Debug_Session_Adapter_Interface
	 */
	protected static $_adapter;
	
	/**
	 * prepinac zapnuti ladeni
	 * 
	 * @var bool
	 */
	protected static $_debugEnabled = false;
	
	/**
	 * relace s daty
	 * 
	 * @var SG7_Debug_Session
	 */
	protected static $_session;
	
	/**
	 * provede zapis dat v @param $variable do relace
	 * 
	 * @param mixed $variable obsah k vypsani
	 * @param string $name jmeno zaznamu
	 * @param string $comment komentar
	 * @throws SG7_Debug_Exception
	 */
	public static function dump($variable, $name=null, $comment = null) {
		// kontrola inicializace
		if (!self::$_session)
			throw new SG7_Debug_Exception("Debug module of SG7 library has not been initialized");
		
		// ziskani obsahu
		ob_start();
		var_dump($variable);
		$content = ob_get_clean();
		
		// vytvoreni zaznamu
		$record = new SG7_Debug_Session_Record($content, $name, $comment);
		
		// zapis do session
		self::$_session[] = $record;
	}
	
	/**
	 * zinicializuje modul
	 * parametry mohou byt
	 * - adapter (string) typ pouziteho adapteru
	 * - adapterParams (array) pole obsahujici informace k inicializaci adapteru 
	 * - sessionName (string) vyzadane jmeno relace
	 * 
	 * @param array $params parametry inicializace
	 * @throws SG7_Debug_Exception
	 */
	public static function setup(array $params) {
		$params = array_merge(array("adapter" => null, "adapterParams" => array(), "sessionName" => null), $params);
		
		if (!$params["adapter"])
			throw new SG7_Debug_Exception("Adapter must be set");
		
		$adapter = "SG7_Debug_Session_Adapter_" . $params["adapter"];
		
		self::$_adapter = new $adapter($params["adapterParams"]);
		self::$_session = self::$_adapter->create($params["sessionName"]);
	}
	
	/**
	 * ulozi data relace do uloziste a resetuje objekt
	 * pred dalsim pouzitim je treba objekt znovu zinicializovat
	 */
	public static function teardown() {
		self::$_adapter->save(self::$_session);
		
		self::$_session = null;
		self::$_adapter = null;
	}
	
	/**
	 * vraci seznam predchotich relaci poskytovanych adapterem
	 */
	public static function sessionList() {
		return self::$_adapter->getList();
	}
	
	/**
	 * pokusi se nacist relaci
	 * vraci TRUE, pokud relace byla nalezena
	 * jinak vraci FALSE
	 * 
	 * @param mixed $identifier identifikator relace
	 * @return boolean
	 */
	public static function loadSession($identifier) {
		$session = self::$_adapter->load($identifier);
		self::$_session = $session;
		
		return $session ? true : false;
	}
	
	/**
	 * vraci aktualni relaci
	 * 
	 * @return SG7_Debug_Session
	 */
	public static function getSession() {
		return self::$_session;
	}
}