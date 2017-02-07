<?PHP

class Announcements_Handler extends Page_Handler
{

	public $DEBUG;
	
	function __construct()
	{
		$Template = Template::getInstance();
		$Template->loadSkin('announcements');
	}
	
	public function PostHandler()
	{

	}
	
	public function GetHandler()
	{
		
		if( isset( $_GET['id'] ) )
			$this->_getTournamentQueriesSection();
	}	
	
	public function SectionHandler()
	{
		$Page = Page::getInstance();
		$Template = Template::getInstance();
		
		$latest = Announcement::getLatest(5);
		foreach($latest as $val)
		{
			$announcement[] = new Announcement($val);
		}
		
		if(empty($announcement))
			$html = $Template->Skin['announcements']->no_announcements();
		else
		{
			$html = "";
			foreach($announcement as $val)
			{
				$html .= $Template->Skin['announcements']->announcement_table($val->getData());
			}
		}
	
		$Page->setSection( $Page->Title, $html );
	}

}