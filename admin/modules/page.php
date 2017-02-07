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
	protected static $_Types = array(	"hidden" ,
								"text",
								"text",
								array("textarea", "small"),
								"text",
								"checkbox",
								"checkbox",
								"textarea"
							);
	
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
		if(isset($_GET['login']) || isset($_GET['logout'])) $page = "login";
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
	
	/*-------------------------------
	// This function allows to grab page meta data statically
	-------------------------------*/
	
	public static function getData($id)
	{
		$db = Database::getInstance();
		$SQL = $db->getConnection();
		$Template = Template::getInstance();
		
		$q_str = "SELECT `id`, `name`, `title`, `description`, `type`, `default`, `online`, `page_default_content` FROM `pages` WHERE `id` = {$id}";
		$query = $SQL->query($q_str);
		if($query->num_rows > 0)
		{
			$results = $query->fetch_assoc();
			foreach($results as $k => $v)
			{
				$results[$k] = htmlspecialchars_decode($v);
			}
			return $Template->convertToForm($results, self::$_Types);
		}
		else
			return 0;
		
	}

				
	/*-------------------------------
	// Below here is the admin controls
	-------------------------------*/
	
	public static function create($p_name, $p_title, $p_desc, $p_type, $p_default, $p_online, $p_content)
	{
		$db = Database::getInstance();
		$SQL = $db->getConnection();
		
		if(empty(trim($p_name)) || empty(trim($p_title)) || empty(trim($p_type)))
			return 0;

		$p_content = (empty(trim($p_content)) ? "Page has no content!" : $p_content);
		
		$user = CMS_Core::getInstance()->User->fullName;
    $time = time();
    $p_name = addslashes(htmlspecialchars($p_name));
    $p_title = addslashes(htmlspecialchars($p_title));
		$p_desc = addslashes(htmlspecialchars($p_desc));
		$p_type = addslashes(htmlspecialchars($p_type));
		$p_content = addslashes(htmlspecialchars($p_content));
		
		$q_str = "INSERT INTO `pages` (`default`, name, online, user_restriction, title, description, type, clock, calendar, page_default_content, date_created, created_by) VALUES 
																	('{$p_default}', '{$p_name}', '{$p_online}', 0, '{$p_title}', '{$p_desc}', '{$p_type}', 0, 0, '{$p_content}', $time, '{$user}')";
    $SQL->query($q_str) or die($SQL->error);
    return 1;
	}
	
	public static function modify($p_id, $p_name, $p_title, $p_desc, $p_type, $p_default, $p_online, $p_content)
	{
		$db = Database::getInstance();
		$SQL = $db->getConnection();
		
		if(empty(trim($p_name)) || empty(trim($p_title)) || empty(trim($p_type)))
			return "You left some required fields empty!";

		$p_content = (empty(trim($p_content)) ? "Page has no content!" : $p_content);
		
		$user = CMS_Core::getInstance()->User->fullName;
    $time = time();
    $p_name = addslashes(htmlspecialchars($p_name));
    $p_title = addslashes(htmlspecialchars($p_title));
		$p_desc = addslashes(htmlspecialchars($p_desc));
		$p_type = addslashes(htmlspecialchars($p_type));
		$p_content = addslashes(htmlspecialchars($p_content));
		
		if($p_default == 1)
			self::_unsetDefaultPage();
		else
		{
			if(!self::_checkDefault($p_id))
			{
				return "There must be a default page! If you wish to make another page the default just check the Default box while modifying or creating it!";
			}
		}
		
		$q_str = "UPDATE `pages` SET `default` = '{$p_default}', 
																	`name` = '{$p_name}',  
																	`online` = '{$p_online}',  
																	`title` = '{$p_title}',  
																	`description` = '{$p_desc}',  
																	`type` = '{$p_type}',  
																	`page_default_content` = '{$p_content}',  
																	`date_last_edited` = '{$time}', 
																	`edited_by` = '{$user}' WHERE `id` = '{$p_id}'";
		$SQL->query($q_str) or die($SQL->error);
    return 1;
	}
	
	private static function _unsetDefaultPage()
	{
		$db = Database::getInstance();
		$SQL = $db->getConnection();
		
		$q_str = "UPDATE `pages` SET `default` = '0' WHERE `default` = '1'";
		@$SQL->query($q_str);
	}
	
	private static function _checkDefault($p_id)
	{
		$db = Database::getInstance();
		$SQL = $db->getConnection();

		$q_str = "SELECT `default` FROM `pages` WHERE `default` = '1' AND NOT `id` = '{$p_id}'";
		$query = $SQL->query($q_str);
		if($query->num_rows == 0)
			return 0;
		return 1;
	}
	
}

?>