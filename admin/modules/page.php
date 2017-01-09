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
		$page = isset( $_GET['cat'] ) ? $_GET['cat'] : ADMIN_HOME_PAGE;
		$this->DEBUG[] = "Page \"" . $page . "\" Initializing...";
		$this->Name = ucfirst(htmlspecialchars($page));
		$this->Title = str_replace("_", " ", $this->Name);

		// Get Page Handlers.
		if(!$this->_getHandlers())
		{
			$this->DEBUG[] = "Page Handlers Were Not Set!";
			$Core->DEBUG[] = $this->DEBUG;
			return false;
		}
		else
			$this->DEBUG[] = "Page Handlers Successfully Set.";
			
		
		$Core->DEBUG[] = $this->DEBUG;
		$Core->DEBUG[] = $this->_Handlers->DEBUG;
		
		return true;
		
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

		$this->_Handlers->FireAllPresets();
		
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
	
	public function setLoginSection()
	{
		$this->setSection( "Restricted", Login::loginSection() );
		$this->setAlert( "Oh No!", "You must be an Administrator to view this content!", 2);
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
	
	public static function getAllPublicPages()
	{
		$db = Database::getInstance();
		$SQL = $db->getConnection();
		
		$q_str = "SELECT id, title, user_restriction FROM `pages` WHERE user_restriction = '0' ORDER BY title ASC";
		$query = $SQL->query($q_str);
		if($query->num_rows > 0)
		{
			$arr = array();
			while($results = $query->fetch_assoc())
				$arr[$results['id']] = $results['title'];
			return $arr;
		}
		else
			return 0;
	}
				

}

?>