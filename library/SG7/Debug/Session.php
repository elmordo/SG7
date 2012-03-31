<?php
/**
 * trida relace ladeni, ktera uchovava vypisy a zpravy
 * 
 * @author Petr Jindra
 * @category SG7
 * @package SG7_Debug
 *
 */
class SG7_Debug_Session implements Countable, Iterator, ArrayAccess {
	/**
	 * ukazatel na aktualni prvek v poli $_records
	 * 
	 * @var int
	 */
	private $_pointer = 0;
	
	/**
	 * pole zaznamu ladeni.
	 * Kazdy prvek je typu SG7_Debug_Session_Record
	 * 
	 * @var array
	 */
	private $_records = array();
	
	/**
	 * pocet prvku v poli $_records
	 * 
	 * @var int
	 */
	private $_size = 0;
	
	/**
	 * identifikator relace ladeni
	 * 
	 * @var mixed
	 */
	private $_identifier = null;
	
	/**
	 * vytvori relaci, nastavi jmeno a pripadne nastavi data
	 * data jsou pole, jehoz kazdym prvkem je bud dalsi pole, ktere je
	 * vysledkem metody toArray tridy SG7_Debug_Session_Record
	 * nebo instance teto tridy
	 * 
	 * @param string $name jmeno relace
	 * @param array $data data pro pripadne obnoveni z datoveho uloziste
	 */
	public function __construct($name, array $data = null) {
		// nastaveni jmena
		$this->_identifier = $name;
		
		// kontrola dat
		if ($data) {
			// budouo se vytvaret zaznamy
			foreach ($data as $item) {
				// kontrola, jeslti je $item pole
				if (is_array($item)) {
					// item je pole, vytvori se z neho trida zaznamu
					$item = new SG7_Debug_Session_Record($item["content"], $item["name"], $item["comment"], $item["created"]);
				}
				
				// vlozeni zaznamu pres metodu, aby se provedla typova kontrola
				$this->offsetSet(null, $item);
			}
		}
	}
	
	/**
	 * vraci jmeno relace
	 * 
	 * @return string
	 */
	public function getIdentifier() {
		return $this->_identifier;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Countable::count()
	 */
	public function count() {
		return $this->_size;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Iterator::current()
	 */
	public function current() {
		return $this->valid() ? $this->_records[$this->_pointer] : null;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Iterator::key()
	 */
	public function key() {
		return $this->_pointer;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Iterator::next()
	 */
	public function next() {
		$this->_pointer++;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Iterator::rewind()
	 */
	public function rewind() {
		$this->_pointer = 0;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Iterator::valid()
	 */
	public function valid() {
		return $this->_pointer < $this->_size;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see ArrayAccess::offsetExists()
	 */
	public function offsetExists($offset) {
		return isset($this->_records[$offset]);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see ArrayAccess::offsetGet()
	 */
	public function offsetGet($offset) {
		return $this->offsetExists($offset) ? $this->_records[$offset] : null;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see ArrayAccess::offsetSet()
	 * @throws SG7_Debug_Session_Exception
	 */
	public function offsetSet($offset, $value) {
		// kontrola hodnoty, jestli je spravne instance
		if (!($value instanceof SG7_Debug_Session_Record))
			throw new SG7_Debug_Session_Exception("New value must be instance of SG7_Debug_Session_Record");
		
		if (!is_null($offset))
			throw new SG7_Debug_Session_Exception("Offset must be NULL");
		
		$this->_records[] = $value;
		$this->_size++;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see ArrayAccess::offsetUnset()
	 * @throws SG7_Debug_Session_Exception
	 */
	public function offsetUnset($offset) {
		throw new SG7_Debug_Session_Exception("Can't unset debug record");
	}
}