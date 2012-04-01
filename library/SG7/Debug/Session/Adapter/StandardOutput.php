<?php
/**
 * vypisuje relaci na standardni vystup (zpravidla prohlizec)
 * parametry standardne vypisuje do tabulky pomoci echo
 * je mozne pouzit view script
 * 
 * @author Petr Jindra
 * @category SG7
 * @package SG7_Debug
 *
 */
class SG7_Debug_Session_Adapter_StandardOutput implements SG7_Debug_Session_Adapter_Interface {
	
	/*
	 * konstanty jazyku
	 */
	const LANG_CS = "cs";		// cestina
	
	/**
	 * obsahuje jmeno view skriptu pro vystup
	 * @property string
	 */
	protected $_view = "output";
	
	/**
	 * jazyk vystupu
	 * 
	 * @property string
	 */
	protected $_lang = "cs";
	
	/**
	 * cesta k zobrazovacim skriptum
	 * 
	 * @property string
	 */
	protected $_basePath = null;
	
	/**
	 * nastavi parametry vystupu
	 * prijima nasledujici parametry:
	 * - viewScript (string) - pokud je nastaven, pouzije se jiny viewscript
	 * - basePath (string) - nova cesta k view skriptum
	 * - lang (string) - jazyk vystupu
	 * 
	 * @param array $params
	 */
	public function __construct(array $params = null) {
		foreach ($params as $key => $val) {
			switch ($key) {
				case "lang":
					$this->_lang = $val;
					break;
					
				case "basePath":
					$this->_basePath = $val;
					break;
					
				case "viewScript":
					$this->_view = $val;
					break;
			}
		}
		
		// kontrola basePath
		if (!$this->_basePath) {
			$this->_basePath = __DIR__ . "/Views";
		}
	}
	
	/**
	 * (non-PHPdoc)
	 * @see SG7_Debug_Session_Adapter_Interface::create()
	 */
	public function create($identifier = null) {
		return new SG7_Debug_Session(null);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see SG7_Debug_Session_Adapter_Interface::getList()
	 */
	public function getList() {
		return array();
	}
	
	/**
	 * (non-PHPdoc)
	 * @see SG7_Debug_Session_Adapter_Interface::load()
	 */
	public function load($identifier) {
		return null;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see SG7_Debug_Session_Adapter_Interface::save()
	 */
	public function save(SG7_Debug_Session $session) {
		// vytvoreni a nastaveni view skriptu
		$view = new Zend_View();
		
		$view->setBasePath($this->_basePath);
		
		$view->session = $session;
		$view->lang = $this->_lang;
		
		echo $view->render($this->_view);
	}
}