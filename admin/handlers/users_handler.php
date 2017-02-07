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
			
		if( isset( $_POST['createProfile'] ) )
			$this->_handleCreateProfile();
		
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
		elseif( isset( $_GET['tools'] ) )
			$this->_handleTools();
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
	
		$this->_Page->setSection( $this->_Page->Name . " - Main", $this->_handleUsersMain() );
		
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
	
	private function _handleCreate()
	{
		$db=Database::getInstance();
		$_Data = array("lastName"		=>	"",
									"firstName"		=>	"",
									"email"				=>	"",
									"phone"				=>	"",
									"type"				=>	""
									);
		$_Types = array("text","text","text","text","user_group");
		
		$fb = new FormBuilder($this->_Template, $db->getConnection());
		$form_data = $fb->buildByType($_Data, $_Types);
		$this->_Page->setSection( $this->_Page->Name, $this->_Template->Skin['users']->createTable($form_data) );
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
		$fb = new FormBuilder( $this->_Template, Database::getInstance()->getConnection() );
		$field = $fb->buildByType(array("id" => $_GET['id']), array("hidden") );
		$this->_Page->setSection( $this->_Page->Name, $this->_Template->Skin['users']->confirmForm($field) );
	}
	
	private function _handleTools()
	{		
		
		$content = "Tools Section";
		
		/*----------------------
		// Tool switchboard
		----------------------*/
		if(isset($_GET['sync']))
			$content = $this->_handleSync();
		elseif(isset($_GET['groups']))
			$content = $this->_handleGroups();
		
		// Set Tools Sections.
		$this->_Page->setSection($this->_Page->Name . " - Tools", $this->_Template->Skin['tools']->user_section($content));
	}
	
	/*-----------------------------------------------------------
	//  This is a Tool allowing the user to sync all users to
	//  appropriate settings and create missing settings.
	//  RETURN output
	//---------------------------------------------------------*/
	private function _handleSync()
	{
		$db = Database::getInstance();
		$SQL = $db->getConnection();
		
		// Default Settings variable
		$defaults = array("template_id" => Template::defaultTemplate());
		
		// Variable for output text
		$output = "<p>Starting sync process...<br><ul>";
		
		// Retrieve amount of players from database
		$users_query_str = "SELECT COUNT(id) FROM `players`";
		$users_query = $SQL->query($users_query_str);
		$users_result = $users_query->fetch_row();
		$users_count = $users_result[0];
		
		// Retrieve amount of player settings from database
		$settings_query_str = "SELECT COUNT(player_id) FROM `player_settings`";
		$settings_query = $SQL->query($settings_query_str);
		$settings_result = $settings_query->fetch_row();
		$settings_count = $settings_result[0];
		
		// Set the first part of the output: Amount of Users vs. Settings
		$output .= "<li>There are <b>{$users_count}</b> \"players\" row(s)...<br>";
		$output .= "<li>There are <b>{$settings_count}</b> \"player_settings\" row(s)...<br>";
		
		// Get Settings query and fill array data...
		$set_str = "SELECT `player_id` FROM `player_settings` ORDER BY `player_id` ASC";
		$set_query = $SQL->query($set_str);
		$settings = array();
		while($setting = $set_query->fetch_assoc())
		{
			$settings[$setting['player_id']] = $setting;
		}
		
		// Get Users query and fill array data...
		$pla_str = "SELECT `id` FROM `players` ORDER BY `id` ASC";
		$pla_query = $SQL->query($pla_str);
		$players = array();
		while($player = $pla_query->fetch_assoc())
		{
				$players[$player['id']] = $player;
		}
		
		// Let's compare both and fill associated arrays..
		// VAR: $notFoundSettings - Stores player id that does not exist in "players" table.
		//       Key: Ascending
		//       Value: Player ID
		$notFoundSettings = array();
		foreach($settings as $id => $val)
		{
			if(!isset($players[$id]))
				$notFoundSettings[] = $id;
		}
		// VAR: $notFoundPlayers - Stores player id that does not exist in "player_settings" table.
		//       Key: Ascending
		//       Value: Player ID
		$notFoundPlayers = array();
		foreach($players as $id => $val)
		{
			if(!isset($settings[$id]))
				$notFoundPlayers[] = $id;
		}
		
		if(count($notFoundSettings) > 0)
			$output .= "<li><b>" . count($notFoundSettings) . "</b> row(s) in \"player_settings\" do no correspond to the \"players\" table!<br>";
		else
			$output .= "<li>All \"player_settings\" row(s) are synced with the \"players\" table!<br>";
		
		if(count($notFoundSettings) > 0)
		{
			$output .= "<li>Deleting <b>" . count($notFoundSettings) . "</b> \"player_settings\" row(s)...<br>";
			$successful = 0;
			foreach($notFoundSettings as $id)
			{
				$query = $SQL->query("DELETE FROM `player_settings` WHERE `player_id` = '{$id}'");
				if($query)
					$successful++;
			}
			$output .= "<li><b>{$successful}</b> row(s) have been removed from \"player_settings\"!<br>";
		}
		
		if(count($notFoundPlayers) > 0)
			$output .= "<li><b>" . count($notFoundPlayers) . "</b> row(s) in \"players\" do no have a \"player_settings\" row!<br>";
		else
			$output .= "<li>All \"players\" row(s) are synced with the \"player_settings\" table!<br>";
		
		if(count($notFoundPlayers) > 0)
		{
			$output .= "<li>Creating <b>" . count($notFoundPlayers) . "</b> \"player_settings\" row(s)...<br>";
			
			$successful = 0;
			foreach($notFoundPlayers as $id)
			{
				$query = $SQL->query("INSERT INTO `player_settings` VALUES('{$id}', '{$defaults['template_id']}')");
				if($query)
					$successful++;
			}
			$output .= "<li><b>{$successful}</b> row(s) have been added to \"player_settings\"!<br>";
			
		}
		
		$output .= "</ul><p>Syncing process complete!</p>
												<p><i>You Will Be Redirected In 5 Seconds...</i></p></p>";
		$output .= "<script>setTimeout(function(){location.href='index.php?cat=users&tools';}, '5000');</script>";
		
		$this->_Page->setAlert("Success!", "The syncing process has completed successfully!");
		return $output;
		
	}
	
	/*-----------------------------------------------------------
	//  This is a Tool allowing the user to create, alter, and
	//  delete user groups.
	//  RETURN output
	//---------------------------------------------------------*/
	private function _handleGroups()
	{
		if(isset($_POST['submit_create']))
			$this->_handleCreateUserGroup();
		if(isset($_POST['submit_modify']))
			$this->_handleModifyUserGroup();
		
		$output = $this->_Template->Skin['tools']->user_groups_main();
		if(isset($_GET['create']))
			$output = $this->_Template->Skin['tools']->user_groups_create();
		if(isset($_GET['modify']))
			if(!isset($_GET['id']))
				$output = $this->_handleFindGroup();
			else
				$output = $this->_handleModifyGroupForm();
		
		
		return $output;
	}
	
	private function _handleCreateUserGroup()
	{
		$db = Database::getInstance();
		$SQL = $db->getConnection();
		
		if(empty(trim($_POST['name'])))
		{
			$this->_Page->setAlert("Warning", "You must enter a group name!", 1);
			return;
		}
		if(empty(trim($_POST['restriction'])))
			$_POST['restriction'] = 0;
		if($_POST['restriction'] < 0) $_POST['restriction'] = 0;
		if($_POST['restriction'] > 4) $_POST['restriction'] = 4;
		
		$query = $SQL->query("INSERT INTO `player_groups` VALUE (null, 
												'" . $SQL->real_escape_string($_POST['name']) . "', 
												'" . $SQL->real_escape_string($_POST['restriction']) . "')
												");
		
		if($query)
			$this->_Page->setAlert("Success", "User Group was created!");
		else
			$this->_Page->setAlert("Uh Oh!", "Something went wrong and it could not be saved!", 2);
	}
	
	private function _handleModifyUserGroup()
	{
		$db = Database::getInstance();
		$SQL = $db->getConnection();
		
		if(empty(trim($_POST['name'])))
		{
			$this->_Page->setAlert("Warning", "You must enter a group name!", 1);
			return;
		}
		if(empty(trim($_POST['restriction'])))
			$_POST['restriction'] = 0;
		if($_POST['restriction'] < 0) $_POST['restriction'] = 0;
		if($_POST['restriction'] > 4) $_POST['restriction'] = 4;
		
		$query = $SQL->query("UPDATE `player_groups` SET `name` =	'" . $SQL->real_escape_string($_POST['name']) . "', 
												`restriction` = '" . $SQL->real_escape_string($_POST['restriction']) . "'
												WHERE `group_id` = '" . $SQL->real_escape_string($_POST['group_id']) . "'
												");
		if($query)
			$this->_Page->setAlert("Success", "User Group was created!");
		else
			$this->_Page->setAlert("Uh Oh!", "Something went wrong and it could not be saved!", 2);
	}
	
	private function _handleModifyGroupForm()
	{
		$db = Database::getInstance();
		$SQL = $db->getConnection();
		
		$q_str = "SELECT * FROM `player_groups` WHERE `group_id` = '" . $SQL->real_escape_string($_GET['id']) . "'";
		$query = $SQL->query($q_str);
		if(!$query)
			return $this->_handleFindGroup();;
		
		$result = $query->fetch_assoc();
		return $this->_Template->Skin['tools']->user_groups_modify($result);
	}
	
	private function _handleFindGroup()
	{
		$db = Database::getInstance();
		$SQL = $db->getConnection();
		$q_str = "SELECT * FROM `player_groups` ORDER BY `group_id` ASC";
		$query =  $SQL->query($q_str);
		$output = "";
		while($result = $query->fetch_assoc())
		{
			$output .= $this->_Template->Skin['tools']->groups_row($result);
		}
		return $this->_Template->Skin['tools']->groups_table($output);
	}
	
	private function _handleUpdateProfile()
	{
		$db = Database::getInstance();
		$SQL = $db->getConnection();
		if(empty($_POST['id']) ||
			empty($_POST['firstName']) ||
			empty($_POST['lastName']) ||
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
	
	private function _handleCreateProfile()
	{
$db = Database::getInstance();
		$SQL = $db->getConnection();
		if(empty($_POST['firstName']) ||
			empty($_POST['lastName']) ||
			empty($_POST['type']))
		{
			$this->_Page->setAlert( "Oh No!", "Some required fields are empty!", 2 );
			return;
		}
		

			$query = "INSERT INTO `players` VALUE(null,
																						'',
																						" . time() . ",
																						'" . CMS_Core::getInstance()->User->fullName . "',
																						'',
																						'',
																						'" . $SQL->real_escape_string($_POST['type']) . "',
																						'" . $SQL->real_escape_string($_POST['lastName']) . "',
																						'" . $SQL->real_escape_string($_POST['firstName']) . "',
																						'" . $SQL->real_escape_string($_POST['email']) . "',
																						'',
																						'" . $SQL->real_escape_string($_POST['phone']) . "'
																						)";
		$SQL->query($query) or die($SQL->error);
			$this->_Page->setAlert( "Profile Created!", "The user profile was successfully created!" );
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