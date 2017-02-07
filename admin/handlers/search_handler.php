<?PHP

class Search_Handler extends Page_Handler
{

	private $Page;
	public $DEBUG;
	private $_field;
	private $_order_by, $_order;
	
	function __construct( $field )
	{
		$this->Page = Page::getInstance();
		$this->Page->Title .= " - Search";
		$this->_field = $field;
		$this->_order_by = htmlspecialchars(@$_GET['order_by']);
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
			case "pages":
				$this->_handlePages();
			break;
			case "gallery_albums":
				$this->_handleGalleryAlbums();
			break;
			case "gallery_photos":
				$this->_handleGalleryPhotos();
			break;
			default:
				echo "in";
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
		
		$search->order_by = $this->_order_by;
		$search->order = $this->_order;
		
		if(!isset($_GET['search']))
			$search->query($selectors, "players");
		else
			$search->queryContains($_GET['search'],$selectors,$search_fields);
		
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
		
		$search->order_by = $this->_order_by;
		$search->order = $this->_order;
		
		if(!isset($_GET['search']))
			$search->query($selectors, "announcements");
		else
			$search->queryContains($_GET['search'],$selectors,$search_fields);
		
		if(empty($search->error))
		{

			$this->Page->setSection( $this->Page->Title, $search->getHTML("announcements") );
		}else
			$this->Page->setSection( $this->Page->Title, "ERROR: " . $search->error );
	}
	
	private function _handleVenues()
	{
		$search = new Search ( $this->_field );
		
		$selectors = array("id", "name", "startTime", "weekday", "address", "city", "state", "zipCode", "phone", "description");
		$search_fields = array("name", "startTime", "address", "city", "state", "zipCode", "phone", "description");
		
		$search->order_by = $this->_order_by;
		$search->order = $this->_order;
		
		if(!isset($_GET['search']))
			$search->query($selectors, "venues");
		else
			$search->queryContains($_GET['search'],$selectors,$search_fields);
		
		if(empty($search->error))
		{

			$this->Page->setSection( $this->Page->Title, $search->getHTML("venues") );
		}else
			$this->Page->setSection( $this->Page->Title, "ERROR: " . $search->error );
	}
	
	private function _handleStatistics()
	{
		$search = new Search ( $this->_field );
		
		$selectors = array("player_statistics.id", 
											 "player_statistics.player_id", 
											 "player_statistics.venue_id", 
											 "player_statistics.year", 
											 "player_statistics.month", 
											 "player_statistics.day", 
											 "players.lastName", 
											 "players.firstName",
											 "venues.name");
		$search_fields = array("players.lastName", "players.firstName", "venues.name");
		
		if(isset($_GET['group_by']))
		{
			$search->count = array("DISTINCT player_statistics.`player_id`", "players");
			$group_by = explode(",", $_GET['group_by']);
			foreach($group_by as $val)
			{
				if($val== "date")
				{
					$search->group_by[] = "day";
					$search->group_by[] = "month";
					$search->group_by[] = "year";
				}
				elseif($val == "venue")
					$search->group_by[] = "venue_id";
				else
					$search->group_by[] = $val;
			}
			$search->http_query = $search->group_by;
		}
		
		if($this->_order_by == "player")
			$search->order_by = "players.`lastName`";
		elseif($this->_order_by == "venue")
			$search->order_by = "venues.`name`";
		elseif($this->_order_by == "date")
			$search->order_by = array("player_statistics.`year`", "player_statistics.`month`", "player_statistics.`day`");
		elseif(empty($this->_order_by))
			$search->order_by = array("player_statistics.`year`", "player_statistics.`month`", "player_statistics.`day`");
		else
			$search->order_by = $this->_order_by;
		$search->order = $this->_order;
		
		if(!isset($_GET['search']))
			$search->query($selectors, "player_statistics");
		else
		{
			$joins = array("players", "venues");
			$join_cond = array(array("player_statistics.player_id", "players.id"),
												array("player_statistics.venue_id", "venues.id"));
			$search->queryContains($_GET['search'],$selectors, $search_fields, $joins, $join_cond);
		}
			
		if(empty($search->error))
		{
			$grouped = (isset($search->group_by[0]) ? "_grouped" : "");
			$this->Page->setSection( $this->Page->Title, $search->getHTML("statistics", $grouped) );
		}else
			$this->Page->setSection( $this->Page->Title, "ERROR: " . $search->error );
	}
	
