<?PHP

class Logs_Handler extends Page_Handler
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
	
		$Page->setSection( $Page->Name . " - Logs", $this->_handleLogs() );
		
	}
	
	private function _handleLogs()
	{
		return "Handle Logs";
	}
	
}

?>