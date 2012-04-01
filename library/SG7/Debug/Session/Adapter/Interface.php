<?php
/**
 * Rozhrani pro tridy, ktere slouzi ke komunikaci s datovym ulozistem,
 * kam se ukladani data ladicich vystupu
 * 
 * @author Petr Jindra
 * @category SG7
 * @package SG7_Debug
 *
 */
interface SG7_Debug_Session_Adapter_Interface {
	
	/**
	 * spolecny kontruktor
	 * 
	 * @param array $params parametry vytvoreni
	 */
	public function __construct(array $params = null);
	
	/**
	 * vytvori novou relaci
	 * 
	 * @param mixed $identifier identifikator relace, ktera bude vytvorena
	 * @return SG7_Debug_Session
	 */
	public function create($identifier = null);
	
	/**
	 * vrace seznam drive vytvorenych relaci, ktere byly ulozeny
	 * 
	 * @return array
	 */
	public function getList();
	
	/**
	 * nacte relaci podle identifikatoru a vraci ji
	 * pokud relace nebyla nalezena, vraci hodnotu NULL
	 * 
	 * @param mixed $identifier identifikator relace
	 * @return SG7_Debug_Session|NULL
	 */
	public function load($identifier);
	
	/**
	 * ulozi relaci do uloziste
	 * vraci TRIE pokud ulozeni uspesne
	 * jinak vraci FALSE
	 * 
	 * @param SG7_Debug_Session $session relace k ulozeni
	 * @return bool
	 */
	public function save(SG7_Debug_Session $session);
}