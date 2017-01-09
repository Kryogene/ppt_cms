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
	
	public function SectionHandler()
	{
	
		$Page = Page::getInstance();
	
		$Page->setSection( $Page->Title, $Page->getDefaultOutput() );
		
	}
	
	public function FireAllPresets()
	{
		$this->SectionHandler();
		$this->PostHandler();
		$this->GetHandler();
	}
	
	public function Restricted()
	{
		return FALSE;
	}

}