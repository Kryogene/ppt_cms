<?PHP

class Statistics_Handler extends Page_Handler
{
	
	private $_Page, $_Template;
	
	private $_CSV_Headers = array("Last Name",
															 "First Name",
															 "NonVenue",
															 "Venues",
															 "VNVBonus",
															 "WinBonus",
															 "Bounty",
															 "Wins",
															 "HighHands",
															 "Xtra",
															 "MonthlyTotal",
															 "GamesPlayed",
															 "EventPts",
															 "MonthlyPts",
															 "PrvMonthPts",
															 "YTDTotal");
	
	private $_csv_dir = "csv/";
	
	function __construct()
	{

	}
	
	public function PostHandler()
	{
		$this->DEBUG[] = "Firing Post Handlers...";
	
		if( isset( $_POST['addStatistics'] ) )
			$this->_handleAddStatistics();
			
		if( isset( $_POST['modifyStatistics'] ) )
			$this->_handleModifyStatistics();
		
		if( isset( $_POST['confirmDelete'] ) )
			$this->_handleConfirmedDelete();
			
		$this->DEBUG[] = "Post Handlers Fired!";
	}
	
	public function GetHandler()
	{	
	
		$this->DEBUG[] = "Firing Get Handlers...";
		
		if( isset( $_GET['search'] ) )
			$this->_handleSearch();
		elseif( isset( $_GET['modify'] ) )
			$this->_handleModify();
		elseif( isset( $_GET['add'] ) )
			$this->_handleAdd();
		elseif( isset( $_GET['delete'] ) )
			$this->_handleDelete();
		
		if(isset($_GET['csv']))
			$this->_handleCSV();
		
	}
	
	public function SectionHandler()
	{
		
		$this->_Page = Page::getInstance();
		$this->_Template = Template::getInstance();
    $this->_Template->loadSkin("statistics");
	
		$this->_Page->setSection( $this->_Page->Name . " - Main", $this->_handleStatisticsMain() );
		
	}
	
	private function _handleStatisticsMain()
	{
		$html = $this->_Template->Skin['statistics']->mainTable();
		return $html;
	}
	
	private function _handleSearch()
	{
		$sh = new Search_Handler( "player_statistics" );
		$sh->fireAllPresets();
	}
  
  private function _handleAdd()
  {

		$this->_Page->setSection( $this->_Page->Name . " - Add", Statistics::addForm($this->_Template) );
  }
	
	private function _handleModify()
	{
		$db = Database::getInstance();
		$SQL = $db->getConnection();
		if(isset($_GET['id']) && is_numeric($_GET['id'])) 
		{
			$stats = new Statistics($_GET['id']);
			$this->_Page->setSection( $this->_Page->Name, $stats->getModifyTable($stats->getStatisticRow()) );
			return;
		}
		if(isset($_GET['venue_id']))
		{
			$year = (isset($_GET['year']) ? $_GET['year'] : date('Y'));
			$month = (isset($_GET['month']) ? $_GET['month'] : date('n'));
			$day = (isset($_GET['day']) ? $_GET['day'] : date('d'));
			
			$q_str = "SELECT `players`.`id`, `player_statistics`.`id` FROM `player_statistics` INNER JOIN `players` ON `player_statistics`.`player_id` = `players`.`id` WHERE `player_statistics`.`year` = '" . $SQL->real_escape_string($year) . "'
																											AND `player_statistics`.`month` = '" . $SQL->real_escape_string($month) . "'
																											AND `player_statistics`.`day` = '" . $SQL->real_escape_string($day) . "'
																											AND `player_statistics`.`venue_id` = '" . $SQL->real_escape_string($_GET['venue_id']) . "'
																											ORDER BY `players`.`lastName` ASC";
			$query = $SQL->query($q_str);
			$rows = "";
			while($result = $query->fetch_assoc())
			{
				$stats = new Statistics($result['id']);
				$rows .= $stats->getStatisticRow();
			}
			$rows .= $stats->getBlankRow();
			$this->_Page->setSection( $this->_Page->Name, $stats->getModifyTable($rows) );
		}
		
	}
	
	private function _handleAddStatistics()
	{
		$db = Database::getInstance();
		$SQL = $db->getConnection();
		
		$statsToAdd = array();
		foreach($_POST['player'] as $key => $val)
		{
			if(!empty($val))
			{
				$statsToAdd[] = array("pid"						=>	$val,
														 	"nonvenue"			=>	$_POST['nonvenue'][$key],
															"venue_wins"		=>	$_POST['venue_wins'][$key],
														 	"bounty"				=>	$_POST['bounty'][$key],
														 	"high_hand"			=>	$_POST['high_hand'][$key],
														 	"xtra_points"		=>	$_POST['xtra_points'][$key],
														 	"hands_played"	=>	$_POST['hands_played'][$key],
														 	"event_points"	=>	$_POST['event_points'][$key]
														 );
			}
			
		}
		foreach($statsToAdd as $player)
		{
			foreach($player as $k => $v)
			{
				if(empty($v))
					$player[$k] = 0;
				else
					$player[$k] = trim($v);
			}
				$q_str = "INSERT INTO `player_statistics` (year, month, day, player_id, venue_id, nonvenue, venue_wins, bounty, high_hand, xtra_points, hands_played, event_points) 
									VALUES ('{$_POST['year']}', '{$_POST['month']}', '{$_POST['day']}', {$player['pid']}, {$_POST['venue_id']}, {$player['nonvenue']}, {$player['venue_wins']}, {$player['bounty']}, {$player['high_hand']}, {$player['xtra_points']}, {$player['hands_played']}, {$player['event_points']})";
    		$SQL->query($q_str) or die($SQL->error . "<P>" . $q_str . "</P>");
		}
		$this->_Page->setAlert("Success", "All player statistics have been successfully added!");
	}
	
