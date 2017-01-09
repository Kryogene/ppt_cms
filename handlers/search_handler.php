<?PHP

class Page_Handler
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
		$Core = Core::getInstance();
		if($Page->Restricted == 1 && isset($Core->User->restricted))
			return 1;
		else
			return 0;
	}
	
	public function SectionHandler()
	{
	
		$Page = Page::getInstance();
	
		$Page->setSection( $Page->Title, $Page->getDefaultOutput() );
		
	}

}