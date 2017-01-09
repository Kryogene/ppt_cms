<?PHP

class Statistic
{
	
	private $_Data = array();
	private $_Player;
	public $DEBUG;
	
	

	public function __construct( $col, $val )
	{

		$Core = Core::getInstance();
		$this->DEBUG[] = "Fetching Statistic '{$col}' => '{$val}'...";

		$this->_Data = $this->_getStatistic( $col, $val );
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
		$this->year = $this->_Data['year'];
		$this->month = $this->_Data['year'];
		$this->player_id = $this->_Data['player_id'];
		$this->nonvenue_wins = $this->_Data['nonvenue'];
		$this->bounties = $this->_Data['bounty'];
		$this->high_hands = $this->_Data['high_hand'];
		$this->xtra_points = $this->_Data['xtra_points'];
		$this->hands_played = $this->_Data['hands_played'];
		$this->event_points = $this->_Data['event_points'];
		$this->chips_earned = $this->_calcChipsEarned();
		$this->points_earned = $this->_calcPointsEarned();
	}
	
	
	protected function _getStatistic( $col, $val )
	{
		$db = Database::getInstance();
		$SQL = $db->getConnection();
		
		$query = $SQL->query("SELECT * FROM `player_statistics` WHERE `{$col}` = '" . $SQL->real_escape_string( $val ) . "'");
		if($query) return $query->fetch_assoc();
		else return 0;
	}
	
	private function _calcChipsEarned()
	{
		global $Panel;
		$total = 0;

		if($this->_Data['totalWins'] > 2)
		{
			$total = (($this->_Data['totalWins'] - 3) * 1000) + 20000 + ($this->_Data['bounty'] * 500) + ($this->_Data['highHand'] * 2000) + $this->_Data['xtraPoints'] + $this->_Data['chipBonusVNV'] + $statistics['chipWinBonus'];
		}
		return $total;
	}
	
	private function _calcPointsEarned()
	{
		global $Panel;

		$total = ( $statistic['venueWins'] * 300 ) + ( $statistic['nonVenueWins'] * 200 ) + ( $statistic['bounty'] * 100 ) + ( $statistic['highHand'] * 200 ) + ( $statistic['handsPlayed'] * 100 ) + $statistic['eventPoints'];
			if($total > 25000)
				$total = 25000;
		return $total;
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
						'features_txt'	=>	$this->_featureHTML()
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
	
	public function isEmpty()
	{
		if( $this->id == -1 ) return true;
		return false;
	}

}

?>