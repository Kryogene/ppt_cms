<?PHP

class Venue
{
	
	private $_Data = array();
	private $_Features = array();
	public $DEBUG;
	
	protected $id, $name, $img, $time, $phone, $address, $city, $state, $zipCode, $short_desc, $long_desc;
	protected $day = 0;
	protected $days = array( 1=>0,2=>0,3=>0,4=>0,5=>0,6=>0,7=>0 );
	protected $times = array( 1=>'',2=>'',3=>'',4=>'',5=>'',6=>'',7=>'' );

	public function __construct( $id )
	{

		$Core = CMS_Core::getInstance();
		$this->DEBUG[] = "Fetching Venue ID '{$id}'...";

		$this->_Data = $this->_getVenueByID( $id );
		if($this->_Data == 0)
		{
			$this->id = -1;
			return false;
		}
		$this->_setObject();
		$this->_setVenueFeatures();
		
		unset($this->_Data);
		
		$Core->DEBUG[] = $this->DEBUG;
	}
	
	protected function _setObject()
	{
		$this->id = $this->_Data['id'];
		$this->name = $this->_Data['name'];
		$this->img = ( empty($this->_Data['img']) ) ? DEFAULT_IMG : $this->_Data['img'];
		$this->img = VENUE_IMAGES . $this->img;
		$this->_setTimeAndDays();
		$this->phone = preg_replace('/^(\d{3})(\d{3})(\d{4})$/', '($1) $2-$3', $this->_Data['phone']);
		$this->address = $this->_Data['address'];
		$this->city = $this->_Data['city'];
		$this->state = $this->_Data['state'];
		$this->zipCode = $this->_Data['zipCode'];
		$this->long_desc = $this->_Data['description'];
		$this->short_desc = substr($this->long_desc,0,100);
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
	
	protected function _getVenueByID( $id )
	{
		$db = Database::getInstance();
		$SQL = $db->getConnection();
		
		$query = $SQL->query("SELECT * FROM `venues` WHERE `id` = '" . $SQL->real_escape_string( $id ) . "'");
		if($query) return $query->fetch_assoc();
		else return 0;
	}
	
	protected function _setVenueFeatures()
	{
		$db = Database::getInstance();
		$SQL = $db->getConnection();
		
		$feature = explode(",", $this->_Data['features']);
		
		foreach($feature as $id)
		{
			$query = $SQL->query("SELECT * FROM `venue_features` WHERE `id` = '" . $SQL->real_escape_string( $id ) . "'");
			if($query)
				if($query->num_rows > 0)
					$this->_Features[] = $query->fetch_assoc();
		}
	}
	
	public function getName(){ return $this->name; }
	public function getID(){ return $this->id; }
	public function getIMG(){ return $this->img; }
	public function isDay($day){ if($this->day[$day] == 1) return true; else return false; }
	
	public function setDay( $d )
	{
		if($this->day == 0 && $this->days[$d] == 1)
		{
			$this->day = $d;
			$this->time = $this->times[$d];
			return true;
		}
		return false;
	}
	
	public function isSetDay()
	{
		if($this->day == 0) return false;
		return true;
	}
	
	public function searchRow()
	{
		$Template = Template::getInstance();
		$data = array(	'id'		=>	$this->id,
						'name'		=>	$this->name,
						'day'		=>	$this->day,
						'time'		=>	$this->time,
						'address'	=>	$this->address,
						'city'		=>	$this->city,
						'zipCode'	=>	$this->zipCode,
						'state'		=>	$this->state,
						'phone'		=>	$this->phone,
						'sh_desc'	=>	$this->short_desc,
						'lg_desc'	=>	$this->long_desc,
						'features'	=>	$this->_featureHTML(),
						'features_txt'	=>	$this->_featureHTML()
					);
		return $Template->Skin['venues']->searchRow( $data );
	}
	
	public function searchRowCard()
	{
		$Template = Template::getInstance();
		$data = array(	'id'		=>	$this->id,
						'name'		=>	$this->name,
						'day'		=>	$this->day,
						'time'		=>	$this->time,
						'address'	=>	$this->address,
						'city'		=>	$this->city,
						'zipCode'	=>	$this->zipCode,
						'state'		=>	$this->state,
						'phone'		=>	$this->phone,
						'sh_desc'	=>	$this->short_desc,
						'lg_desc'	=>	$this->long_desc,
						'features'	=>	$this->_featureHTML(),
						'features_txt'	=>	$this->_featureTxt()
					);
		return $Template->Skin['venues']->searchRowCard( $data );
	}
	
	public function getPublicOutput()
	{
		$Template = Template::getInstance();
		$data = array(	'id'		=>	$this->id,
						'name'		=>	$this->name,
						'img'		=>	$this->img,
						'dayAndTime'=>	$this->_getDaysAndTimesHTML(),
						'address'	=>	$this->address,
						'city'		=>	$this->city,
						'zipCode'	=>	$this->zipCode,
						'state'		=>	$this->state,
						'phone'		=>	$this->phone,
						'sh_desc'	=>	$this->short_desc,
						'lg_desc'	=>	$this->long_desc,
						'features'	=>	$this->_featureHTML(),
						'features_txt'	=>	$this->_featureTxt()
					);
		return $Template->Skin['venues']->showPublicVenue( $data );
	}
	
	public function contains( $string )
	{
		
		if((strpos(strtolower($this->name), strtolower($string)) !== false)) return true;
		if((strpos(strtolower($this->address), strtolower($string)) !== false)) return true;
		if((strpos(strtolower($this->time), strtolower($string)) !== false)) return true;
		if((strpos(strtolower($this->city), strtolower($string)) !== false)) return true;
		if((strpos(strtolower($this->zipCode), strtolower($string)) !== false)) return true;
		if((strpos(strtolower($this->state), strtolower($string)) !== false)) return true;
		if((strpos(strtolower($this->phone), strtolower($string)) !== false)) return true;
		if((strpos(strtolower($this->long_desc), strtolower($string)) !== false)) return true;
		if((strpos(strtolower($this->_featuresTxt()), strtolower($string)) !== false)) return true;
		return false;
	}
			
	public function _getDaysAndTimesHTML()
	{
		$Core = CMS_Core::getInstance();
		$html = "";
		foreach($this->days as $k => $v)
		{

				if($v == 1) $html .= $Core->Day[$k] . "'s at " . $this->times[$k] . "<br>";
		}
		return $html;
	}
	
	public function _featureHTML()
	{
		$Template = Template::getInstance();
		
		if(!empty($this->_Features))
			foreach($this->_Features as $feature)
				if(!isset($html)) $html = $Template->Skin['venues']->FeatureImage($feature);
				else $html .= $Template->Skin['venues']->FeatureImage($feature);
		else
			$html = "";
		return $html;
	}
	
	public function _featureTxt()
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