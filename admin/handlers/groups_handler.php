<?PHP

class Groups_Handler extends Page_Handler
{

	public $DEBUG;
	
	function __construct()
	{
		Page::getInstance()->Title .= " - Groups";
	}
	
	public function PostHandler()
	{
		
	}
	
	public function GetHandler()
	{
		
	}	
	
	public function SectionHandler()
	{
	
		$Page = Page::getInstance();
	
		$Page->setSection( $Page->Title, "User Groups" );
		
	}

}