<?PHP

class User_Handler extends Page_Handler
{
	
	function __construct()
	{

	}
	
	public function PostHandler()
	{
		$this->DEBUG[] = "Firing Post Handlers...";
	
		if( isset( $_POST['submitSettings'] ) )
			$this->_handleUpdateSettings();
			
		if( isset( $_POST['submitProfile'] ) )
			$this->_handleUpdateProfile();
			
		if( isset( $_POST['mark'] ) )
			$this->_handleMarkedMail();
		if( isset( $_POST['deleteMail'] ) )
			$this->_handleDeletedMail();
			
		if( isset( $_POST['sendMail'] ) )
			$this->_handleSendMail();
			
		$this->DEBUG[] = "Post Handlers Fired!";
	}
	
	public function GetHandler()
	{	
	
		$this->DEBUG[] = "Firing Get Handlers...";
		
		if( isset( $_GET['settings'] ) )
			$this->_getUserSettings();
		if( isset( $_GET['update'] ) )
			$this->_getUserProfile();
		if( isset( $_GET['mail'] ) )
		{
			if( isset( $_GET['id'] ) && is_numeric( $_GET['id'] ) )
				$this->_getUserMail( $_GET['id'] );
			elseif( isset( $_GET['compose'] ) )
				$this->_getComposeForm();
			else
				$this->_getUserMailBox();
		}
		if( isset( $_GET['statistics'] ) )
			$this->_getUserStatistics();
		
		$this->DEBUG[] = "Get Handlers Fired!";
		
	}
	
	private function _getUserProfile()
	{
		
		$this->DEBUG[] = "Retrieving User Profile...";
	
		$db = Database::getInstance();
		$SQL = $db->getConnection();
		$Page = Page::getInstance();
		$Template = Template::getInstance();
		
		$q_str = "SELECT *
					FROM `players`
					WHERE `id` = '" . $_COOKIE['pid'] . "'
				";
		
		if($query = $SQL->query($q_str))
		{
			$this->DEBUG[] = "User \"" . $_COOKIE['pid'] . "\" Found!";
			
			$results = $query->fetch_assoc();
		
			$content = $Template->Skin['users']->profileForm( $results );
		}
		else
			$content = "Error!";
		
		$Page->setSection( $Page->Title, $content );
		
	}
	
	private function _getUserSettings()
	{
		
		$this->DEBUG[] = "Retrieving User Settings...";
	
		$db = Database::getInstance();
		$SQL = $db->getConnection();
		$Page = Page::getInstance();
		$Template = Template::getInstance();
		$Core = CMS_Core::getInstance();
		
		$q_str = "SELECT *
					FROM `player_settings`
					WHERE `player_id` = '" . $Core->User->id . "'
				";
		
		if($query = $SQL->query($q_str))
		{
			$this->DEBUG[] = "User \"" . $Core->User->id . "\" Found!";	
			
			$results = $query->fetch_assoc();
		
			$content = $Template->Skin['users']->settingsForm( $results );
		}
		else
			$content = "Error!";
		
		$Page->setSection( $Page->Title, $content );
		
	}
	
