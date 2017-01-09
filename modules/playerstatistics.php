<?PHP

class PlayerStatistics
{
	
	private $stat_fields = array( 'user'	=> "",
															 'nonvenue'		=> 0,
															 'venue_wins'	=> 0,
															 'distinct_venues' => 0,
																'bounty'		=> 0,
																'high_hand'		=> 0,
																'xtra_points'	=> 0,
																'hands_played'	=> 0,
																'event_points'	=> 0,
																'total_wins'	=> 0,
																'chip_bonus_vnv'=> 0,
																'chip_win_bonus'=> 0,
																'chip_total'	=> 0,
																'point_total'	=> 0,
																'points_ytd'	=> 0
								);
	
	public $Statistic = array(array());
	
									
	private $venueWins = array(5,7,10);
	private $nonVenueWins = array(10,20,40);
	private $chipValues = array(10000,15000,25000);
	private $chipBonusModifier = 2000;
									
	private $pid;
	public $year, $month, $day;
	private $recursive;
	
	function __construct( $pid, $y = 0, $m = -1, $d = "", $recurse = FALSE )
	{
		$this->pid = $pid;
		$this->recursive = $recurse;
		$Template = Template::getInstance();
		
		$Template->loadSkin("leaderboard");
		
		if($y == 0)
			$this->year = date('Y');
		else
			$this->year = $y;
		if($m == -1)
			$this->month = date('n');
		else
			$this->month = $m;
		

		$this->day = $d;
		$this->compileStats();
	}
	
	public function getPID()
	{
		return $this->pid;
	}
	
	public function compileStats()
	{
		$db = Database::getInstance();
		$SQL = $db->getConnection();
		
		$this->_resetStats();

		$qryStr = "SELECT * FROM `player_statistics` WHERE player_id = '" . $SQL->real_escape_string( $this->pid ) . "' AND year = '" . $this->year . "'";
		
		//if($this->month != null)
		//	$qryStr .= " AND `month` = '" . $this->month . "'";
		if($this->day != null)
			$qryStr .= " AND `day` = '". $this->day . "'";
		
		$query = $SQL->query($qryStr . " ORDER BY month ASC") or die();
		if($query->num_rows > 0)
		{
			while($data = $query->fetch_assoc())
			{
				if($data['venue_wins'] > 0) 
				{
					$this->Statistic[$data['month']-1]['distinct_venues']++;
				}
				foreach($this->Statistic[$data['month']-1] as $k => $v)
				{
					
					$this->Statistic[$data['month']-1][$k] += @$data[$k];
					
					
					$this->_compileTotalWins($data['month']-1);
					$this->_compileChipBonusVNV($data['month']-1);
					$this->_compileChipWinBonus($data['month']-1);
					$this->_compileChipTotal($data['month']-1);
					$this->_compilePointTotal($data['month']-1);
					$this->_compileYTDPointTotal($data['month']-1);
				}
			}
		}
		
	}

	
	private function _compileTotalWins($m)
	{
		$this->Statistic[$m]['total_wins'] = $this->Statistic[$m]['nonvenue'] + $this->Statistic[$m]['venue_wins'];
		//echo "IN: " . ($this->month - 1) . " | " . $this->Statistic[$this->month - 1]['total_wins'] . "<br>";
	}
	
	private function _compileChipBonusVNV($m)
	{
		$chipBonus = 0;
		foreach($this->chipValues as $key => $val)
		{
			if($this->Statistic[$m]['distinct_venues'] >= $this->venueWins[$key])
			{
				$chipBonus += $val;
			}
			else
			{
				if($this->Statistic[$m]['nonvenue'] >= $this->nonVenueWins[$key])
				{
					$chipBonus += $val;
				}
			}
		}
		$this->Statistic[$m]['chip_bonus_vnv'] = $chipBonus;
	}
	
	private function _compileChipWinBonus($m)
	{
		$this->Statistic[$m]['chip_win_bonus'] = ($this->Statistic[$m]['chip_bonus_vnv'] > 0) ? $this->Statistic[$m]['total_wins'] * $this->chipBonusModifier : 0;
	}
	
	private function _compileChipTotal($m)
	{
		$total = 0;

		if($this->Statistic[$m]['total_wins'] > 2)
		{
			$total = (($this->Statistic[$m]['total_wins'] - 3) * 1000) + 
						20000 + ($this->Statistic[$m]['bounty'] * 500) + 
						($this->Statistic[$m]['high_hand'] * 2000) + 
						$this->Statistic[$m]['xtra_points'] + 
						$this->Statistic[$m]['chip_bonus_vnv'] + 
						$this->Statistic[$m]['chip_win_bonus'];
		}
		$this->Statistic[$m]['chip_total'] = $total;
	}
	
