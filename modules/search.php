<?PHP

class Database {
	private $_connection;
	// Store the single instance.
	private static $_instance;
	
	public static function getInstance() {
		if(!self::$_instance) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	
	public function __construct() {
	
		$sqlHost = 'localhost';
		$sqlUser = 'root';
		$sqlPass = 'root';
		$sqlDB = 'cms';
	
		$this->_connection = new mysqli($sqlHost, $sqlUser, $sqlPass, $sqlDB);
	}
	
	private function __clone() {}
	
	public function getConnection() {
	
		return $this->_connection;
	}
}

?>