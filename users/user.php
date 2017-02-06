<?PHP

class User
{
	
	public $DEBUG;
	
	public $id;
	public $fullName;
	public $lastFirst;
	public $Settings;
	
	protected $_Data;
	
	protected $_Statistic;
	
	protected function _getData( $id )
	{
	
		$db = Database::getInstance();
		$SQL = $db->getConnection();
		
		$this->DEBUG[] = "Retrieving Data...";
		
		$query = $SQL->query("SELECT *
															FROM `players`
															WHERE `id` = '" . $id . "'
														");
		
		if($query->num_rows == 0)
		{
			throw new Player_Exception( "", Player_Exception::NO_ASSOCIATED_ID );
			return false;
		}
		
		$Data = $query->fetch_assoc();
		
				
		$query = $SQL->query("SELECT `template_id`
															FROM `player_settings`
															WHERE `player_id` = '{$id}'");
		$this->Settings = $query->fetch_assoc();
		
		
		$this->DEBUG[] = "Data Retrieved!";
		
		return $Data;
		
	}
	
	protected function _combineDebug()
	{
		$this->DEBUG[] = "User Instantiated!";
		Core::getInstance()->DEBUG[] = $this->DEBUG;
	}
	
	public static function isUserType( $id )
	{
		
		$db = Database::getInstance();
		$SQL = $db->getConnection();
		
		$query = $SQL->query("SELECT `type`
															FROM `players`
															WHERE `id` = '" . $id . "'
														");
		
		if($query->num_rows > 0)
		{
			$results = $query->fetch_assoc();
			return  $results['type'];
		}
		else
			return 0;
		
	}
	
	public function getID()
	{
		return $this->id;
	}
	
	public function getFullName()
	{
		return $this->fullName;
	}
	
	public function getLastFirst()
	{
		return $this->lastFirst;
	}
	
	public function retrieveStatistics()
	{
		return null;
	}
		
}
	
?>