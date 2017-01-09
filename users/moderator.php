<?PHP

class Moderator extends User
{
	
	public $PlayerStatistics;
	
	public function __construct( $id = 0 )
	{

		if( $id == DEFAULT_GUEST_ID ) throw new Player_Exception( "", Player_Exception::NO_GUESTS );
	
		$this->DEBUG[] = "Instantiating Moderator ID \"" . $id . "\"...";

		if(!is_numeric($id)) throw new Player_Exception( "", Player_Exception::ID_NOT_NUMERIC );
		
		try
		{
			$this->_Data = $this->_getData( $id );
		}
		catch(Player_Exception $e)
		{
			$this->DEBUG[] = $e->errorMessage();
			return false;
		}
		
		$this->setData();
		
		$this->DEBUG[] = "Moderator \"" . $this->fullName . "\" Instantiated!";

		CMS_Core::getInstance()->DEBUG[] = $this->DEBUG;
		
		return true;
		
	}
	
	public function setData()
	{
	
		$this->id = $this->_Data['id'];
		$this->fullName = $this->_Data['firstName'] . " " . $this->_Data['lastName'];
		$this->lastFirst = $this->_Data['lastName'] . ", " . $this->_Data['firstName'];
		
	}
	
	public function retrieveStatistics()
	{
		$this->PlayerStatistics = new PlayerStatistics($this->id);
	}

}
	
?>