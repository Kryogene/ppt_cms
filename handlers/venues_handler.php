<?PHP

class Venues_Handler extends Page_Handler
{

	public $DEBUG;
	
	private $_orderBy = array(	'name'		=>	'Name',
								'startTime'	=>	'Time',
								'city'		=>	'City'
							);
	
	function __construct()
	{
		$Template = Template::getInstance();
		$Template->loadSkin('venues');
	}
	
	public function PostHandler()
	{

	}
	
	public function GetHandler()
	{
		
		if( isset( $_GET['id'] ) )
			$this->_getVenueQueriesSection();
		elseif( isset( $_GET['register'] ) )
			$this->_getRegisterSection();
		elseif( $this->_isSearching() )
			$this->_getSearchVenueSection();
	}	
	
	private function _isSearching()
	{
		if(isset($_GET['search']))
			return true;
		if(isset($_GET['orderBy']))
			return true;
		if(isset($_GET['day']))
			return true;
		
	}
	
	private function _getSearchData()
	{
		$Template = Template::getInstance();
		$Core = CMS_Core::getInstance();

		$search = ( isset($_GET['search']) ) ? addslashes( $_GET['search'] ) : '';
		if( isset($_GET['day']) )
			$day = ( !is_numeric($_GET['day']) ) ? $Core->getDay( $_GET['day'] ) : $_GET['day'];
		else
			$day = 0;
		$orderBy = ( isset($_GET['orderBy']) ) ? "ORDER BY `" . addslashes( $_GET['orderBy'] ) . "`" : "ORDER BY `day`";
		$order = ( isset($_GET['order']) ) ? $_GET['order'] : "ASC";
		$order = (strtolower($order) == "desc") ? "DESC" : "ASC";
		return array(	'search'	=> $search, 
						'day'		=> $day,
						'dayOpt'	=> $Template->getDayOptions( $day ),
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
	
	private function _getVenueQueriesSection()
	{
		$Page = Page::getInstance();
		
		if( !is_numeric( $_GET['id'] ) )
		{
			$this->_getSearchVenueSection();
			return;
		}
		
		$venue = new Venue( $_GET['id'] );
		if($venue->isEmpty())
		{
			unset($venue);
			$Page->setAlert( "Venue Not Found", "The venue could not be found in our database!", 1 );
			$this->_getSearchVenueSection();
			return;
		}
		
		$Page->setSection( $Page->Title, $venue->getPublicOutput() );
	}
		
	
	private function _getSearchVenueSection()
	{
	
		$Page = Page::getInstance();
		$Template = Template::getInstance();
		$Core = CMS_Core::getInstance();
		
		$search_data = $this->_getSearchData();
	
		$html = $Template->Skin['search']->searchVenue( $search_data );
		
		$venues_by_day = $this->_getVenueQueries( $search_data );

		foreach( $venues_by_day as $day => $val )
		{
			$html .= $Template->Skin['venues']->venueCardCategory( $Core->Day[$day], $val );
		}
		
		$Page->setSection( $Page->Title, $html );
	}
		
	private function _getVenueQueries( $search_data )
	{
	
		$db = Database::getInstance();
		$SQL = $db->getConnection();
		$Template = Template::getInstance();
		$Core = CMS_Core::getInstance();
		
		$day = array();
		if($search_data['day'] == 0)
		{
			$day = $this->_getAllVenues( $search_data );
		}
		else
		{

			$day = $this->_getDayVenues( $search_data );
		}
		
		return $day;
		
	}
	
	private function _getQuery( $search_data )
	{
	
		return "SELECT * FROM `venues` WHERE `day` LIKE '%{$search_data['day']}%' {$search_data['orderBy']} {$search_data['order']}";

	}
	
	private function _getDayVenues( $search_data )
	{

		$db = Database::getInstance();
		$SQL = $db->getConnection();

		$query = $SQL->query($this->_getQuery( $search_data ));
		
		$day[$search_data['day']] = "";
		
		if($query->num_rows > 0)
			while($results = $query->fetch_assoc())
			{
				$venue = new Venue( $results['id'] );
				if(!$venue->isSetDay())
					$venue->setDay($search_data['day']);
				if( $search_data['search'] == "" )
					$day[$search_data['day']] .= $venue->searchRowCard();
				else
					if( $venue->contains( $search_data['search'] ) )
					$day[$search_data['day']] .= $venue->searchRowCard();
			}
		else
			$day[$search_data['day']] = "No Results";
				
		return $day;
	}
	
	private function _getAllVenues( $search_data )
	{
		$db = Database::getInstance();
		$SQL = $db->getConnection();
		$Core = CMS_Core::getInstance();
		
		$day = array();
		
		foreach( $Core->Day as $key => $value )
		{
				$search_data['day'] = $key;
				$query = $SQL->query($this->_getQuery( $search_data ));
				$day[$key] = "";
				if($query->num_rows > 0)
					while($results = $query->fetch_assoc())
					{
						$venue = new Venue( $results['id'] );
						if(!$venue->isSetDay())
							$venue->setDay($key);

						if( $search_data['search'] == "" )
							$day[$key] .= $venue->searchRowCard();
						else
							if( $venue->contains( $search_data['search'] ) )
								$day[$key] .= $venue->searchRowCard();
					}

				if($day[$key] == "") unset($day[$key]);
		}
			
		return $day;
			
	}

	private function _getRegisterSection()
	{
	
	}
	

}