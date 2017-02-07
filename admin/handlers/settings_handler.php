<?PHP

class Settings_Handler extends Page_Handler
{
	
	private $settings;
	
	public function PostHandler()
	{
		if(isset($_POST['updateMainSettings']))
			$this->handleMainSettingsUpdate();
	}
	
	public function GetHandler()
	{
	
	}
	
	public function SectionHandler()
	{
	
		$Page = Page::getInstance();
		$Template = Template::getInstance();
		
		$this->settings = new SettingsEditor();
	
		$Page->setSection( $Page->Name . " - Settings", $this->_handleSettingsMain() );
		
	}
	
	private function _handleSettingsMain()
	{
		return $this->settings->output();
	}
	
	private function handleMainSettingsUpdate()
	{
		$Page = Page::getInstance();
		if($this->settings->editor()->update($_POST['siteTitle'],
												 $_POST['defaultTimeZone'],
												 $_POST['defaultTimestamp'],
												 $_POST['defaultURL'],
												 $_POST['charSet'],
												 $_POST['uploadDir'],
												 (isset($_POST['online']) ? 1 : 0),
												 (isset($_POST['debugMode']) ? 1 : 0),
												 $_POST['facebook'],
												 $_POST['twitter'],
												 $_POST['googlePlus'],
												 $_POST['youTube']))
		{
			$Page->setAlert("Success", "Site settings successfully updated!");
			$this->SectionHandler();
		}
		else
		{
			$Page->setAlert("Uh Oh!", "You left a required field empty!");
		}
	}
	
}

?>