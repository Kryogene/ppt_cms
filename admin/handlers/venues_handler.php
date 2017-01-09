<?PHP

class Venues_Handler extends Page_Handler
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
			
		if( isset( $_POST['addVenue'] ) )
			$this->_handleAddVenue();
		if( isset( $_POST['modifyVenue'] ) )
			$this->_handleModifyVenue();
			
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
		elseif( isset( $_GET['deactivate'] ) )
			$this->_handleDeactivate();
		
	}
	
	public function SectionHandler()
	{
		
		$this->_Page = Page::getInstance();
		$this->_Template = Template::getInstance();
    
    $this->_Template->loadSkin("venues");
	
		$this->_Page->setSection( $this->_Page->Name . " - Main", $this->_handleAnnouncementsMain() );
		
	}
	
	private function _handleAnnouncementsMain()
	{
		return "Users Main";
	}
	
	private function _handleSearch()
	{

		$sh = new Search_Handler( "venues" );
		$sh->fireAllPresets();
	}
	
	private function _handleAdd()
	{
		$this->_Page->setSection( $this->_Page->Name . " - Add", $this->_Template->Skin['venues']->addTable(Venue::getStaticForm()) );
		
	}
	
	private function _handleModify()
	{
		if(!isset($_GET['id']) || !is_numeric($_GET['id'])) 
		{
			$this->SectionHandler();
			return;
		}
		$venue = new Venue($_GET['id']);
		$data = $venue->getFormData();
		$this->_Page->setSection( $this->_Page->Name . " - Modify", $this->_Template->Skin['venues']->modifyTable($data) );
		
	}
	
	private function _handleDeactivate()
	{
		if(!isset($_GET['id']) || !is_numeric($_GET['id'])) 
		{
			$this->SectionHandler();
			return;
		}
		$venue = new Venue($_GET['id']);
		if(!$venue->deactivate())
			$this->_Page->setAlert( "Oh No!", "We were unable to deactivate the venue!", 2 );
		else
			$this->_Page->setAlert( "Success!", "The venue was successfully deactivated!");
			
		$this->_handleSearch();
	}
	
	private function _handleAddVenue()
	{
		
		if(count($_POST['day']) > 1)
			$day = implode("|", $_POST['day']);
		else
			$day = $_POST['day'][0];
		if(count($_POST['time_1']) > 1)
		{
			for($i=0;$i<count($_POST['time_1']);$i++)
				$times[] = $_POST['time_1'][$i] . ":" . $_POST['time_2'][$i] . " " . $_POST['time_3'][$i];
			$time = implode("|", $times);
		}
		else
			$time = $_POST['time_1'][0] . ":" . $_POST['time_2'][0] . " " . $_POST['time_3'][0];

		if(!Venue::add($_POST['name'],
									 $day,
									 $time,
									 $_POST['address'],
									 $_POST['city'],
									 $_POST['state'],
									 $_POST['zipCode'],
									 $_POST['phone'],
									 (isset($_POST['features']) ? implode(",", $_POST['features']) : ""),
									 $_POST['description']))
			$this->_Page->setAlert( "Oh No!", "You left some required fields empty!", 1 );
		else
			$this->_Page->setAlert( "Posted", "Venue successfully added!" );
		
	}
	
	private function _handleModifyVenue()
	{
		
		$venue = new Venue( $_POST['id'] );
		
		if(count($_POST['day']) > 1)
			$day = implode("|", $_POST['day']);
		else
			$day = $_POST['day'][0];
		if(count($_POST['time_1']) > 1)
		{
			for($i=0;$i<count($_POST['time_1']);$i++)
				$times[] = $_POST['time_1'][$i] . ":" . $_POST['time_2'][$i] . " " . $_POST['time_3'][$i];
			$time = implode("|", $times);
		}
		else
			$time = $_POST['time_1'][0] . ":" . $_POST['time_2'][0] . " " . $_POST['time_3'][0];
		
		if(!$venue->modify($_POST['name'],
											 $day,
											 $time,
											 $_POST['address'],
											 $_POST['city'],
											 $_POST['state'],
											 $_POST['zipCode'],
											 $_POST['phone'],
											 (isset($_POST['features']) ? implode(",", $_POST['features']) : ""),
											 $_POST['description']))
			$this->_Page->setAlert( "Oh No!", "Some required fields are empty!", 2 );
		else
			$this->_Page->setAlert( "Success", "Venue successfully updated!" );

		
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