<?PHP

class Admin_Handler extends Page_Handler
{

	public $DEBUG;
	
	function __construct()
	{

	}
	
	public function PostHandler()
	{
		
	} 
	
	public function GetHandler()
	{
		
	}	
	
	public function Restricted()
	{
		$Page = Page::getInstance();
		$Core = CMS_Core::getInstance();
		if($Page->Restricted == 1 && isset($Core->User->restricted))
			return 1;
		if( $Page->Restricted == 2 && !is_a( $Core->User, "Administrator" ))
			return 1;
			
		return 0;
	}
	
	public function SectionHandler()
	{
	
		Header("Location: admin/index.php");
		
	}

}