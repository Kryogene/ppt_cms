<?PHP

class Leaderboard
{
	
	private $_Data = array(array());
	private $_Venue = array();
	public $DEBUG;
	
	public $year, $month, $limit, $offset, $total_results, $results_returned, $search;

	public function __construct( $m = '', $y = '', $l = 30, $off = 0 )
	{
		if(empty($m))
			$m = (int)date('n');
		if(empty($y))
			$y = (int)date('Y');
		
		$Core = CMS_Core::getInstance();
		$this->DEBUG[] = "Fetching Leaderboard Results...";
		$this->year = $y;
		$this->month = $m;
		$this->limit = $l;
		$this->offset = $off;
		
		$Core->DEBUG[] = $this->DEBUG;
	}

	
	protected function _getTournamentByID( $id )
	{
		$db = Database::getInstance();
		$SQL = $db->getConnection();
		
		$query = $SQL->query("SELECT * FROM `tournaments` WHERE `id` = '" . $SQL->real_escape_string( $id ) . "'");
		if($query) return $query->fetch_assoc();
		else return 0;
	}
	
	protected function _setLeaderboardData()
	{
		$db = Database::getInstance();
		$SQL = $db->getConnection();
		//Let's make our month
		$query_mon = "";
		if($this->month > 0 && $this->month < 13)
			$query_mon = "AND `month` = '" . $this->month . "'";
		
		$this->_total_Results();

		$query_str = "SELECT DISTINCT player_id FROM `player_statistics` WHERE `year` = '{$this->year}' {$query_mon}";
		$query = $SQL->query($query_str);
		if($query->num_rows > 0)
		{
			$this->returned_results = $query->num_rows;
			while($results = $query->fetch_assoc())
			{
				$this->_Data[$this->month - 1][] = new PlayerStatistics( $results['player_id'] );
				//$player->getOutputByMonth($this->_Data);

			}
			
		}
		
	}
	
	private function _total_Results()
	{
		$db = Database::getInstance();
		$SQL = $db->getConnection();
		if($this->month > 0 && $this->month < 13)
			$query_mon = "AND `month` = '" . $this->month . "'";
		$query_str = "SELECT COUNT(DISTINCT player_id) FROM `player_statistics` WHERE `year` = '{$this->year}' {$query_mon}";
		$count_query = $SQL->query($query_str);
		$row = $count_query->fetch_row();
		$this->total_results = $row[0];
	}
	
	public function query()
	{
		$this->_Data = array(array());
		$this->_setLeaderboardData();
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
	
	public function isEmpty()
	{
		if( $this->id == -1 ) return true;
		return false;
	}
	
	public function sortResults( &$data, $ob = "point_total", $or = "desc")
	{
		$sorted = false;
		while ($sorted === false)
		{
			$sorted = true;
			for ($i = 0; $i < count($data) - 1; ++$i)
			{
				$current = $data[$i];
				$next = $data[$i+1];
				if(strtolower($or) == "desc")
				{
					if($next->Statistic[$this->month-1][$ob] > $current->Statistic[$this->month-1][$ob])
					{
						$data[$i] = $next;
						$data[$i+1] = $current;
						$sorted = false;
					}
				}
				else
				{
					if($next->Statistic[$this->month-1][$ob] < $current->Statistic[$this->month-1][$ob])
					{
						$data[$i] = $next;
						$data[$i+1] = $current;
						$sorted = false;
					}
				}
			}
		}
	}
	
	public function searchResults()
	{
		$oldData = $this->_Data[$this->month - 1];
		unset($this->_Data[$this->month - 1]);
		
		$count = 1;
		foreach($oldData as $key => $val)
		{
			if((strpos(strtolower(CMS_Core::getInstance()->getUsernameByID($val->getPID())), strtolower($this->search)) !== false))
			{
				$this->_Data[$this->month - 1][] = $oldData[$key];
			}
		}
	}
	
	public function limitResults()
	{
		$oldData = $this->_Data[$this->month - 1];
		unset($this->_Data[$this->month - 1]);
		
		$count = 1;
		for($i = $this->offset; $i < count($oldData); $i++)
		{
			$this->_Data[$this->month - 1][] = $oldData[$i];
			$count++;
			$this->total_results = $count;
			if($count > $this->limit)
				break;
		}
	}
	
	public function getOutput()
	{
		$Core = CMS_Core::getInstance();
		$Template = Template::getInstance();
		$html = "";	

		if(!isset($this->_Data[$this->month - 1]))
			return $Template->Skin['leaderboard']->leaderboardTable("Leaderboard", $Template->Skin['leaderboard']->noResults());
			
			if($this->month != -1)
			{
				$this->sortResults($this->_Data[$this->month - 1]);
				if(!empty($this->search))
					$this->searchResults();
				$this->limitResults($this->_Data[$this->month - 1]);
				
				foreach($this->_Data[$this->month - 1] as $v)
				{
					
					$html .= $v->outputLeaderboardRow($this->month-1);
				}
			}
			else
			{
				for($i=0;$i<12;++$i)
				{
					$this->sortResults($this->_Data[$i]);
					$html .= "<tr><th colspan=99>" . $Core->Month[($i+1)] . "</th></tr>";
					if(!isset($this->_Data[$i])) $this->_Data[$i][] = "<tr><td colspan=99>No Results.</td></tr>";
					foreach($this->_Data[$i] as $v)
					{
						$html .= $v;
					}
				}
			}
		return $Template->Skin['leaderboard']->leaderboardTable("Leaderboard", $html, $this->_calcLinks());
	}
	
	private function _calcLinks()
	{
		$Template = Template::getInstance();
		$begin_offset = 0;
		$back_offset = (($this->offset - $this->limit) < $begin_offset) ? $begin_offset : ($this->offset - $this->limit);
		$forward_offset = $this->offset + $this->limit;
		$last_offset = (($this->total_results % $this->limit) > 0) ? ((int)($this->total_results / $this->limit) * $this->limit) : $forward_offset;
		$html = "";
		if($this->offset > $begin_offset)
		{
			$query = $_GET;
			$query['offset'] = 0;
			$html .= $Template->Skin['search']->goToBeginning( http_build_query($query) );
			$query = $_GET;
			$query['offset'] = $back_offset;
			$html .= $Template->Skin['search']->goBackOnePage( http_build_query($query) );
		}
		if($forward_offset < $this->total_results )
		{
				$query = $_GET;
				$query['offset'] = $last_offset;
				$html .= $Template->Skin['search']->goToLast( http_build_query($query) );

			$query = $_GET;
			$query['offset'] = $forward_offset;
			$html .= $Template->Skin['search']->goForwardOnePage( http_build_query($query) );
		}
		return $html;
	}

}

?>