	private function _getUserMail( $message_id )
	{
		
		$this->DEBUG[] = "Retrieving Message ID \"" . $message_id . "\"...";
	
		$db = Database::getInstance();
		$SQL = $db->getConnection();
		$Page = Page::getInstance();
		$Template = Template::getInstance();
		
		$content = "";
		
		$q_str = "SELECT *
					FROM `player_mail`
					WHERE `receiver_id` = '" . $_COOKIE['pid'] . "'
					AND `id` = '" . $message_id . "'
				";
				
		$query = $SQL->query($q_str);

				
		if($query->num_rows > 0)
		{
		
			$this->DEBUG[] = "Message \"{$message_id}\" Found!";
			
			$results = $query->fetch_assoc();
			
			if($results['unread'])
			{
				$query = $SQL->query("UPDATE `player_mail` SET `unread` = '0'
									WHERE `id` = '{$message_id}'
								");				
				if($query) $this->DEBUG[] = "Mail Set To Unread.";
			}
			
			$content = $Template->Skin['users']->showMessage( $results );
			
		}
		else
		{
			$Page->setAlert( "Message Does Not Exist", $Template->Skin['users']->noMessageExists(), 2 );
			$this->_getUserMailBox();
			return;
		}
		
		$Page->setSection( $Page->Title, $content );
		
	}
	
	private function _getComposeForm( $to = 0 )
	{
		
		$this->DEBUG[] = "Retrieving Compose Form...";

		$Page = Page::getInstance();
		$Template = Template::getInstance();
		
		$Page->setSection( $Page->Title, $Template->Skin['users']->composeMailForm() );
		
	}
	
	private function _getUserMailBox()
	{
			
		$this->DEBUG[] = "Retrieving User Mailbox...";
	
		$db = Database::getInstance();
		$SQL = $db->getConnection();
		$Page = Page::getInstance();
		$Template = Template::getInstance();
		$Core = CMS_Core::getInstance();
		
		$unread = 0;
		$total = 0;
		$messages = $Template->Skin['users']->defaultNoMailMessages();
		
		$toolbar = $Template->Skin['users']->mailBoxToolbar( $Template->Skin['users']->mainMailTools() );
		
		$q_str = "SELECT *
					FROM `player_mail`
					WHERE `receiver_id` = '" . $Core->User->id . "'
				";
		if($query = $SQL->query($q_str))
		{
			$this->DEBUG[] = "Mail For User \"" . $Core->User->id . "\" Found!";	
			
			$messages = "";
			while($results = $query->fetch_assoc())
			{
				$results['sender'] = $Core->getUserNameByID( $results['sender_id'] );
				
				if($results['unread'] == 1)
				{
					$unread++;
					$messages .= $Template->Skin['users']->unreadMailMessage( $results );
				}
				else
				{
					$messages .= $Template->Skin['users']->readMailMessage( $results );
				}
				$total++;
			}
		}
		else
			$this->DEBUG[] = "Mail For User \"" . $_COOKIE['pid'] . "\" NOT Found!";
		
		
		$content = $Template->Skin['users']->mailBoxMain( $unread, $total, $messages, $toolbar );
		
		$Page->setSection( $Page->Title, $content );
		
	}
	
	private function _getUserStatistics()
	{
				
		$this->DEBUG[] = "Retrieving User Statistics...";
		
		$db = Database::getInstance();
		$SQL = $db->getConnection();
		$Page = Page::getInstance();
		$Template = Template::getInstance();
		
		$year = (isset($_GET['year']) && is_numeric($_GET['year'])) ? $_GET['year'] : date('Y');
		/*
		$q_str = "SELECT *
										FROM `player_statistics`
										WHERE `player_id` = '" . $_COOKIE['pid'] . "'
										";
		if($query = $SQL->query($q_str))
		{
			$this->DEBUG[] = "User \"" . $_COOKIE['pid'] . "\" Found!";	
			$results = $query->fetch_assoc();
		}
		else
		{
			$results = "Player Does Not Exist!";
		}
		
		$content = $Template->Skin['users']->userStatistics( $results );
		*/
		
		$playerStats = new PlayerStatistics( $_COOKIE['pid'], $year );
		
		$Page->setSection( $Page->Title, $Template->Skin['users']->leaderboardTableHeader($year . " Statistics", $playerStats->outputAllLeaderboardRows()) );
		
	}
	
	private function _handleUpdateProfile()
	{
	
		$db = Database::getInstance();
		$SQL = $db->getConnection();
		$Page = Page::getInstance();
		
		if( empty( $_POST['firstName'] ) )
		{
			$Page->setAlert( "Oh No!", "First Name Can't Be Empty!", 2 );
			return;
		}
		if( empty( $_POST['lastName'] ) )
		{
			$Page->setAlert( "Oh No!", "Last Name Can't Be Empty!", 2 );
			return;
		}
		if( empty( $_POST['email'] ) )
		{
			$Page->setAlert( "Oh No!", "Email Can't Be Empty!", 2 );
			return;
		}
		
		$query = $SQL->query("UPDATE `players` SET `firstName` = '" . $SQL->escape_string( $_POST['firstName'] ) . "',
																				`lastName` = '" . $SQL->escape_string( $_POST['lastName'] ) . "',
																				`email` = '" . $SQL->escape_string( $_POST['email'] ) . "',
																				`phone` = '" . $SQL->escape_string( $_POST['phone'] ) . "'
																				WHERE `id` = '" . $_COOKIE['pid'] . "'
										");
										
		if( $query )
		{
			$Page->setAlert( "Success!", "Your profile has been successfully updated!!" );
		}
		else
		{
			$Page->setAlert( "Oh No!", "Something went wrong and your profile didn't update!<br><pre>" . $SQL->error . "</pre>", 2 );
		}
		
	}
	
	private function _handleUpdateSettings()
	{
	
		$db = Database::getInstance();
		$SQL = $db->getConnection();
		$Page = Page::getInstance();
		
		if( empty( $_POST['template_id'] ) )
		{
			$Page->setAlert( "Oh No!", "You can't have no template!", 2 );
			return;
		}
		
		$query = $SQL->query("UPDATE `player_settings` SET `template_id` = '" . $SQL->escape_string( $_POST['template_id'] ) . "'
																			WHERE `player_id` = '" . $_COOKIE['pid'] . "'
										");
										
		if( $query )
		{
			$Page->setAlert( "Success!", "Your settings have been successfully updated!!" );
		}
		else
		{
			$Page->setAlert( "Oh No!", "Something went wrong and your settings didn't update!<br><pre>" . $SQL->error . "</pre>", 2 );
		}
		
	}
	
	private function _handleMarkedMail()
	{
	
		if(!isset($_POST['message'])) return;
		
		$db = Database::getInstance();
		$SQL = $db->getConnection();
		$Page = Page::getInstance();
		
		foreach( $_POST['message'] as $msg_id )
		{
			$query = $SQL->query("UPDATE `player_mail` SET `unread` = {$_POST['mark']} WHERE `receiver_id` = '{$_COOKIE['pid']}' AND `id` = '{$msg_id}'");
			if(!$query) $Page->setAlert( "Oh No!", "Some messages could not be marked!<br><pre>" . $SQL->error . "</pre>", 2 );
		}
	
	}
	
	private function _handleSendMail()
	{
	
		$db = Database::getInstance();
		$SQL = $db->getConnection();
		$Page = Page::getInstance();
		$Core = CMS_Core::getInstance();
		
		if( empty( $_POST['to'] ) )
		{
			$Page->setAlert( "Oh No!", "You must have a recipient!", 2 );
			return;
		}
		if( empty( $_POST['subject'] ) )
		{
			$_POST['subject'] = DEFAULT_NO_MAIL_SUBJECT;
		}
		if( empty( $_POST['message'] ) )
		{
			$Page->setAlert( "Oh No!", "You must enter a message!", 2 );
			return;
		}
		
		$query = $SQL->query("INSERT INTO `player_mail` VALUES (null,
																'" . $SQL->escape_string( $_POST['to'] ) . "',
																'" . $SQL->escape_string( $Core->User->getID() ) . "',
																'1',
																'" . $SQL->escape_string( $_POST['subject'] ) . "',
																'" . $SQL->escape_string( $_POST['message'] ) . "');
							");
										
		if( $query )
		{
			$Page->setAlert( "Success!", "Message Sent!!" );
		}
		else
		{
			$Page->setAlert( "Oh No!", "Message was unable to send!<br><pre>" . $SQL->error . "</pre>", 2 );
		}
		
	}
	
	private function _handleDeletedMail()
	{
	
		$db = Database::getInstance();
		$SQL = $db->getConnection();
		$Page = Page::getInstance();
		$Core = CMS_Core::getInstance();
		
		if( empty( $_POST['message'] ) )
		{
			$Page->setAlert( "Oh No!", "You must at least select a message!", 2 );
			return;
		}

		foreach( $_POST['message'] as $msg_id )
			$query = $SQL->query("DELETE FROM `player_mail` WHERE `id` = '" . $SQL->escape_string( $msg_id ) . "'");
										
		if( $query )
		{
			$Page->setAlert( "Success!", "Message(s) Deleted!" );
		}
		else
		{
			$Page->setAlert( "Oh No!", "Some messages could not be deleted!<br><pre>" . $SQL->error . "</pre>", 2 );
		}
		
	}
	
}

?>