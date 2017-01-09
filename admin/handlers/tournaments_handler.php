<?PHP

class Tournaments_Handler extends Page_Handler
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
			
		if( isset( $_POST['addTournament'] ) )
			$this->_handleAddTournament();
		if( isset( $_POST['modifyTournament'] ) )
			$this->_handleModifyTournament();
			
		$this->DEBUG[] = "Post Handlers Fired!";
	}
	
	public function GetHandler()
	{	
	
		$this->DEBUG[] = "Firing Get Handlers...";

		if( isset( $_GET['search'] ) )
			$this->_handleSearch();
		elseif( isset( $_GET['add'] ) )
			$this->_handleAdd();
		elseif( isset( $_GET['modify'] ) )
			$this->_handleModify();
		elseif( isset( $_GET['delete'] ) )
			$this->_handleDelete();
		
	}
	
	public function SectionHandler()
	{
		
		$this->_Page = Page::getInstance();
		$this->_Template = Template::getInstance();
    
    $this->_Template->loadSkin("tournaments");
	
		$this->_Page->setSection( $this->_Page->Name . " - Main", $this->_handleAnnouncementsMain() );
		
	}
	
	private function _handleAnnouncementsMain()
	{
		return "Users Main";
	}
	
	private function _handleSearch()
	{

		$sh = new Search_Handler( "tournaments" );
		$sh->fireAllPresets();
	}
	
	private function _handleAdd()
	{
		$this->_Page->setSection( $this->_Page->Name . " - Add", $this->_Template->Skin['tournaments']->addTable(Tournament::getStaticForm()) );
		
	}
	
	private function _handleModify()
	{
		if(!isset($_GET['id']) || !is_numeric($_GET['id'])) 
		{
			$this->SectionHandler();
			return;
		}
		$tournament = new Tournament($_GET['id']);
		$data = $tournament->getFormData();
		$this->_Page->setSection( $this->_Page->Name . " - Modify", $this->_Template->Skin['tournaments']->modifyTable($data) );
		
	}
	
	private function _handleDelete()
	{
		if(!isset($_GET['id']) || !is_numeric($_GET['id'])) 
		{
			$this->SectionHandler();
			return;
		}
		$tournament = new Tournament($_GET['id']);
		if(!$tournament->delete())
			$this->_Page->setAlert( "Oh No!", "We were unable to delete the tournament!", 2 );
		else
			$this->_Page->setAlert( "Success!", "The tournament was successfully deleted!");
			
		$this->_handleSearch();
	}
	
	private function _handleAddTournament()
	{
		
		$time = $_POST['time_1'] . ":" . $_POST['time_2'] . " " . $_POST['time_3'];

		if(!Tournament::add($_POST['venue'],
									 $_POST['month'],
									 $_POST['day'],
									 $_POST['year'],
									 $time,
									 $_POST['information']))
			$this->_Page->setAlert( "Oh No!", "You left some required fields empty!", 1 );
		else
			$this->_Page->setAlert( "Success", "Tournament successfully added!" );
		
	}
	
	private function _handleModifyTournament()
	{
		
		$venue = new Tournament( $_POST['id'] );
		
		$time = $_POST['time_1'] . ":" . $_POST['time_2'] . " " . $_POST['time_3'];
		
		if(!$venue->modify($_POST['venue'],
									 $_POST['month'],
									 $_POST['day'],
									 $_POST['year'],
									 $time,
									 $_POST['information']))
			$this->_Page->setAlert( "Oh No!", "Some required fields are empty!", 2 );
		else
			$this->_Page->setAlert( "Success", "Tournament successfully updated!" );

		
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