	private function _compilePointTotal($m)
	{
		$this->Statistic[$m]['point_total'] = ( $this->Statistic[$m]['venue_wins'] * 300 ) + 
											( $this->Statistic[$m]['nonvenue'] * 200 ) + 
											( $this->Statistic[$m]['bounty'] * 100 ) + 
											( $this->Statistic[$m]['high_hand'] * 200 ) + 
											( $this->Statistic[$m]['hands_played'] * 100 ) + 
											$this->Statistic[$m]['event_points'];
			if($this->Statistic[$m]['point_total'] > 25000)
				$this->Statistic[$m]['point_total'] = 25000;
	}
	
	private function _compileYTDPointTotal($mc)
	{
		/*$points = 0;
		for($m = 1; $m < 13; ++$m)
		{
			$ps = new PlayerStatistics( $this->pid, $this->year, $m, null, TRUE);
			$points += $ps->Statistic[$m - 1]['point_total'];
		}
		$this->Statistic[$mc]['points_ytd'] = $points;*/
		$this->Statistic[0]['points_ytd'] = $this->Statistic[0]['point_total'];
		$this->Statistic[1]['points_ytd'] = $this->Statistic[0]['points_ytd'] + $this->Statistic[1]['point_total'];
		$this->Statistic[2]['points_ytd'] = $this->Statistic[1]['points_ytd'] + $this->Statistic[2]['point_total'];
		$this->Statistic[3]['points_ytd'] = $this->Statistic[2]['points_ytd'] + $this->Statistic[3]['point_total'];
		$this->Statistic[4]['points_ytd'] = $this->Statistic[3]['points_ytd'] + $this->Statistic[4]['point_total'];
		$this->Statistic[5]['points_ytd'] = $this->Statistic[4]['points_ytd'] + $this->Statistic[5]['point_total'];
		$this->Statistic[6]['points_ytd'] = $this->Statistic[5]['points_ytd'] + $this->Statistic[6]['point_total'];
		$this->Statistic[7]['points_ytd'] = $this->Statistic[6]['points_ytd'] + $this->Statistic[7]['point_total'];
		$this->Statistic[8]['points_ytd'] = $this->Statistic[7]['points_ytd'] + $this->Statistic[8]['point_total'];
		$this->Statistic[9]['points_ytd'] = $this->Statistic[8]['points_ytd'] + $this->Statistic[9]['point_total'];
		$this->Statistic[10]['points_ytd'] = $this->Statistic[9]['points_ytd'] + $this->Statistic[10]['point_total'];
		$this->Statistic[11]['points_ytd'] = $this->Statistic[10]['points_ytd'] + $this->Statistic[11]['point_total'];
	}
	
	private function _resetStats()
	{
		for($i=0;$i<12;++$i)
		{
			$this->Statistic[$i] = $this->stat_fields;
		}
	}
	
	public function outputLeaderboardRow( $m = "" )
	{
		
		if(empty($m)) $m = $this->month - 1;
		
		$Core = CMS_Core::getInstance();
		$Template = Template::getInstance();
		for($mk = 0; $mk < 12; ++$mk)
		{
			$this->Statistic[$mk]['user'] = CMS_Core::getInstance()->getUsernameByID( $this->pid );
		}
		$HTML = $Template->Skin['leaderboard']->searchRow( $this->Statistic[$m] );

		return $HTML;
	}
	
	public function outputAllLeaderboardRows()
	{

		$Core = CMS_Core::getInstance();
		$Template = Template::getInstance();
		
		$HTML = "";
		for($mk = 0; $mk < 12; ++$mk)
		{
			$this->Statistic[$mk]['user'] = CMS_Core::getInstance()->getUsernameByID( $this->pid );
		}
		for($i = 0; $i < 12; ++$i)
		{
			$this->Statistic[$i]['month'] = $Core->Month[$i+1];
			$HTML .= $Template->Skin['users']->leaderboardSearchRow( $this->Statistic[$i] );
		}

		return $HTML;
	}
	
	public function getOutputByMonth(&$data)
	{
		
		foreach($this->Statistic as $k => $v)
		{
			$empty = TRUE;
			foreach($v as $val)
			{
				if($val > 0)
					$empty = FALSE;
			}
			if(!$empty)
				$data[$k][] = $this->Statistic;
			
		}
	}
	
}
?>