<?PHP

class SettingsEditor
{
	
	private $app;
	
	public function __construct( $app_type = null )
	{
		Template::getInstance()->loadSkin("settings");
		switch($app_type)
		{
			default:
				$this->app = new MainSettingsEditor();
			break;	
		}
		$this->app->query();
	}
	
	public function output()
	{
		return Template::getInstance()->Skin['settings']->settingsTable($this->app->getFormData());
	}
	
	public function editor()
	{
		return $this->app;
	}
	
}

?>