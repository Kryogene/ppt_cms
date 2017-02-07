<?PHP

class Register_Handler extends Page_Handler
{
	
	function __construct()
	{
		
	}
	
	public function PostHandler()
	{
	
		if( isset( $_POST['submit_registration'] ) )
			$this->_handleRegistration();
	
	}
	
	public function GetHandler()
	{
	
	}
	
	private function _handleRegistration()
	{
		$Page = Page::getInstance();
		try
		{
			Register::doRegister();
		}
		catch(Exception $e)
		{
			$Page->setAlert( "Oh No!", $e->getMessage(), 2 );
			$this->SectionHandler();
			return;
		}
		
		$Page->setAlert("Registered!", "Your registration has been successfully sent!");
		try
		{
			$_POST['submit_login'] = TRUE;
			Login::doLogin();
		}
		catch(Exception $e)
		{
			$Page->setAlert( "Oh No!", $e->getMessage(), 2 );
			$Page->setSection( $Page->Title, Login::loginSection() );
			return;
		}
		
		$Page->setSection( $Page->Title, Login::loggedInMsg());
		
	}
	
	public function SectionHandler()
	{
	
		$Page = Page::getInstance();
	
		$Page->setSection( $Page->Title, Login::registrationSection() );
		
	}
	
}

?>