<?PHP

class Core
{

	/* Printable Loaders */
	public $HTML = "";
	public $DEBUG = "";
	
	public $ErrorCode;
	public $Error;
	
	// Create Global Variable variables.
	public $Globals, $Get, $Post, $Cookie;
	
	// Create Database variable.
	public $SQL;
	
	// Create view global variable.
	public $Viewer;
	
	// Site Settings variable.
	public $Settings;

	function __construct()
	{

		$this->DEBUG[] = "Debug Console Initialized!";
		
		$this->initializeGlobals();
		
		$this->getViewer();
		$this->createCookies();
		
		//require_once ( "config.php" );
		
		// Connect to teh data-bass bout that bass, no treble...
		if( !$this->dbConnect() )
			die( "<p>Error Code: " . $this->ErrorCode .
					"<p>" . $this->Error . "</p></p>"
				);
				
		// Get Settings
		if( !$this->getSettings() )
			die();
		$this->DEBUG[] = "Settings Received!";
		
	}
	
	public function initializeGlobals()
	{
	
		$this->DEBUG[] = "Initializing Globals...";
	
		$this->Get = $_GET;
		$this->Post = $_POST;
		$this->Cookie = $_COOKIE;
		
		$this->DEBUG[] = "Globals Initialized!";
		
	}
	
	public function debugDump($obj)
	{
		echo "<p><code><pre>";
		print_r ( $obj );
		echo "</pre></code></p>";
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
	
	public function createCookies()
	{
	
		$this->DEBUG[] = "Creating Cookies...";
	
		if( !isset($this->Cookie['template_id']) ) {
            setcookie("template_id", 1, time() + (3600 * 72));
            $this->Cookie['template_id'] = 1;
        }
		
		session_start();
		
		$this->DEBUG[] = "Cookies Created!";

	}
	
	public function getSettings()
	{
		
		$this->DEBUG[] = "Retrieving Settings...";
		
		if(!$query = $this->SQL->query("SELECT * FROM `settings`"))
			return false;
		
		$this->Settings = $query->fetch_assoc();
		return true;
	}
	
	private function dbConnect()
	{
		$this->SQL = new mysqli('localhost', 'root', 'root', 'cms');
		
		if( $this->SQL->connect_errno > 0 )
		{
			$this->ErrorCode = 0;
			$this->Error = "Unable to connect to database.";
			return false;
		}
		return true;
	}
				
}