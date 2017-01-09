<?PHP

class Users_Handler extends Page_Handler
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
			
		if( isset( $_POST['updateProfile'] ) )
			$this->_handleUpdateProfile();
		
		if( isset( $_POST['confirmDelete'] ) )
			$this->_handleConfirmedDelete();
			
		$this->DEBUG[] = "Post Handlers Fired!";
	}
	
	public function GetHandler()
	{	
	
		$this->DEBUG[] = "Firing Get Handlers...";
		
		if( isset( $_GET['search'] ) )
			$this->_handleSearch();
		elseif( isset( $_GET['modify'] ) )
			$this->_handleModify();
		elseif( isset( $_GET['delete'] ) )
			$this->_handleDelete();
		elseif( isset( $_GET['groups'] ) )
			$this->_handleGroups();
		elseif( isset( $_GET['email'] ) )
			$this->_handleMail();
		
	}
	
	public function SectionHandler()
	{
		
		$this->_Page = Page::getInstance();
		$this->_Template = Template::getInstance();
	
		$this->_Page->setSection( $this->_Page->Name . " - Users", $this->_handleUsersMain() );
		
	}
	
	private function _handleUsersMain()
	{
		return "Users Main";
	}
	
	private function _handleSearch()
	{
		$sh = new Search_Handler( "players" );
		$sh->fireAllPresets();
	}
	
	private function _handleModify()
	{
		if(!isset($_GET['id']) || !is_numeric($_GET['id'])) 
		{
			$this->SectionHandler();
			return;
		}
		$user = new User_Profile($_GET['id']);
		$data = $user->getFormData();
		$this->_Page->setSection( $this->_Page->Name, $this->_Template->Skin['users']->profileTable($data) );
		
	}
	
	private function _handleDelete()
	{
		if(!isset($_GET['id']) || !is_numeric($_GET['id']))
		{
			$this->_handleSearch();
			return;
		}
		$this->_Page->setAlert("Warning", "By confirming removal of this player all player statistics will be removed!", 1);
		$fb = new FormBuilder( $this->_Template );
		$field = $fb->buildByType(array("id" => $_GET['id']), array("hidden") );
		$this->_Page->setSection( $this->_Page->Name, $this->_Template->Skin['users']->confirmForm($field) );
	}
	
	private function _handleGroups()
	{
		$gh = new Groups_Handler;
		$gh->fireAllPresets();
	}
	
	private function _handleMail()
	{
		$mh = new Mail_Handler;
		$mh->fireAllPresets();
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
	
	private function _handleConfirmedDelete()
	{
		if( User_Profile::delete($_POST['id']) )
			if( PlayerStatistics::deleteAll($_POST['id']))
				$this->_Page->setAlert("Success", "Player has been successfully removed!");
			else
				$this->_Page->setAlert("Uh Oh", "Player statistics could not be removed!", 2);
		else
			$this->_Page->setAlert("Uh Oh", "Player profile could not be removed!", 2);
	}
	
}

?>