<?PHP

class Announcement
{
  
  private $_Core;
  private $_id;
	private $_Data;
  
  function __construct( $id )
  {
    $this->_Core = CMS_Core::getInstance();
    $this->_id = $id;
    
    $this->_queryData();
    
  }
  
  private function _queryData()
  {
    
    $db = Database::getInstance();
		$SQL = $db->getConnection();
    
    $qstr = "SELECT id, subject, content, date_created, created_by FROM `announcements` WHERE `id` = '{$this->_id}'";
    $query = $SQL->query($qstr);
    
    if($query->num_rows > 0)
    {
      
      $this->_Data = $query->fetch_assoc();
      
    }
    
  }
  
  public function getData()
	{
		$Template = Template::getInstance();
    $this->_Data['subject'] = htmlspecialchars_decode($this->_Data['subject']);
    $this->_Data['content'] = htmlspecialchars_decode($this->_Data['content']);
		$this->_Data['date_created'] = date($this->_Core->Settings['defaultTimestamp'], $this->_Data['date_created']);
		
		return $this->_Data;
	}
	
	public static function getLatest($limit)
	{
		$db = Database::getInstance();
		$SQL = $db->getConnection();
		
		$arr = array();
		
		$q_str = "SELECT id FROM `announcements` ORDER BY date_created DESC LIMIT {$limit}";
		$query = $SQL->query($q_str);
		if($query->num_rows > 0)
		{
			while($results = $query->fetch_assoc())
			{
				$arr[] = $results['id'];
			}
		}
		return $arr;
	}
  
  
}

?>