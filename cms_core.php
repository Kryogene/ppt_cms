<?PHP

class CMS_Core
{

	/* Printable Loaders */
	private $_HTML = "";
	public $DEBUG = "";
	
	public $User;
	
	// Create view global variable.
	public $Viewer;
	
	// Site Settings variable.
	public $Settings;
	
	public $Day = array( 1 => 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday' );
	public $Month = array( 1 => 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December' );
	
	private static $_instance;
	
	public static function getInstance() {
		if(!self::$_instance) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	function __construct()
	{

		$this->DEBUG[] = "Debug Console Initialized!";
		
		$this->getViewer();
		
		//require_once ( "config.php" );
				
		// Get Settings
		if( !$this->getSettings() )
			die();
		$this->DEBUG[] = "Settings Recieved!";
	}
	
	public function getLoginUser()
	{
		$this->User = Login::checkLoginAndGetUser();
		$this->DEBUG[] = "User Established!";
	}
	
	public function getUserNameByID( $id )
	{
		$db = Database::getInstance();
		$SQL = $db->getConnection();
		
		$query = $SQL->query("SELECT `lastName`, `firstName` FROM `players` WHERE `id` = '" . $SQL->escape_string( $id ) . "'");
		if($query)
			if($query->num_rows > 0)
			{
				$results = $query->fetch_assoc();
				return $results['lastName'] . ", " . $results['firstName'];
			}
		else
			return 0;
	}
	
	public function debugDump($obj)
	{
		echo <<<HTML
<div class='debugMenu'>

	<div class="titleBar"><img  src='images/templates/default/icons/debug.png'> Debug Menu</div>

	<div class="debugCode">
		<code>
			<pre>
HTML;
		print_r ( $obj );
		echo <<<HTML
			</pre>
		</code>
	</div>
</div>
HTML;
	}
	
	public function getViewer()
	{
	
		$this->DEBUG[] = "Retrieving Viewer Information...";
	
		$this->Viewer['IP'] = $_SERVER['REMOTE_ADDR'];
		$this->Viewer['Agent'] = $_SERVER['HTTP_USER_AGENT'];
        $this->Viewer['Browser'] = $this->getBrowser($this->Viewer['Agent']);
		$this->Viewer['Referer'] = ( !isset( $_SERVER['HTTP_REFERER'] ) ) ? '' : $_SERVER['HTTP_REFERER'];
		
		$this->DEBUG[] = "Viewer Information Retrieved!";
		
	}
	
	public function getBrowser($Agent)
    {
	
		$this->DEBUG[] = "Retrieving Browser...";
	
        $browser = array(
                        "Opera"      =>  "Opera",
                        "Chrome"    =>  "Chrome",
                        "Firefox"   =>  "Firefox"
        );

        foreach($browser as $key => $value)
        {
            $bool = explode($key, $Agent);
            if(isset($bool[1]))
            {
                return $value;
            }
        }

        return "Other";
    }
	
	private function getSettings()
	{
		$db = Database::getInstance();
		$SQL = $db->getConnection();
		
		$this->DEBUG[] = "Retrieving Settings...";
		
		if(!$query = $SQL->query("SELECT * FROM `settings`"))
			return false;
		
		$this->Settings = $query->fetch_assoc();
		date_default_timezone_set($this->Settings['defaultTimeZone']);
		return true;
	}
	
	private function _build()
	{
		$Template = Template::getInstance();
		$Page = Page::getInstance();
		
		$this->DEBUG[] = "Building Site...";
	
		$header = $this->_setHeader();
		$this->_HTML = $Template->Skin['globals']->Header($header);
		
		$body = $Template->Skin['globals']->bodyNav( $Template->getNavigationElements() );
		
		$body .= $Template->Skin['globals']->bodyHeader();
		
		$this->User->retrieveStatistics();

		$section = $Page->getSection();
		$alert = ($Page->isAlert()) ? $Template->wrapAlertData( $Page->getAlert() ) : "";
		$body .= $Template->Skin['globals']->bodyMain( $section, "", $alert);
			
		$body .= $Template->Skin['globals']->bodyFooter();
		
		$this->_HTML .= $Template->Skin['globals']->Shell($body);
		
		$this->_HTML .= $Template->Skin['globals']->Footer();
		
		$this->DEBUG[] = "Site Successfully Built!";
		
	}
	
	private function _setHeader()
	{
		$Template = Template::getInstance();
		$Page = Page::getInstance();
	
		$this->DEBUG[] = "Setting Header Elements...";
		
		$header = $Template->Skin['globals']->Title( $this->Settings['siteTitle'] . " > " . $Page->Title ) . "\n";
		
		$header .= $Template->Skin['globals']->Link( "icon", "image/ico", "/favicon.ico") . "\n";
		
		$header .= $Template->Skin['globals']->MetaCharSet( $this->Settings['charSet'] ) . "\n";
		
		$header .= $Template->Skin['globals']->MetaHttpEquiv("X-UA-Compatible", "IE=9") . "\n";
		
		$header .= $Template->Skin['globals']->MetaProperty("og:site_name", $this->Settings['siteTitle']) . "\n";
		$header .= $Template->Skin['globals']->MetaProperty("og:title", $Page->Title) . "\n";
		$header .= $Template->Skin['globals']->MetaProperty("og:description", $Page->Description) . "\n";
		$header .= $Template->Skin['globals']->MetaProperty("og:type", $Page->Type) . "\n";
		$header .= $Template->Skin['globals']->MetaProperty("og:url", $this->Settings['defaultURL']) . "\n";
		$header .= $Template->Skin['globals']->MetaProperty("og:image",$Page->Image) . "\n";
		$header .= $Template->Skin['globals']->jQuery() . "\n";
		$header .= $Template->Skin['globals']->Link("stylesheet", "text/css", "default.css") . "\n";
		
		$this->DEBUG[] = "Header Elements Set Successfully!";
		
		return $header;
	
	}
	
	public function output()
	{

		$this->_build();
		print $this->_HTML;
	}
	
	public function error_output($e)
	{
		$this->_build_with_error($e);
		print $this->_HTML;
	}
				
	private function _build_with_error($e)
	{
	
		$Template = Template::getInstance();
		
		$this->DEBUG[] = "Building Site With Error...";
	
		$header = $this->_setErrorHeader();

		$this->_HTML = $Template->Skin['globals']->Header($header);
		
		$body = $Template->Skin['globals']->bodyNav( array("Element 1 Array 1", "Element 1 Array  2"), array("Element 2 Array 1", "Element 2 Array 2") );
		$body .= $Template->Skin['globals']->bodyHeader();

		$body .= $Template->Skin['alerts']->Error($e->errorMessage());
			
		$body .= $Template->Skin['globals']->bodyFooter();
		
		$this->_HTML .= $Template->Skin['globals']->Shell($body);
		
		$this->_HTML .= $Template->Skin['globals']->Footer();
		
		$this->DEBUG[] = "Site Successfully Built!";
		
	}
	
	private function _setErrorHeader()
	{
		$Template = Template::getInstance();
	
		$this->DEBUG[] = "Setting Header Elements...";
		
		$header = $Template->Skin['globals']->Title( $this->Settings['siteTitle'] . " > Error!" ) . "\n";
		
		$header .= $Template->Skin['globals']->Link( "icon", "image/ico", "/favicon.ico") . "\n";
		
		$header .= $Template->Skin['globals']->MetaCharSet( $this->Settings['charSet'] ) . "\n";
		
		$header .= $Template->Skin['globals']->MetaHttpEquiv("X-UA-Compatible", "IE=9") . "\n";

		$header .= $Template->Skin['globals']->jQuery() . "\n";
		
		$header .= $Template->Skin['globals']->Link("stylesheet", "text/css", "default.css") . "\n";
		
		$this->DEBUG[] = "Header Elements Set Successfully!";
		
		return $header;
	
	}
				
	public function getDay( $string )
	{
		foreach ( $this->Day as $key => $value )
			if( strtolower( $string ) == strtolower( $value ) ) return $key;
			
		return 0;
	}
	public function getMonth( $string )
	{
		foreach ( $this->Month as $key => $value )
			if( strtolower( $string ) == strtolower( $value ) ) return $key;
			
		return 0;
	}
				
}