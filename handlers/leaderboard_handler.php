<?PHP

class Leaderboard_Handler extends Page_Handler
{

	public $DEBUG;
	
	private $_orderBy = array(	'name'		=>	'Name',
								'startTime'	=>	'Time',
								'city'		=>	'City'
							);
	
	function __construct()
	{
		$Template = Template::getInstance();
		$Template->loadSkin('leaderboard');
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
			$this->_getSearchLeaderboardSection();
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
		$orderBy = ( isset($_GET['orderBy']) ) ? "ORDER BY `" . addslashes( $_GET['orderBy'] ) . "`" : "ORDER BY `month`";
		$order = ( isset($_GET['order']) ) ? $_GET['order'] : "ASC";
		$order = (strtolower($order) == "desc") ? "DESC" : "ASC";
		return array(	'search'	=> $search, 
						'month'		=> $month,
						'monthOpt'	=> $Template->getMonthOptions( $month ),
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

	
	private function _getSearchLeaderboardSection()
	{
	
		$Page = Page::getInstance();
		$Template = Template::getInstance();
		$Core = CMS_Core::getInstance();

		$search_data = $this->_getSearchData();
	
		$html = $Template->Skin['search']->searchLeaderboard( $search_data );
	
		$leaderboard = new Leaderboard();
		$leaderboard->limit = (isset($_GET['limit'])) ? $_GET['limit'] : 30;
		$leaderboard->offset = (isset($_GET['offset'])) ? $_GET['offset'] : 0;
		if(isset($_GET['month']))
		{
			if(is_numeric($_GET['month']))
				if($_GET['month'] > 0 && $_GET['month'] < 13)
					$leaderboard->month = $_GET['month'];
		}
		else
		{
			$this->month = date('n');
			$leaderboard->month = date('n');
		}
		if(isset($_GET['search']))
			$leaderboard->search = $_GET['search'];
		$leaderboard->query();
		
		$html .= $leaderboard->getOutput();
		
		$Page->setSection( $Page->Title, $html );
	}
	

}