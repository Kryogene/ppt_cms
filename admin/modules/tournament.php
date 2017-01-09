<?PHP

class Tournament
{
	
	private $_Data = array();
	public $DEBUG;
	private $_Types = array("hidden",
								"venues",
								"year",
								"month",
								"num_day",
								"time",
								"textarea"
							);
	
	protected $id, $year, $month, $day, $time, $short_info, $long_info;

	public function __construct( $tid )
	{
		$Core = CMS_Core::getInstance();
		$this->DEBUG[] = "Fetching Tournament ID '{$tid}'...";

		$this->_getTournamentData( $tid );

		if($this->_Data == 0)
		{
			$this->id = -1;
			return false;
		}
		$this->_setObject();	

		$Core->DEBUG[] = $this->DEBUG;
	}
	
	protected function _setObject()
	{
		$this->id = $this->_Data['id'];
		$this->year = $this->_Data['year'];
		$this->month = $this->_Data['month'];
		$this->day = $this->_Data['day'];
		$this->time = $this->_Data['time'];
		$this->long_info = $this->_Data['information'];
		$this->short_info = substr($this->long_info,0,100);
	}
	
	protected function _setTimeAndDays()
	{
		$days = explode("|", $this->_Data['day']);
		$times = explode("|", $this->_Data['startTime']);
		if( isset($days[1]) )
			foreach( $days as $k => $d )
			{
				$this->days[$d] = 1;
				$this->times[$d] = $times[$k];
			}
		else
		{
			if( $this->_Data['day'] == "" ) return;
			$this->days[$this->_Data['day']] = 1;
			$this->times[$this->_Data['day']] = $this->_Data['startTime'];
			$this->day = $this->_Data['day'];
			$this->time = $this->_Data['startTime'];
		}
	}
	
	protected function _getTournamentData( $tid )
	{
		$db = Database::getInstance();
		$SQL = $db->getConnection();
		
		$query = $SQL->query("SELECT id, venueID, year, month, day, time, information FROM `tournaments` WHERE `id` = '" . $SQL->real_escape_string( $tid ) . "'") or die($SQL->error);
		if($query->num_rows > 0) $this->_Data = $query->fetch_assoc();
		else 
			$this->_Data = 0;
		
	}
	
	public function getID(){ return $this->id; }
	
	public function getFormData()
	{
		$Template = Template::getInstance();
		$this->_Data = array("id" => $this->id,
													"venue" => htmlspecialchars_decode($this->_Data['venueID']),
    											"year" => htmlspecialchars_decode($this->year),
    											"month" => htmlspecialchars_decode($this->month),
    											"day" => htmlspecialchars_decode($this->day),
    											"time" => htmlspecialchars_decode($this->time),
    											"information" => htmlspecialchars_decode($this->long_info));
		
		return $Template->convertToForm($this->_Data, $this->_Types);
	}
	
	public function searchRow()
	{
		$Template = Template::getInstance();
		$Core = Core::getInstance();
		$data = array(	'id'		=>	$this->id,
						'venue_id'	=>	$this->_Venue->getID(),
						'venue_name'=>	$this->_Venue->getName(),
						'day'		=>	$this->day,
						'month'		=>	$Core->Month[$this->month],
						'year'		=>	$this->year,
						'time'		=>	$this->time,
						'sh_info'	=>	$this->short_info,
						'lg_info'	=>	$this->long_info
					);
		return $Template->Skin['tournaments']->searchRow( $data );
	}
	
	public function getPublicOutput()
	{
		$Template = Template::getInstance();
		$Core = Core::getInstance();
		$data = array(	'id'		=>	$this->id,
						'venue_id'	=>	$this->_Venue->getID(),
						'venue_name'=>	$this->_Venue->getName(),
						'venue_img'	=>	$this->_Venue->getIMG(),
						'day'		=>	$this->day,
						'month'		=>	$Core->Month[$this->month],
						'year'		=>	$this->year,
						'time'		=>	$this->time,
						'sh_info'	=>	$this->short_info,
						'lg_info'	=>	$this->long_info
					);
		return $Template->Skin['tournaments']->showPublicTournament( $data );
	}
	
	public static function getStaticForm()
	{
		$Template = Template::getInstance();
		$data = array('venue' => '',
								 'year' => '',
								 'month' => '',
								 'day' => '',
								 'time' => '',
								 'information' => ''
								 );
		$types = array("venues",
								"year",
								"month",
								"num_day",
								"time",
								"textarea"
							);
		
		return $Template->convertToForm($data, $types);
	}
			
	protected function _getDaysAndTimesHTML()
	{
		$Core = Core::getInstance();
		$html = "";
		foreach($this->days as $k => $v)
		{

				if($v == 1) $html .= $Core->Day[$k] . "'s at " . $this->times[$k] . "<br>";
		}
		return $html;
	}
	
	public static function add($venue_id, $month, $day, $year, $startTime, $information)
  {
   	$db = Database::getInstance();
		$SQL = $db->getConnection();
    
    if(empty(trim($venue_id)) || empty(trim($month)) || empty(trim($day)) || empty(trim($year)) || empty(trim($startTime)))
    {
			return 0;
    }
    
    $user = CMS_Core::getInstance()->User->fullName;
    $time = time();
    
    $q_str = "INSERT INTO `tournaments` (date_created, created_by, venueID, year, month, day, time, information) 
														VALUES ('{$time}',
																		'{$user}',
																		'{$SQL->real_escape_string($venue_id)}',
																		'{$SQL->real_escape_string($year)}',
																		'{$SQL->real_escape_string($month)}',
																		'{$SQL->real_escape_string($day)}',
																		'{$SQL->real_escape_string($startTime)}',
																		'{$SQL->real_escape_string($information)}'
																		)";
		
    $SQL->query($q_str) or die($SQL->error);
    return 1;
    
  }
  
  public function modify($venue_id, $month, $day, $year, $time, $information)
  {
    $db = Database::getInstance();
		$SQL = $db->getConnection();
    
    if(empty(trim($venue_id)) || empty(trim($month)) || empty(trim($day)) || empty(trim($year)) || empty(trim($time)))
    {
			return 0;
    }
    
    $user = CMS_Core::getInstance()->User->fullName;
    $edit_time = time();
    $description = addslashes(htmlspecialchars($information));
    
    $q_str = "UPDATE `tournaments` SET `date_last_edited` = '{$edit_time}', 
																	`edited_by` = '{$user}', 
																	`venueID` = '{$venue_id}',
																	`year` = '{$year}',
																	`month` = '{$month}',
																	`day` = '{$day}',
																	`time` = '{$time}',
																	`information` = '{$information}'
																	WHERE `id` = '{$this->id}'";
    $SQL->query($q_str) or die($SQL->error);
    return 1;
  }
  
  public function delete()
  {
    $db = Database::getInstance();
		$SQL = $db->getConnection();
		$querystr = "DELETE FROM `tournaments` WHERE `id` = {$this->id}";
		if($SQL->query($querystr))
			return 1;
		else
			return 0;
  }
	
	public function isEmpty()
	{
		if( $this->id == -1 ) return true;
		return false;
	}

}

?>