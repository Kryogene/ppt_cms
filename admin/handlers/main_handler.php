<?PHP

class Main_Handler extends Page_Handler
{
	
	public function PostHandler()
	{
	
	}
	
	public function GetHandler()
	{
		$Page = Page::getInstance();
		if(isset($_GET['settings']))
			$this->_handleSettings();
		elseif(isset($_GET['backup']))
			$this->_handleBackUp();
		elseif(isset($_GET['calendar']))
			$this->_handleCalendar();
		elseif(isset($_GET['adminlogs']))
			$this->_handleLogs();
	}
	
	public function SectionHandler()
	{
	
		$Page = Page::getInstance();
	
		$Page->setSection( $Page->Name, $this->_handleMain() );
		
	}
	
	private function _handleMain()
	{
		return "Handle Main";
	}
	
	private function _handleSettings()
	{
		$settings = new Settings_Handler();
		$settings->FireAllPresets();
	}
	
	private function _handleBackUp()
	{
		$backup = new Backup_Handler();
		$backup->FireAllPresets();
	}
	
	private function _handleCalendar()
	{
		$calendar = new Calendar_Handler();
		$calendar->FireAllPresets();
	}
	
	private function _handleLogs()
	{
		$logs = new Logs_Handler();
		$logs->FireAllPresets();
	}
	
}

?>