	private function _handleDelete()
	{
		if(!isset($_GET['id']) || !is_numeric($_GET['id']))
		{
			$this->_handleSearch();
			return;
		}
		$this->_Page->setAlert("Warning", "By confirming removal of this player all player statistics will be removed!", 1);
		$fb = new FormBuilder( $this->_Template );
		$field = $fb->buildByType(array("id" => $_GET['id']), array("hidden") );
		$this->_Page->setSection( $this->_Page->Name, $this->_Template->Skin['users']->confirmForm($field) );
	}
	
	private function _handleModifyStatistics()
	{
		$db = Database::getInstance();
		$SQL = $db->getConnection();
		
		for($i=0;$i<count($_POST['id']);$i++)
		{		

			$q_str = "UPDATE `player_statistics` SET year = '" . $SQL->real_escape_string($_POST['year']) . "',
																							month = '" . $SQL->real_escape_string($_POST['month']) . "', 
																							day = '" . $SQL->real_escape_string($_POST['day']) . "', 
																							venue_id = '" . $SQL->real_escape_string($_POST['venue_id']) . "', 
																							nonvenue = '" . $SQL->real_escape_string($_POST['nonvenue'][$i]) . "',
																							venue_wins = '" . $SQL->real_escape_string($_POST['venue_wins'][$i]) . "',
																							bounty = '" . $SQL->real_escape_string($_POST['bounty'][$i]) . "',
																							high_hand = '" . $SQL->real_escape_string($_POST['high_hand'][$i]) . "',
																							xtra_points = '" . $SQL->real_escape_string($_POST['xtra_points'][$i]) . "',
																							hands_played = '" . $SQL->real_escape_string($_POST['hands_played'][$i]) . "',
																							event_points = '" . $SQL->real_escape_string($_POST['event_points'][$i]) . "'
																							WHERE `id` = '" . $SQL->real_escape_string($_POST['id'][$i]) . "'
																							";
			$SQL->query($q_str) or die($SQL->error);
		}
		$new_stat_index = count($_POST['id']);
		$new_added = 0;
		for($i=0;$i<count($_POST['player']);$i++)
		{
			if(!empty(trim($_POST['player'][$i])))
			{
				$q_str = "INSERT INTO `player_statistics` VALUES(null,
																							'" . $SQL->real_escape_string($_POST['year']) . "',
																							'" . $SQL->real_escape_string($_POST['month']) . "', 
																							'" . $SQL->real_escape_string($_POST['day']) . "', 
																							'" . $SQL->real_escape_string($_POST['player'][$i]) . "',
																							'" . $SQL->real_escape_string($_POST['venue_id']) . "', 
																							'" . $SQL->real_escape_string($_POST['nonvenue'][$new_stat_index]) . "',
																							'" . $SQL->real_escape_string($_POST['venue_wins'][$new_stat_index]) . "',
																							'" . $SQL->real_escape_string($_POST['bounty'][$new_stat_index]) . "',
																							'" . $SQL->real_escape_string($_POST['high_hand'][$new_stat_index]) . "',
																							'" . $SQL->real_escape_string($_POST['xtra_points'][$new_stat_index]) . "',
																							'" . $SQL->real_escape_string($_POST['hands_played'][$new_stat_index]) . "',
																							'" . $SQL->real_escape_string($_POST['event_points'][$new_stat_index]) . "'
																							)";
				$SQL->query($q_str) or die($SQL->error);
				$new_added++;
				$new_stat_index++;
			}
		}
		
		$this->_Page->setAlert("Success", "<b>" . count($_POST['id']) . "</b> statistics have been updated and <b>" . $new_added . "</b> have been added!");
	}
	
	private function _handleConfirmedDelete()
	{
		if( User_Profile::delete($_POST['id']) )
			if( PlayerStatistics::deleteAll($_POST['id']))
				$this->_Page->setAlert("Success", "Player has been successfully removed!");
			else
				$this->_Page->setAlert("Uh Oh", "Player statistics could not be removed!", 2);
		else
			$this->_Page->setAlert("Uh Oh", "Player profile could not be removed!", 2);
	}
	
	private function _handleCSV()
	{
		$db = Database::getInstance();
		$SQL = $db->getConnection();
		$Template = Template::getInstance();
		
		$q_str = "SELECT DISTINCT player_id FROM `player_statistics` WHERE `year` = '".date('Y')."' AND `month` = '12'";
		$query = $SQL->query($q_str);
		

		$headers = "";
		$csv = array();
		while($result = $query->fetch_assoc())
		{
			$player = new PlayerStatistics($result['player_id'], 2016, 12);
			$csv[] = $player->getCSVRow();
			$headers = $player->getVenueHeaders();
		}
		array_splice( $this->_CSV_Headers, 2, 0, $headers ); // splice in at position 2
		
		$tmp = array($this->_CSV_Headers);
		
		foreach($csv as $v)
			$tmp[] = $v;
		
		$csv_file = new FileManager("php://output", "");
		$csv_file->writeCSV($tmp);
		
		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename=statistics.csv');
		//header('Content-Length: ' . filesize($this->_csv_dir . "statistics.csv"));
    //readfile($this->_csv_dir . "statistics.csv");
		exit();
	}
	
}

?>