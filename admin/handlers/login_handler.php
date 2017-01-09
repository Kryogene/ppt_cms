<?PHP

class Login_Handler extends Page_Handler
{
	
	function __construct()
	{
		
	}
	
	public function PostHandler()
	{
	
		if( isset( $_POST['submit_login'] ) )
			$this->_handleLogin();
	
	}
	
	public function GetHandler()
	{
	
		if( isset( $_GET['logout'] ) )
			$this->_handleLogout();
	
	}
	
	private function _handleLogin()
	{
		$Page = Page::getInstance();
		try
		{
			Login::doLogin();
		}
		catch(Exception $e)
		{
			$Page->setAlert( "Oh No!", $e->getMessage(), 2 );
			return;
		}
		
		$Page->setAlert("Logged In!", "You logged in successfully! Go you!");
		
	}
	
	private function _handleLogout()
	{
	
		$Page = Page::getInstance();
		
		Login::doLogout();
		$Page->setAlert("Logged Out!", "You logged out successfully! Go you!");
		
	}
	
	public function SectionHandler()
	{
	
		$Page = Page::getInstance();
	
		$Page->setSection( $Page->Title, Login::loginSection() );
		
	}
	
}

?>