<?PHP

class User_Profile
{
  
  private $_id;
	private $_Data;
	private $_Types = array(	"hidden" ,
								"text",
								"text",
								"text",
								"text",
								"text",
								"user_group"
							);
  
  function __construct( $id )
  {
    $this->_id = $id;
    
    $this->_queryUserData();
    
  }
  
  private function _queryUserData()
  {
    
    $db = Database::getInstance();
		$SQL = $db->getConnection();
    
    $qstr = "SELECT id, lastName, firstName, NULL AS password, email, phone, type FROM `players` WHERE `id` = '{$this->_id}'";
    $query = $SQL->query($qstr);
    
    if($query->num_rows > 0)
    {
      
      $this->_Data = $query->fetch_assoc();
      
    }
    
  }
	
	public function getDataArray()
	{
		
		return $this->_data;
		
	}
	
	public function getFormData()
	{
		$Template = Template::getInstance();
		
		return $Template->convertToForm($this->_Data, $this->_Types);
	}
	
	public static function delete( $id )
	{
		$db = Database::getInstance();
		$SQL = $db->getConnection();
		$querystr = "DELETE FROM `players` WHERE `id` = {$id}";
		if($SQL->query($querystr))
			return 1;
		else
			return 0;
	}
  
}

?>