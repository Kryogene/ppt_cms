<?PHP

class Tournament
{
	
	private $_Data = array();
	private $_Venue = array();
	public $DEBUG;
	
	protected $id, $year, $month, $day, $time, $short_info, $long_info;

	public function __construct( $id )
	{

		$Core = CMS_Core::getInstance();
		$this->DEBUG[] = "Fetching Tournament ID '{$id}'...";

		$this->_Data = $this->_getTournamentByID( $id );
		if($this->_Data == 0)
		{
			$this->id = -1;
			return false;
		}
		$this->_setObject();
		$this->_setVenueData();
		
		unset($this->_Data);
		
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
	
	protected function _getTournamentByID( $id )
	{
		$db = Database::getInstance();
		$SQL = $db->getConnection();
		
		$query = $SQL->query("SELECT * FROM `tournaments` WHERE `id` = '" . $SQL->real_escape_string( $id ) . "'");
		if($query) return $query->fetch_assoc();
		else return 0;
	}
	
	protected function _setVenueData()
	{

		$this->_Venue = new Venue( $this->_Data['venueID'] );
		
	}
	
	public function getID(){ return $this->id; }
	public function getMonth(){ return $this->month; }
	
	public function searchRow()
	{
		$Template = Template::getInstance();
		$Core = CMS_Core::getInstance();
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
		$Core = CMS_Core::getInstance();
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
	
	public function contains( $string )
	{
		if((strpos(strtolower($this->_Venue->getName()), strtolower($string)) !== false)) return true;
		if((strpos(strtolower($this->time), strtolower($string)) !== false)) return true;
		if((strpos(strtolower($this->long_info), strtolower($string)) !== false)) return true;
		return false;
	}
			
	protected function _getDaysAndTimesHTML()
	{
		$Core = CMS_Core::getInstance();
		$html = "";
		foreach($this->days as $k => $v)
		{

				if($v == 1) $html .= $Core->Day[$k] . "'s at " . $this->times[$k] . "<br>";
		}
		return $html;
	}
	
	protected function _featureHTML()
	{
		if(!empty($this->_Features))
			foreach($this->_Features as $feature)
				if(!isset($html)) $html = $feature['name'];
				else $html .= ", " . $feature['name'];
		else
			$html = "";
		return $html;
	}
	
	protected function _featuresTxt()
	{
		if(!empty($this->_Features))
			foreach($this->_Features as $feature)
				if(!isset($html)) $html = $feature['name'];
				else $html .= ", " . $feature['name'];
		else
			$html = "";
		return $html;
	}
	
	public function isEmpty()
	{
		if( $this->id == -1 ) return true;
		return false;
	}

}

?>