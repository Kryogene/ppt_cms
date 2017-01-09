<?PHP

class Announcements_Handler extends Page_Handler
{
	
	private $_Page, $_Template;
	
	function __construct()
	{
    
	}
	
	public function PostHandler()
	{
		$this->DEBUG[] = "Firing Post Handlers...";
	
		if( isset( $_POST['submitSettings'] ) )
			$this->_handleUpdateSettings();
			
		if( isset( $_POST['postAnnouncement'] ) )
			$this->_handleCreateAnnouncement();
		if( isset( $_POST['modifyAnnouncement'] ) )
			$this->_handleModifyAnnouncement();
			
		$this->DEBUG[] = "Post Handlers Fired!";
	}
	
	public function GetHandler()
	{	
	
		$this->DEBUG[] = "Firing Get Handlers...";

		if( isset( $_GET['search'] ) )
			$this->_handleSearch();
		elseif( isset( $_GET['create'] ) )
			$this->_handleCreate();
		elseif( isset( $_GET['modify'] ) )
			$this->_handleModify();
		elseif( isset( $_GET['delete'] ) )
			$this->_handleDelete();
		
	}
	
	public function SectionHandler()
	{
		
		$this->_Page = Page::getInstance();
		$this->_Template = Template::getInstance();
    
    $this->_Template->loadSkin("announcements");
	
		$this->_Page->setSection( $this->_Page->Name . " - Main", $this->_handleAnnouncementsMain() );
		
	}
	
	private function _handleAnnouncementsMain()
	{
		return "Users Main";
	}
	
	private function _handleSearch()
	{
		$sh = new Search_Handler( "announcements" );
		$sh->fireAllPresets();
	}
	
	private function _handleCreate()
	{
		$this->_Page->setSection( $this->_Page->Name . " - Create", $this->_Template->Skin['announcements']->createTable() );
		
	}
	
	private function _handleModify()
	{
		if(!isset($_GET['id']) || !is_numeric($_GET['id'])) 
		{
			$this->SectionHandler();
			return;
		}
		$announcement = new Announcement($_GET['id']);
		$data = $announcement->getFormData();
		$this->_Page->setSection( $this->_Page->Name . " - Modify", $this->_Template->Skin['announcements']->modifyTable($data) );
		
	}
	
	private function _handleDelete()
	{
		if(!isset($_GET['id']) || !is_numeric($_GET['id'])) 
		{
			$this->SectionHandler();
			return;
		}
		$announcement = new Announcement($_GET['id']);
		if(!$announcement->delete())
			$this->_Page->setAlert( "Oh No!", "We were unable to delete the announcement!", 2 );
		else
			$this->_Page->setAlert( "Success!", "The announcement was successfully removed!");
			
		$this->_handleSearch();
	}
	
	private function _handleCreateAnnouncement()
	{
		
		if(!Announcement::create($_POST['subject'], $_POST['content']))
			$this->_Page->setAlert( "Oh No!", "Some required fields are empty!", 2 );
		else
			$this->_Page->setAlert( "Posted", "Announcement successfully posted!" );
		
	}
	
	private function _handleModifyAnnouncement()
	{
		
		$announcement = new Announcement( $_POST['id'] );
		
		if(!$announcement->modify($_POST['subject'], $_POST['content']))
			$this->_Page->setAlert( "Oh No!", "Some required fields are empty!", 2 );
		else
			$this->_Page->setAlert( "Posted", "Announcement successfully updated!" );
		
	}
	
	private function _handleUpdateProfile()
	{
		$db = Database::getInstance();
		$SQL = $db->getConnection();
		if(empty($_POST['id']) ||
			empty($_POST['firstName']) ||
			empty($_POST['lastName']) ||
			empty($_POST['email']) ||
			empty($_POST['type']))
		{
			$this->_Page->setAlert( "Oh No!", "Some required fields are empty!", 2 );
			return;
		}
		
		if(empty($_POST['password']))
			$query = "UPDATE `players` SET `firstName` = '{$SQL->real_escape_string($_POST['firstName'])}',
																		`lastName` = '{$SQL->real_escape_string($_POST['lastName'])}',
																		`email` = '{$SQL->real_escape_string($_POST['email'])}',
																		`phone` = '{$SQL->real_escape_string($_POST['phone'])}',
																		`type` = {$SQL->real_escape_string($_POST['type'])}
																		WHERE `id` = {$_POST['id']}";
		else
			$query = "UPDATE `players` SET `firstName` = '{$SQL->real_escape_string($_POST['firstName'])}',
																		`lastName` = '{$SQL->real_escape_string($_POST['lastName'])}',
																		`email` = '{$SQL->real_escape_string($_POST['email'])}',
																		`phone` = '{$SQL->real_escape_string($_POST['phone'])}',
																		`type` = {$SQL->real_escape_string($_POST['type'])},
																		`password` = '{$SQL->real_escape_string($_POST['password'])}'
																		WHERE `id` = {$_POST['id']}";
		$SQL->query($query) or die($SQL->error);
			$this->_Page->setAlert( "Update", "The user was successfully updated!" );
	}
	
}

?>