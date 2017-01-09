<?PHP

class Tournaments_Handler extends Page_Handler
{

	public $DEBUG;
	
	private $_orderBy = array(	'venue'		=>	'Venue',
								'startTime'	=>	'Time',
							);
	
	function __construct()
	{
		$Template = Template::getInstance();
		$Template->loadSkin('tournaments');
	}
	
	public function PostHandler()
	{

	}
	
	public function GetHandler()
	{
		
		if( isset( $_GET['id'] ) )
			$this->_getTournamentQueriesSection();
		elseif( isset( $_GET['register'] ) )
			$this->_getRegisterSection();
		else
			$this->_getSearchTournamentSection();
	}	
	
	private function _getSearchData()
	{
		$Template = Template::getInstance();
		$Core = CMS_Core::getInstance();

		$search = ( isset($_GET['search']) ) ? addslashes( $_GET['search'] ) : '';
		if( isset($_GET['month']) )
			$month = ( !is_numeric($_GET['month']) ) ? $Core->getMonth( $_GET['month'] ) : $_GET['month'];
		else
			$month = 0;
		
		$orderBy = "ORDER BY `month`";
		$order = ( isset($_GET['order']) ) ? $_GET['order'] : "ASC";
		$order = (strtolower($order) == "desc") ? "DESC" : "ASC";
		return array(	'search'	=> $search, 
						'month'		=> $month,
						'dayOpt'	=> $Template->getMonthOptions( $month ),
						'orderBy'	=> $orderBy,
						'orderByOpt'=> $this->getOrderByOptions( (isset($_GET['orderBy'])) ? $_GET['orderBy'] : '' ),
						'order'		=> $order,
						'orderOpt'	=> $Template->getOrderOptions( $order )
					);
	}
	
	public function getOrderByOptions( $selection )
	{
		$html = "";
		$Template = Template::getInstance();
		foreach($this->_orderBy as $k => $v)
		{

			if(strtolower($k) == strtolower($selection))
				$html .= $Template->Skin['search']->selectOption( $v, $k, "selected" );
			else
				$html .= $Template->Skin['search']->selectOption( $v, $k );
		}
		return $html;
	}
	
	private function _getTournamentQueriesSection()
	{
		$Page = Page::getInstance();
		
		if( !is_numeric( $_GET['id'] ) )
		{
			$this->_getSearchTournamentSection();
			return;
		}
		
		$tournament = new Tournament( $_GET['id'] );
		if($tournament->isEmpty())
		{
			unset($tournament);
			$Page->setAlert( "Tournament Not Found", "The tournament could not be found in our database!", 1 );
			$this->_getSearchTournamentSection();
			return;
		}
		
		$Page->setSection( $Page->Title, $tournament->getPublicOutput() );
	}
		
	
	private function _getSearchTournamentSection()
	{
	
		$Page = Page::getInstance();
		$Template = Template::getInstance();
		$Core = CMS_Core::getInstance();
		
		$search_data = $this->_getSearchData();
	
		$html = $Template->Skin['search']->searchTournament( $search_data );
		
		$tournaments_by_day = $this->_getTournamentQueries( $search_data );
		
		if(!empty($tournaments_by_day))
			foreach( $tournaments_by_day as $month => $val )
			{
				$html .= $Template->Skin['tournaments']->tournamentCategory( $Core->Month[$month], $val );
			}
		else
			$html .= $Template->Skin['tournaments']->tournamentCategory( "Sorry", "No Results Found!" );
		
		$Page->setSection( $Page->Title, $html );
	}
		
	private function _getTournamentQueries( $search_data )
	{
	
		$db = Database::getInstance();
		$SQL = $db->getConnection();
		$Template = Template::getInstance();
		$Core = CMS_Core::getInstance();
		
		$month = array();
		if($search_data['month'] == 0)
		{
			$month = $this->_getAllTournaments( $search_data );
		}
		else
		{

			$month = $this->_getMonthTournaments( $search_data );
		}
		
		return $month;
		
	}
	
	private function _getQuery( $search_data )
	{
		$year = date('Y');
		return "SELECT * FROM `tournaments` WHERE `year` = '{$year}' AND `month` LIKE '%{$search_data['month']}%' {$search_data['orderBy']} {$search_data['order']}";

	}
	
	private function _getMonthTournaments( $search_data )
	{

		$db = Database::getInstance();
		$SQL = $db->getConnection();

		$query = $SQL->query($this->_getQuery( $search_data ));
		
		$month[$search_data['month']] = "";
		
		if($query->num_rows > 0)
			while($results = $query->fetch_assoc())
			{
				$tournament = new Tournament( $results['id'] );

				if( $search_data['search'] == "" )
					$month[$search_data['month']] .= $tournament->searchRow();
				else
					if( $tournament->contains( $search_data['search'] ) )
					$month[$search_data['month']] .= $tournament->searchRow();
			}
		else
			$month[$search_data['month']] = "No Results Found!";
				
		return $month;
	}
	
	private function _getAllTournaments( $search_data )
	{
		$db = Database::getInstance();
		$SQL = $db->getConnection();
		$Core = CMS_Core::getInstance();
		
		$month = array();
		
		foreach( $Core->Month as $key => $value )
		{
				$search_data['month'] = $key;
				$query = $SQL->query($this->_getQuery( $search_data ));
				
				$month[$key] = "";
				if($query->num_rows > 0)
					while($results = $query->fetch_assoc())
					{
						$tournament = new Tournament( $results['id'] );
						if($tournament->getMonth() == $key)
						{
							if( $search_data['search'] == "" )
							{
									$month[$key] .= $tournament->searchRow();
							}
							else
								if( $tournament->contains( $search_data['search'] ) )
								{
										$month[$key] .= $tournament->searchRow();
								}
						}
					}

				if($month[$key] == "") unset($month[$key]);
		}
			
		return $month;
			
	}

	private function _getRegisterSection()
	{
	
	}
	

}