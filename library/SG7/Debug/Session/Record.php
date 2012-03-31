<?php
/**
 * zaznam o jednom ladicim vystupu
 *
 * @author Petr Jindra
 * @category SG7
 * @package SG7_Debug
 *
 */
class SG7_Debug_Session_Record {
	
	/**
	 * komentar k zaznamu
	 * 
	 * @var string
	 */
	private $_comment;
	
	/**
	 * ladici vystup
	 * 
	 * @var string
	 */
	private $_content;
	
	/**
	 * cas s presnosti na ms, kdy byl zaznam vlozen
	 * 
	 * @var double
	 */
	private $_created;
	
	/**
	 * jmeno zaznamu
	 * 
	 * @var string
	 */
	private $_name;
	
	/**
	 * vytvori zaznam a nastavi jeho parametry
	 * pokud neni zadan parametr $created, je vygenerovan automaticky
	 * 
	 * @param string $content ladici vystup
	 * @param string $name jmeno zaznamu
	 * @param string $comment komentar k zaznamu
	 * @param double $created cas vytvoreni zaznamu s presnosti na ms
	 */
	public function __construct($content, $name = null, $comment = null, $created = null) {
		// nastaveni hodnot
		$this->_comment = $comment;
		$this->_content = $content;
		$this->_name = $name;
		
		if ($created) {
			$this->_created = $created;
		} else {
			$this->_created = microtime(true);
		}
	}
	
	/**
	 * vraci komentar
	 * 
	 * @return string
	 */
	public function comment() {
		return $this->_comment;
	}
	
	/**
	 * vraci ladici vystup
	 * 
	 * @return string
	 */
	public function content() {
		return $this->_content;
	}
	
	/**
	 * vraci cas vytvoreni zaznamu s presnosti na ms
	 * 
	 * @return double
	 */
	public function created() {
		return $this->_created;
	}
	
	/**
	 * vraci jmeno zaznamu
	 * 
	 * @return string
	 */
	public function name() {
		return $this->_name;
	}
	
	/**
	 * vraci pole obsahujici vsechny informace
	 * jednotlive prvky jsou
	 * - comment -> komentar k zaznmau
	 * - content -> ladici vystup
	 * - created -> cas vytvoreni zaznamu s presnosti na ms
	 * - name -> jmeno zaznamu
	 * 
	 * @return array
	 */
	public function toArray() {
		return array(
				"comment" => $this->_comment,
				"content" => $this->_content,
				"created" => $this->_created,
				"name" => $this->_name
		);
	}
}