	private function _handleTournaments()
	{
		$search = new Search ( $this->_field );
		
		$selectors = array("venues.id", "venues.name", "tournaments.id", "tournaments.venueID", "tournaments.time", "tournaments.information");
		$search_fields = array("venues.name", "tournaments.information");
		
		$search->order_by = $this->_order_by;
		$search->order = $this->_order;
		
		if(!isset($_GET['search']))
			$search->query($selectors, "tournaments", null, null, "venues", array("tournaments.venueID" => "venues.id"));
		else
			$search->queryContains($_GET['search'],$selectors,$search_fields, "venues", array("tournaments.venueID" => "venues.id"));
		
		if(empty($search->error))
		{

			$this->Page->setSection( $this->Page->Title, $search->getHTML("tournaments") );
		}else
			$this->Page->setSection( $this->Page->Title, "ERROR: " . $search->error );
	}
	
	private function _handlePages()
	{
		$search = new Search ( $this->_field );
		
		$selectors = array("id", "title", "created_by", "description", "type", "online", "default");
		$search_fields = array("title", "created_by", "description", "type");
		
		$search->order_by = $this->_order_by;
		$search->order = $this->_order;
		
		if(!isset($_GET['search']))
			$search->query($selectors);
		else
			$search->queryContains($_GET['search'],$selectors,$search_fields);
		
		if(empty($search->error))
		{

			$this->Page->setSection( $this->Page->Title, $search->getHTML("pages") );
		}else
			$this->Page->setSection( $this->Page->Title, "ERROR: " . $search->error );
	}
	
	private function _handleGalleryAlbums()
	{
		$search = new Search ( $this->_field );
		
		$selectors = array("id", "album_title", "created_by", "album_description");
		$search_fields = array("album_title", "created_by", "album_description");
		
		$search->order_by = $this->_order_by;
		$search->order = $this->_order;
		
		if(!isset($_GET['search']))
			$search->query($selectors);
		else
			$search->queryContains($_GET['search'],$selectors,$search_fields);
		
		if(empty($search->error))
		{

			$this->Page->setSection( $this->Page->Title, $search->getHTML("gallery", "_albums") );
		}else
			$this->Page->setSection( $this->Page->Title, "ERROR: " . $search->error );
	}
	
	private function _handleGalleryPhotos()
	{
		$search = new Search ( $this->_field );
		
		$selectors = array("gallery_albums.id", "gallery_photos.id", "gallery_albums.album_title", "gallery_photos.photo_title", "gallery_photos.created_by", "gallery_photos.photo_description", "gallery_photos.date_created", "gallery_photos.photo_name", "gallery_photos.album_id", "gallery_photos.type");
		$search_fields = array("gallery_photos.photo_title", "gallery_photos.created_by", "gallery_photos.photo_description", "gallery_albums.album_title");
		
		$search->order_by = $this->_order_by;
		$search->order = $this->_order;
		
		if(!isset($_GET['search']))
			$search->query($selectors, null, "gallery_albums", array("gallery_photos.album_id" => "gallery_albums.id"));
		else
			$search->queryContains($_GET['search'],$selectors,$search_fields, "gallery_albums", array("gallery_photos.album_id" => "gallery_albums.id"));
		
		if(empty($search->error))
		{
			$search->addDataRow("img");
			$this->Page->setSection( $this->Page->Title, $search->getHTML("gallery", "_photos") );
		}else
			$this->Page->setSection( $this->Page->Title, "ERROR: " . $search->error );
	}

}