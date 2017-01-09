<?PHP

class Venue
{
  
  private $_Core;
  private $_id;
	private $_Data;
	private $_Types = array(	"hidden" ,
								"text",
								"time[]",
								"day[]",
								"text",
								"text",
								"state",
								"text",
								"text",
								"venue_features",
								"textarea"
							);
  
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
    
    $qstr = "SELECT id, name, startTime, day, address, city, state, zipCode, phone, features, description FROM `venues` WHERE `id` = '{$this->_id}'";
    $query = $SQL->query($qstr);
    
    if($query->num_rows > 0)
    {
      
      $this->_Data = $query->fetch_assoc();
      
    }
    
  }
  
  public function getFormData()
	{
		$Template = Template::getInstance();
    $this->_Data['name'] = htmlspecialchars_decode($this->_Data['name']);
    $this->_Data['startTime'] = htmlspecialchars_decode($this->_Data['startTime']);
    $this->_Data['day'] = htmlspecialchars_decode($this->_Data['day']);
    $this->_Data['address'] = htmlspecialchars_decode($this->_Data['address']);
    $this->_Data['city'] = htmlspecialchars_decode($this->_Data['city']);
    $this->_Data['state'] = htmlspecialchars_decode($this->_Data['state']);
    $this->_Data['zipCode'] = htmlspecialchars_decode($this->_Data['zipCode']);
    $this->_Data['phone'] = htmlspecialchars_decode($this->_Data['phone']);
    $this->_Data['features'] = htmlspecialchars_decode($this->_Data['features']);
    $this->_Data['description'] = htmlspecialchars_decode($this->_Data['description']);
		
		return $Template->convertToForm($this->_Data, $this->_Types);
	}
	
	public static function getStaticForm()
	{
		$Template = Template::getInstance();
		$data = array('name' => '',
								 'startTime' => '',
								 'day' => '',
								 'address' => '',
								 'city' => '',
								 'state' => '',
								 'zipCode' => '',
								 'phone' => '',
								 'features' => '',
								 'description' => ''
								 );
		$types = array("text",
								"time[]",
								"day[]",
								"text",
								"text",
								"state",
								"text",
								"text",
								"venue_features",
								"textarea"
							);
		
		return $Template->convertToForm($data, $types);
	}
  
  public static function add($name, $day, $startTime, $address, $city, $state, $zipCode, $phone, $features, $description)
  {
   	$db = Database::getInstance();
		$SQL = $db->getConnection();
    
    if(empty(trim($name)) ||
			 empty(trim($startTime)) ||
			 empty(trim($day)) ||
			 empty(trim($address)) ||
			 empty(trim($city)) ||
			 empty(trim($state)) ||
			 empty(trim($zipCode)))
		{
			return 0;
		}
    
    $user = CMS_Core::getInstance()->User->fullName;
    $time = time();
    
    $q_str = "INSERT INTO `venues` (date_created, created_by, name, startTime, day, address, city, state, zipCode, phone, features, description) 
														VALUES ('{$time}',
																		'{$user}',
																		'{$SQL->real_escape_string($name)}',
																		'{$SQL->real_escape_string($startTime)}',
																		'{$SQL->real_escape_string($day)}',
																		'{$SQL->real_escape_string($address)}',
																		'{$SQL->real_escape_string($city)}',
																		'{$SQL->real_escape_string($state)}',
																		'{$SQL->real_escape_string($zipCode)}',
																		'{$SQL->real_escape_string($phone)}',
																		'{$SQL->real_escape_string($features)}',
																		'{$SQL->real_escape_string($description)}'
																		)";
		
    $SQL->query($q_str) or die($SQL->error);
    return 1;
    
  }
  
  public function modify($name, $day, $startTime, $address, $city, $state, $zipCode, $phone, $features, $description)
  {
    $db = Database::getInstance();
		$SQL = $db->getConnection();
    
    if(empty(trim($name)) || empty(trim($day)) || empty(trim($startTime)) || empty(trim($address)) || empty(trim($city)) || empty(trim($state)) || empty(trim($zipCode)))
    {
			return 0;
    }
    
    $user = CMS_Core::getInstance()->User->fullName;
    $edit_time = time();
    $name = addslashes(htmlspecialchars($name));
    $address = addslashes(htmlspecialchars($address));
    $city = addslashes(htmlspecialchars($city));
    $zipCode = addslashes(htmlspecialchars($zipCode));
    $phone = addslashes(htmlspecialchars($phone));
    $description = addslashes(htmlspecialchars($description));
    
    $q_str = "UPDATE `venues` SET `name` = '{$name}', 
																	`day` = '{$day}', 
																	`startTime` = '{$startTime}',
																	`address` = '{$address}',
																	`city` = '{$city}',
																	`state` = '{$state}',
																	`zipCode` = '{$zipCode}',
																	`phone` = '{$phone}',
																	`features` = '{$features}',
																	`description` = '{$description}',
																	`date_last_edited` = '{$edit_time}', 
																	`edited_by` = '{$user}'
																	WHERE `id` = '{$this->_id}'";
    $SQL->query($q_str) or die($SQL->error);
    return 1;
  }
  
  public function deactivate()
  {
    $db = Database::getInstance();
		$SQL = $db->getConnection();
		$user = CMS_Core::getInstance()->User->fullName;
    $edit_time = time();
		$querystr = "UPDATE `venues` SET `active` = '0', `date_last_edited` = '{$edit_time}', `edited_by` = '{$user}' WHERE `id` = {$this->_id}";
		if($SQL->query($querystr))
			return 1;
		else
			return 0;
  }
	
	public static function getVenueNameByID( $id )
	{
		$db = Database::getInstance();
		$SQL = $db->getConnection();
		
		$query = $SQL->query("SELECT `name` FROM `venues` WHERE `id` = '" . $SQL->real_escape_string( $id ) . "'");
		if($query)
		{
			$row = $query->fetch_assoc();
			return $row['name'];
		}
		else
		{
			return "Venue Does Not Exist!";
		}
	}
	
	public static function getVenueOptions( $selection="" )
	{
		$html = "";
		$db = Database::getInstance();
		$SQL = $db->getConnection();
		
		$q_str = "SELECT * FROM `venues` ORDER BY `name` ASC";
		$query = $SQL->query($q_str);
		
		while($result = $query->fetch_assoc())
		{
			if($result['id'] == $selection)
				$html .= Template::getInstance()->Skin['search']->selectOption( $result['name'], $result['id'], "selected" );
			else
				$html .= Template::getInstance()->Skin['search']->selectOption( $result['name'], $result['id'] );
		}
		return $html;
	}
	
	public static function getSeperatedVenueOptions( $selection="" )
	{
		$html = "";
		$db = Database::getInstance();
		$SQL = $db->getConnection();
		
		$q_str = "SELECT * FROM `venues` ORDER BY `name` ASC";
		$query = $SQL->query($q_str);
		
		while($result = $query->fetch_assoc())
		{
			if(is_numeric($result['day']) || empty($result['day']))
				$html .= Template::getInstance()->Skin['search']->selectOption( $result['name'], $result['id'] );
			else
			{
				$days = explode("|", $result['day']);
				foreach($days as $val)
				{
					$html .= Template::getInstance()->Skin['search']->selectOption( $result['name'] . "(" . CMS_Core::getInstance()->Day[$val] . ")", $result['id'] . "|" . $val);
				}
			}
		}
		return $html;
	}
	
	public static function getSeperatedVenues()
	{
		$arr = array();
		$db = Database::getInstance();
		$SQL = $db->getConnection();
		
		$q_str = "SELECT * FROM `venues` ORDER BY `name` ASC";
		$query = $SQL->query($q_str);
		
		while($result = $query->fetch_assoc())
		{
			if(is_numeric($result['day']) || empty($result['day']))
				$arr[$result['id']] = $result['name'];
			else
			{
				$days = explode("|", $result['day']);
				foreach($days as $val)
				{
					$arr[$result['id'] . "|" . $val] = $result['name'] . "(" . CMS_Core::getInstance()->Day[$val] . ")";
				}
			}
		}
		return $arr;
	}

	public static function getAllFeatures()
	{
		$arr = array();
		$db = Database::getInstance();
		$SQL = $db->getConnection();
		
		$q_str = "SELECT * FROM `venue_features` ORDER BY `name` ASC";
		$query = $SQL->query($q_str);
		
		while($result = $query->fetch_assoc())
		{
			$arr[$result['id']] = $result['name'];
		}
		return $arr;
	}
	
	public static function findVenueIDByName($contains)
	{
		$db = Database::getInstance();
		$SQL = $db->getConnection();
		
		$q_str = "SELECT `id` FROM `venues` WHERE `name` LIKE '%{$contains}%'";
		$query = $SQL->query($q_str);
		
		$results = array();
		
		while($result = $query->fetch_assoc())
		{
			$results[] = $result['id'];
		}
		return $results;
	}

}

?>