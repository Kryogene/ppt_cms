<?PHP

error_reporting( E_ALL );

class Init
{

	private $_Core, $_Template, $_Page;
	public $Mode;
	
	public $DEBUG;

	function __construct()
	{
		if( isset( $_GET['debugMode'] ) )
			$this->Mode = 9;
		else
			$this->Mode = 0;
			
		if( isset( $_GET['showAll'] ) )
			$this->Mode = 99;
		
	}

	function init()
	{

		/*
		* Create the Core Instance and then grab the user.
		*/
		$this->_Core = CMS_Core::getInstance();
		
		$this->_Core->checkSSL();
		
		$this->_Core->getLoginUser();
		/*
		* Get the Page Instance or produce caught error.
		*/
		try
		{
			$this->_Page = Page::getInstance();
		}
		catch(Page_Exception $e)
		{
			$this->_Core->DEBUG[] = $e->errorMessage();
			echo $e->getMessage();
		}

		/*
		* Now let's fire off the pages preset handlers.
		*/

		$this->_Page->run();

		/*
		* Get  the Template Instance or produce caught error.
		*/
		try
		{
			$this->_Template = Template::getInstance();
		}
		catch(Template_Exception $e)
		{
			$this->_Core->DEBUG[] = $e->errorMessage();
			echo $e->getMessage();
		}

		if( $this->Mode == 0 || $this->Mode == 99 )
		{
			try
			{
				if($this->_Core->Settings['online'] || (!$this->_Core->Settings['online'] && (User::isUserType($this->_Core->User->id) == 1)))
					$this->_Core->output();
				else
					$this->_Core->offline();
			}
			catch(Exception $e)
			{
				$this->_Core->error_output($e);
			}
		}
		
		if( $this->Mode == 9 || $this->Mode == 99 )
		{
		
			switch( $_GET['debugMode'] )
			{
				Case 1:
					$this->DEBUG  = $this->_Core;
				break;
				Case 2:
						$this->DEBUG  = $this->_Template;
				break;
				Case 3:
						$this->DEBUG  = $this->_Page;
				break;
				Case 10:
					$this->DEBUG = $this->_Core->User;
				default:
					$this->DEBUG = $this;
				break;
			}
			if(!isset($_GET['obj'])) $this->DEBUG = $this->DEBUG->DEBUG;
			$this->_Core->debugDump($this->DEBUG);
		}
		
	}
	
}