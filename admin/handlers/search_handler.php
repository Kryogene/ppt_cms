<?PHP

class Search_Handler extends Page_Handler
{

	private $Page;
	public $DEBUG;
	private $_field;
	private $_orderBy, $_order;
	
	function __construct( $field )
	{
		$this->Page = Page::getInstance();
		$this->Page->Title .= " - Search";
		$this->_field = $field;
		$this->_orderBy = htmlspecialchars(@$_GET['orderBy']);
		$this->_order = htmlspecialchars(@$_GET['order']);
	}
	
	public function PostHandler()
	{
		
	}
	
	public function GetHandler()
	{
		if(empty($this->_field)) return;
		switch($this->_field)
		{
			case "players":
				$this->_handlePlayers();
			break;
			case "announcements":
				$this->_handleAnnouncements();
			break;
			case "player_statistics":
				$this->_handleStatistics();
			break;
			case "venues":
				$this->_handleVenues();
			break;
			case "tournaments":
				$this->_handleTournaments();
			break;
			default:
				$this->SectionHandler();
			break;
		}
	}	
	
	public function SectionHandler()
	{
		$this->Page->setSection( $this->Page->Title, "Search Main Page" );
		
	}
	
	private function _handlePlayers()
	{

		$search = new Search ( $this->_field );
		
		$selectors = array("id", "lastName", "firstName", "email", "phone", "type");
		$search_fields = array("firstName", "lastName");
		
		if(!isset($_GET['search']))
			$search->query($selectors, "players");
		else
			$search->queryContains($_GET['search'],$selectors,$search_fields, $this->_orderBy, $this->_order);
		
		if(empty($search->error))
		{
			$this->Page->setSection( $this->Page->Title, $search->getHTML("users") );
		}else
			$this->Page->setSection( $this->Page->Title, "ERROR: " . $search->error );
	}
	
	private function _handleAnnouncements()
	{
		$search = new Search ( $this->_field );
		
		$selectors = array("id", "subject", "created_by", "content");
		$search_fields = array("subject", "content");
		
		if(!isset($_GET['search']))
			$search->query($selectors, "announcements");
		else
			$search->queryContains($_GET['search'],$selectors,$search_fields, $this->_orderBy, $this->_order);
		
		if(empty($search->error))
		{

			$this->Page->setSection( $this->Page->Title, $search->getHTML("announcements") );
		}else
			$this->Page->setSection( $this->Page->Title, "ERROR: " . $search->error );
	}
	
	private function _handleVenues()
	{
		$search = new Search ( $this->_field );
		
		$selectors = array("id", "name", "startTime", "day", "address", "city", "state", "zipCode", "phone", "description");
		$search_fields = array("name", "startTime", "address", "city", "state", "zipCode", "phone", "description");
		
		if(!isset($_GET['search']))
			$search->query($selectors, "venues");
		else
			$search->queryContains($_GET['search'],$selectors,$search_fields, $this->_orderBy, $this->_order);
		
		if(empty($search->error))
		{

			$this->Page->setSection( $this->Page->Title, $search->getHTML("venues") );
		}else
			$this->Page->setSection( $this->Page->Title, "ERROR: " . $search->error );
	}
	
	private function _handleStatistics()
	{
		$search = new Search ( $this->_field );
		
		$selectors = array("player_statistics.id", "player_statistics.player_id", "player_statistics.venue_id", "player_statistics.year", "player_statistics.month", "player_statistics.day", "players.lastName", "players.firstName");
		$search_fields = array("players.lastName", "players.firstName");
		
		if(!isset($_GET['search']))
			$search->query($selectors, "player_statistics");
		else
			$search->queryContains($_GET['search'],$selectors,$search_fields, $this->_orderBy, $this->_order, "players", array("player_statistics.player_id" => "players.id"));
		
		if(empty($search->error))
		{

			$this->Page->setSection( $this->Page->Title, $search->getHTML("statistics") );
		}else
			$this->Page->setSection( $this->Page->Title, "ERROR: " . $search->error );
	}
	
	private function _handleTournaments()
	{
		$search = new Search ( $this->_field );
		
		$selectors = array("venues.id", "venues.name", "tournaments.id", "tournaments.venueID", "tournaments.year", "tournaments.month", "tournaments.day", "tournaments.time", "tournaments.information");
		$search_fields = array("venues.name", "tournaments.information");
		
		if(!isset($_GET['search']))
			$search->query($selectors, "tournaments", null, null, "venues", array("tournaments.venueID" => "venues.id"));
		else
			$search->queryContains($_GET['search'],$selectors,$search_fields, $this->_orderBy, $this->_order, "venues", array("tournaments.venueID" => "venues.id"));
		
		if(empty($search->error))
		{

			$this->Page->setSection( $this->Page->Title, $search->getHTML("tournaments") );
		}else
			$this->Page->setSection( $this->Page->Title, "ERROR: " . $search->error );
	}

}