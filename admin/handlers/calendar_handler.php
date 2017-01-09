<?PHP

class Calendar_Handler extends Page_Handler
{
	
	public function PostHandler()
	{
	
	}
	
	public function GetHandler()
	{
	}
	
	public function SectionHandler()
	{
	
		$Page = Page::getInstance();
	
		$Page->setSection( $Page->Name . " - Calendar", $this->_handleCalendar() );
		
	}
	
	private function _handleCalendar()
	{
		return "Handle Calendar";
	}
	
}

?>