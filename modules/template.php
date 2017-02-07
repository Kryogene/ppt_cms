<?PHP

class Template
{
	
	private $_Data;
	public $DEBUG;
	
	protected $id;
	protected $skin_name;
	protected $name;
	protected $default;
	
	public $Skin;
	
	private static $_instance;
	
	public static function getInstance() {
		if(!self::$_instance) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	public function __construct()
	{

		$Core = CMS_Core::getInstance();
		$this->DEBUG[] = "Templates Initializing...";

		$this->id = (isset($Core->User->Settings['template_id'])) ? $Core->User->Settings['template_id'] : Template::defaultTemplate();
		
		$this->_setCookies($this->id);
		
		$this->_getData();
		
		$this->_loadDefaultSkins();
		
		$Core->DEBUG[] = $this->DEBUG;
	}
	
	protected function _loadDefaultSkins()
	{
	
		$this->loadSkin( "globals" );
		$this->loadSkin( "alerts" );
		$this->loadSkin("login");
		$this->loadSkin("users");
		$this->loadSkin("search");
		//$this->loadSkin("registration");
		
	}
	
	protected function _setCookies($t_id = 0)
	{
	
		if($t_id == 0) $t_id = Template::defaultTemplate();
		
		$this->DEBUG[] = "Creating Template Cookie(s)...";

      setcookie("template_id", $t_id, time() + (3600 * 72), '/');
      $_COOKIE['template_id'] = $t_id;
			$this->id = $t_id;
		
		$this->DEBUG[] = "Cookies Created!";

	}
	
	protected function _getData()
	{
		$db = Database::getInstance();
		$SQL = $db->getConnection();
		
		$Core = CMS_Core::getInstance();

		$this->DEBUG[] = "Retrieving Template Data...";
	
		$query = $SQL->query("SELECT * FROM `templates` WHERE `id` = '" . $this->id . "'");
		
		if($query->num_rows > 0)
		{
			$this->_Data = $query->fetch_assoc();
			$this->DEBUG[] = "Template ID " . $this->id . " Successfully Loaded!";
		}
		else
		{
			$this->DEBUG[] = "Template ID " . $this->id . " Failed!";
			$this->DEBUG[] = "Loading Default Template ID " . $this->Core->Settings['defaultTemplate'] . "...";
			$query = $SQL->query("SELECT * FROM `templates` WHERE `id` = '" . $Core->Settings['defaultTemplate'] . "'");
			$this->_Data = $query->fetch_assoc();
			$this->ID = $this->_Data['id'];
			$this->DEBUG[] = "Template ID " . $this->ID . " Successfully Loaded!";
		}
		
	}
	
	public function getStyleSheet()
	{
		return TEMPLATES_DIR . $this->_Data['directory'] . $this->_Data['stylesheet'];
	}
	
	public function loadSkin($suffix)
	{
	
		$this->DEBUG[] = "Retrieving Skin \"{$suffix}\"...";
		
		$files = scandir( TEMPLATES_DIR . $this->_Data['directory'] );
		unset($files[0]);
		unset($files[1]);
		$files = array_values($files);
		if($this->searchSkin($suffix, $files))
		{
		
			$this->DEBUG[] = "Search For \"{$suffix}\" Found!";
			
			$page = SKIN_PREFIX . $suffix . FILE_EXT;
		
			if(!include_once ( TEMPLATES_DIR . $this->_Data['directory'] . $page ))
			{
				throw new Template_Exception( $suffix, Template_Exception::INCLUDE_SKIN_EXCEPTION_CODE );
			}
			
			$this->DEBUG[] = "\"" . $page . "\" Successfully Included!";
			
			$skinObj = SKIN_PREFIX . $suffix;
			if(isset($this->Skin[$suffix])) unset($this->Skin[$suffix]); 
			$this->Skin[$suffix] = new $skinObj;
			$this->DEBUG[] = "\"" . $suffix . "\" Added To Skin List.";
		}
		else
		{
				throw new Template_Exception( $suffix, Template_Exception::SEARCH_SKIN_EXCEPTION_CODE );
		}
		
	}
	
	public function searchSkin($name, $files)
	{
		foreach($files as $file)
		{
			$destruct = explode(".", $file);
			if($destruct[1] != "css")
			{
				$skin = explode( SKIN_PREFIX , $destruct[0] );
				if( strtolower($skin[1]) == strtolower($name) )
				{
					return TRUE;
				}
			}
		}
		return FALSE;
	}
	
	public function getNavigationElements()
	{
	
		$Core = CMS_Core::getInstance();
		$elementOne = "";
		$elementTwo = "";
		//Element One
		if( $Core->User->getID() == 0 )
		{
			
			$elementOne = $this->Skin['login']->loginNavigationForm();
		//Element Two
		$elementTwo = $this->Skin['globals']->socialLinksWithIcons($Core->Settings);
		}
		else
		{
		
			$elementOne .= $this->Skin['users']->navigationWelcome( $Core->User->getFullName() );
			$elementTwo .= $this->Skin['login']->navigationLogoutLink();
			$elementTwo .= $this->Skin['users']->navigationSettingsIcon();
			$elementTwo .= $this->Skin['users']->navigationUserPanelIcon();
			$elementTwo .= $this->Skin['users']->navigationMailIcon();
			$elementTwo .= $this->Skin['users']->navigationStatisticsIcon();
					
			if( is_a( $Core->User, "Administrator" ) )
				$elementTwo .= $this->Skin['users']->navigationAdminIcon();
			
			$elementTwo = $this->Skin['globals']->navigationRight($elementTwo);
				
		}
		
		$elementHTML = $elementOne . " " . $elementTwo;
		
		return $elementHTML;
		
	}
	
	public function wrapAlertData( $alert )
	{
	
		switch( $alert['type'] )
		{
			case 0;
				return $this->Skin['alerts']->Success( $alert['title'], $alert['content'] );
			case 1:
				return $this->Skin['alerts']->Warning( $alert['title'], $alert['content'] );
			case 2:
				return $this->Skin['alerts']->Error( $alert['title'], $alert['content'] );
			default:
				return false;
		}
			
	}

	public function getDayOptions( $selection )
	{
		$html = "";
		$Core = CMS_Core::getInstance();
		foreach($Core->Day as $k => $v)
		{
			if($k == $selection)
				$html .= $this->Skin['search']->selectOption( $v, $k, "selected" );
			else
				$html .= $this->Skin['search']->selectOption( $v, $k );
		}
		return $html;
	}
	
	public function getMonthOptions( $selection )
	{
		$html = "";
		$Core = CMS_Core::getInstance();
		foreach($Core->Month as $k => $v)
		{
			if($k == $selection)
				$html .= $this->Skin['search']->selectOption( $v, $k, "selected" );
			else
				$html .= $this->Skin['search']->selectOption( $v, $k );
		}
		return $html;
	}
	
	public function getOrderOptions( $selection )
	{
		$html = "";

		if("asc" == strtolower($selection))
		{
			$html .= $this->Skin['search']->selectOption( "ASC", "ASC", "selected" );
			$html .= $this->Skin['search']->selectOption( "DESC", "DESC" );
		}
		else
		{
			$html .= $this->Skin['search']->selectOption( "ASC", "ASC" );
			$html .= $this->Skin['search']->selectOption( "DESC", "DESC", "selected" );
		}
		return $html;
	}
	
	public function convertToForm( $data, $types)
	{
		$db = Database::getInstance();
		$SQL = $db->getConnection();
		$builder = new FormBuilder( $this, $SQL );
		return $builder->buildByType($data, $types);
	}
	
	public static function isTemplate($t_id)
	{
		$db = Database::getInstance();
		$SQL = $db->getConnection();
		
		$q_str = "SELECT `id` FROM `templates` WHERE `id` = '" . $SQL->real_escape_string($t_id) . "'";
		$query = $SQL->query($q_str);
		if($query->num_rows > 0)
			return TRUE;
		else
			return FALSE;
	}
			
	public static function getAllTemplates()
	{
		$db = Database::getInstance();
		$SQL = $db->getConnection();
		
		$q_str = "SELECT id, name FROM `templates` ORDER BY name ASC";
		$query = $SQL->query($q_str);
		if($query->num_rows > 0)
		{
			$arr = array();
			while($results = $query->fetch_assoc())
				$arr[$results['id']] = $results['name'];
			return $arr;
		}
		else
			return 0;
	}
	
	public static function defaultTemplate()
	{
		$db = Database::getInstance();
		$SQL = $db->getConnection();
		
		$q_str = "SELECT `id` FROM `templates` WHERE `default` = '1'";
		$query = $SQL->query($q_str);
		if($query->num_rows > 0)
		{
			$result = $query->fetch_row();
			return $result[0];
		}
		else
			return 1;
	}
	
	public function changeTemplate($t_id)
	{
		$Core = CMS_Core::getInstance();
		
		$this->_setCookies($t_id);
				
		header( "Location: " . $Core->Settings['defaultURL'] . "/index.php?" . http_build_query($_GET) );
	}
	
}

?>