<?PHP

class Guest extends User
{

	public $restricted = true;
	
	public function __construct()
	{

		$this->DEBUG[] = "Instantiating Guest...";

		$this->_Data = $this->_getData( DEFAULT_GUEST_ID );
			
		$this->setData();
		
		$this->DEBUG[] = "Guest Instantiated!";

		CMS_Core::getInstance()->DEBUG[] = $this->DEBUG;

		return true;
		
	}
	
	
	public function setData()
	{
	
		$this->id = $this->_Data['id'];
		$this->fullName = $this->_Data['firstName'] . " " . $this->_Data['lastName'];
		$this->lastFirst = $this->_Data['lastName'] . ", " . $this->_Data['firstName'];
		
	}

}
	
	