<?PHP
/*
	ERROR CODES
	1 - Get Data Error.
	2 - Handler Retrieval
*/

class Page
{
	
	public $ID;
	public $Name;
	public $Status;
	public $Restricted;
	public $Title;
	public $Description;
	public $Type;
	public $Image;
	public $Stylesheet;
	
	protected $_Section;
	protected $_Alerts;
	protected $_Widgets;
	
	protected $_Handlers;
	
	protected $_Data;
	protected $_SubPages;
	
	private static $_instance;
	
	public static function getInstance() {
		if(!self::$_instance) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	function __construct()
	{

		$Core = CMS_Core::getInstance();
	
		// If Global Query p is set then set 'page' to value; else set value to 0.
		$page = isset( $_GET['p'] ) ? $_GET['p'] : $this->getPageNameByID($Core->Settings['defaultPage']);
		$this->DEBUG[] = "Page \"" . $page . "\" Initializing...";
		// Get Page Settings.
		if(!$this->_getData(htmlspecialchars($page))) 
		{
			//$this->DEBUG[] = "Page Data Was Not Successfully Set!";
			$Core->DEBUG[] = $this->DEBUG;
			throw new Page_Exception( "", Page_Exception::GET_DATA_EXCEPTION_CODE);
			return false;
		}
		else
			$this->DEBUG[] = "Page Data Successfully Set.";

		// Get Page Handlers.
		if(!$this->_getHandlers())
		{
			$this->DEBUG[] = "Page Handlers Were Not Set!";
			$Core->DEBUG[] = $this->DEBUG;
			return false;
		}
		else
			$this->DEBUG[] = "Page Handlers Successfully Set.";
			
		$this->updateStatus();

		$this->_SubPages = $this->_getSubPageData( $this->_Data['id'], 'parent_id', '`id`, `name`, `title`, `description`' );
		
		$Core->DEBUG[] = $this->DEBUG;
		$Core->DEBUG[] = $this->_Handlers->DEBUG;
		
		return true;
		
	}
	
	private function _getSubPageData( $parentID, $col, $selectors = "*" )
	{
	
		$results;
	
		$this->DEBUG[] = "Loading Sub Pages...";
	
		$db = Database::getInstance();
		$SQL = $db->getConnection();
		
		$query = $SQL->query("SELECT {$selectors}
															FROM `sub_pages`
															WHERE `{$col}` = '{$parentID}'
														");
									
		if($query->num_rows > 0)
		{
			$this->DEBUG[] = "Sub Pages Found And Loaded!";
			while( $result = $query->fetch_row() )
			{

				$results[] = $result;
				
			}
			return $results;
		}
		
		$this->DEBUG[] = "No Sub Pages Exist!";
		return null;
		
	}

	
	public function updateStatus()
	{
		if($this->_Data['online'])
			$this->DEBUG[] = "Status Online.";
		else
			$this->DEBUG[] = "Status Offline.";
			
		$this->Status = $this->_Data['online'];
	}
	
	protected function _getData($page)
	{
	
		$db = Database::getInstance();
		$SQL = $db->getConnection();
		$Core = CMS_Core::getInstance();

		$query = $SQL->query("SELECT * FROM `pages` WHERE `name` = '" . $page. "'");

		if($query->num_rows == 0)
		{
			header("Location: index.php?p=" . $Core->Settings['defaultPage'] );
		}
		
		$this->_Data = $query->fetch_assoc();

		$this->_setData();
		
		return true;
	}
	
	protected function _setData()
	{
		
		$this->Name = $this->_Data['name'];
		$this->ID = $this->_Data['id'];
		$this->Title = $this->_Data['title'];
		$this->Description = $this->_Data['description'];
		$this->Restricted = $this->_Data['user_restriction'];
		$this->Type = $this->_Data['type'];
		$this->Image = $this->_Data['image'];
		$this->Stylesheet = $this->_Data['stylesheet'];
	
	}		
	
	protected function _getHandlers()
	{

		$handlerObj = ucfirst($this->Name . HANDLER_EXT);
		
		if( !class_exists( $handlerObj ) )
		{

			$this->DEBUG[] = $handlerObj . " Does Not Exist!";
			$handlerObj = DEFAULT_PAGE_HANDLER_OBJECT;
		}

		try
		{
			$this->_Handlers = new $handlerObj;
		}
		catch(Exception $e)
		{
			$this->DEBUG[]  = $e->getMessage();
			return false;
		}

		return true;
	}
	
	public function firePresetHandlers()
	{

		if(!$this->_Handlers->Restricted())
		{
			$this->_Handlers->SectionHandler();
			$this->_Handlers->PostHandler();
			$this->_Handlers->GetHandler();
		}
		else
			$this->setRestrictedSection();
		
		$this->DEBUG[] = $this->_Handlers->DEBUG;
		
	}
	
	public function getSection()
	{
		return $this->_Section;
	}
	
	public function setSection( $title, $content )
	{
		$this->_Section['title'] = $title;
		$this->_Section['content'] = $content;
	}
	
	public function setRestrictedSection()
	{
	
		$Template = Template::getInstance();
		switch($this->Restricted)
		{
			case 2:
				$this->setSection( "Restricted", Login::loginSection() );
				$this->setAlert( "Oh No!", "This section is restricted for non-administrative users!", 2);
			break;
			default:
				$this->setSection( "Restricted", Login::registrationSection() );
				$this->setAlert( "Oh No!", "This is a users only section, you must register an account to continue!", 2);
			break;
		}
		
	}
	
	public function setAlert( $title, $content, $type = 0 )
	{
		//$alertID = ( !is_array( $this->_Alerts ) ? 0 : $this->_Alerts.length();
		$this->_Alerts['title'] = $title;
		$this->_Alerts['content'] = $content;
		$this->_Alerts['type'] = $type;
	}
	
	public function isAlert()
	{
		return (is_null($this->_Alerts) ? false : true );
	}
	
	public function getAlert()
	{
		return $this->_Alerts;
	}
		
	public function getDefaultOutput()
	{
		return $this->_Data['page_default_content'];
	}
	
	public function getSubPageInfo( $call )
	{
	
		foreach( $this->_SubPages as $page )
			if( isset( $page[$call] ) )
				return $page[$call];
			else
				return null;
				
	}
	
	public function getPageNameByID($id)
	{
		$db = Database::getInstance();
		$SQL = $db->getConnection();
		
		$q_str = "SELECT name FROM `pages` WHERE `id` = '{$id}'";
		$query = $SQL->query($q_str);
		$result = $query->fetch_row();
		$page = $result[0];
		return $page;
	}
				

}

?>