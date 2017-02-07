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
		
		$p_id = isset($_GET['pid']) ? (is_numeric($_GET['pid']) ? $_GET['pid'] : 0) : 0;
		$this->_getUserStatistics($p_id);
		
		if( isset( $_GET['settings'] ) )
			$this->_getUserSettings();
		if( isset( $_GET['update'] ) )
			$this->_getUserProfile();
		if( isset( $_GET['mail'] ) )
		{
			if( isset( $_GET['id'] ) && is_numeric( $_GET['id'] ) )
			{
				if( isset($_GET['reply']) )
					$this->_getComposeForm( $_GET['id'], (isset($_GET['all']) ? 1 : 0) );
				elseif( isset($_GET['forward']) )
					$this->_getComposeForm( $_GET['id'], 0, 1 );
				else
					$this->_getUserMail( $_GET['id'] );
			}
			elseif( isset( $_GET['compose'] ) )
				$this->_getComposeForm();
			else
				$this->_getUserMailBox();
		}
		
		$this->DEBUG[] = "Get Handlers Fired!";
		
	}
	
	private function _getUserProfile()
	{
		
		$this->DEBUG[] = "Retrieving User Profile...";
	
		$db = Database::getInstance();
		$SQL = $db->getConnection();
		$Page = Page::getInstance();
		$Template = Template::getInstance();
		$Core = CMS_Core::getInstance();
		
		$q_str = "SELECT *
					FROM `players`
					WHERE `id` = '" . $Core->User->id . "'
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
			
			$form = $Template->convertToForm(array("template_id" => $results['template_id']), array("template"));
		
			$content = $Template->Skin['users']->settingsForm( $form );
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
		$Core = CMS_Core::getInstance();
		
		$content = "";
		
		$q_str = "SELECT *
					FROM `player_mail`
					WHERE `receiver_id` = '" . $Core->User->id . "'
					AND `id` = '" . $SQL->real_escape_string( $message_id ) . "'
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
			$results['sender_name'] = $Core->getUserNameByID($results['sender_id']);
			$recipients = explode(",", $results['all_recipients']);
			foreach($recipients as $k => $uid)
			{
				$recipients[$k] = $Template->Skin['users']->recipientBox($Core->getUserNameByID($uid));
			}
			$results['recipients'] = implode(" ", $recipients);
			
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
	
	private function _getComposeForm( $mid = 0, $all = 0, $forward = 0 )
	{
		
		$this->DEBUG[] = "Retrieving Compose Form...";

		$Page = Page::getInstance();
		$Template = Template::getInstance();
		
		if($mid == 0)
		{
			$Page->setSection( $Page->Title, $Template->Skin['users']->composeMailForm() );
			return;
		}
		
		$db = Database::getInstance();
		$SQL = $db->getConnection();
		$Core = CMS_Core::getInstance();
		
		$q_str = "SELECT * FROM `player_mail` WHERE `id` = '" . $SQL->real_escape_string( $mid ) . "'";
		
		$query = $SQL->query($q_str);
		
		$result = $query->fetch_assoc();
		
		$result['sender'] = $Core->getUserNameByID($result['sender_id']);
		$result['recipients'] = explode(",", $result['all_recipients']);
		if($forward == 0)
			$result['receivers'] = $Template->Skin['users']->receiverBox($result['sender_id'], $Core->getMailNameByID($result['sender_id']));
		foreach($result['recipients'] as $key => $uid)
		{
			$result['recipients'][$key] = $Core->getUserNameByID($uid);
			if($all == 1 && $uid != $result['sender_id'] && $forward == 0)
				$result['receivers'] .= $Template->Skin['users']->receiverBox($uid, $Core->getMailNameByID($uid));
		}
		$result['recipients'] = implode(" & ", $result['recipients']);
		
		
		$result['message'] = $Template->Skin['users']->replyMessageWrapper($result);
		
		if($forward == 0)
			$Page->setSection( $Page->Title, $Template->Skin['users']->replyMailForm($result) );
		else
			$Page->setSection( $Page->Title, $Template->Skin['users']->composeMailForm($result) );
		
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
					ORDER BY `time` DESC
				";
		if($query = $SQL->query($q_str))
		{
			$this->DEBUG[] = "Mail For User \"" . $Core->User->id . "\" Found!";	
			
			$messages = "";
			while($results = $query->fetch_assoc())
			{
				$results['sender'] = $Core->getUserNameByID( $results['sender_id'] );
				$results['date'] = date("F d, Y \a\\t g:ia T", $results['time']);
				
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
	
	private function _getUserStatistics($p_id)
	{
				
		$this->DEBUG[] = "Retrieving User Statistics...";
		
		$db = Database::getInstance();
		$SQL = $db->getConnection();
		$Page = Page::getInstance();
		$Template = Template::getInstance();
		$Core = CMS_Core::getInstance();
		
		if($p_id == 0) $p_id = $Core->User->id;
		
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
		
		$playerStats = new PlayerStatistics( $p_id, $year );
		$player = $Core->getUserNameByID($p_id);
		
		$Page->setSection( $Page->Title, $Template->Skin['users']->leaderboardTableHeader("\"{$player}\" {$year} Statistics", $playerStats->outputAllLeaderboardRows()) );
		
	}
	
	private function _handleUpdateProfile()
	{
	
		$db = Database::getInstance();
		$SQL = $db->getConnection();
		$Page = Page::getInstance();
		if( empty( $_POST['email'] ) )
		{
			$Page->setAlert( "Oh No!", "Email Can't Be Empty!", 2 );
			return;
		}
		
		$query = $SQL->query("UPDATE `players` SET	`email` = '" . $SQL->escape_string( $_POST['email'] ) . "',
																				`phone` = '" . $SQL->escape_string( $_POST['phone'] ) . "'
																				WHERE `id` = '" . CMS_Core::getInstance()->User->id . "'
										");
										
		if( $query )
		{
			$Page->setAlert( "Success!", "Your profile has been successfully updated!!" );
		}
		else
		{
			$Page->setAlert( "Oh No!", "Something went wrong and your profile didn't update!", 2 );
		}
		
	}
	
	private function _handleUpdateSettings()
	{
	
		$db = Database::getInstance();
		$SQL = $db->getConnection();
		$Page = Page::getInstance();
		$Core = CMS_Core::getInstance();
		
		if( empty( $_POST['template_id'] ) )
		{
			$Page->setAlert( "Oh No!", "You can't have no template!", 2 );
			return;
		}
		
		if( !Template::isTemplate($_POST['template_id']) )
		{
			$Page->setAlert( "Oh No!", "That is not a valid template!", 2 );
			return;
		}
		
		$query = $SQL->query("UPDATE `player_settings` SET `template_id` = '" . $SQL->escape_string( $_POST['template_id'] ) . "'
																			WHERE `player_id` = '" . $Core->User->id . "'
										");
		
		$Core->User->Settings['template_id'] = $_POST['template_id'];
		
		$Template = Template::getInstance();
										
		if( $query )
		{
			$Page->setAlert( "Success!", "Your settings have been successfully updated!!" );
		}
		else
		{
			$Page->setAlert( "Oh No!", "Something went wrong and your settings didn't update!", 2 );
		}
		
	}
	
	private function _handleMarkedMail()
	{
	
		if(!isset($_POST['message'])) return;
		
		$db = Database::getInstance();
		$SQL = $db->getConnection();
		$Page = Page::getInstance();
		$Core = CMS_Core::getInstance();
		
		foreach( $_POST['message'] as $msg_id )
		{
			$query = $SQL->query("UPDATE `player_mail` SET `unread` = " . $SQL->real_escape_string( $_POST['mark'] ) . " WHERE `receiver_id` = '{$Core->User->id}' AND `id` = '" . $SQL->real_escape_string( $msg_id ) . "'");
			if(!$query) $Page->setAlert( "Oh No!", "Some messages could not be marked!", 2 );
		}
	
	}
	
	private function _handleSendMail()
	{
	
		$db = Database::getInstance();
		$SQL = $db->getConnection();
		$Page = Page::getInstance();
		$Core = CMS_Core::getInstance();
		
		if( !isset( $_POST['to'] ) )
		{
			$Page->setAlert( "Oh No!", "You must have a recipient!", 2 );
			$this->_getComposeForm();
			return;
		}
		if( empty( $_POST['subject'] ) )
		{
			$_POST['subject'] = DEFAULT_NO_MAIL_SUBJECT;
		}
		if( empty( $_POST['message'] ) )
		{
			$Page->setAlert( "Oh No!", "You must enter a message!", 2 );
			$this->_getComposeForm();
			return;
		}

		$to = implode($_POST['to'], ",");
		
		$error = 0;
		foreach($_POST['to'] as $uid)
		{
			$query = $SQL->query("INSERT INTO `player_mail` VALUES (null,
																'" . $SQL->escape_string( $uid ) . "',
																'" . $SQL->escape_string( $to ) . "',
																'" . $SQL->escape_string( $Core->User->id ) . "',
																'1',
																'" . $SQL->escape_string( $_POST['subject'] ) . "',
																'" . $SQL->escape_string( $_POST['message'] ) . "');
							");
			if(!$query)
				$error = 1;
		}
										
		if( !$error )
		{
			$Page->setAlert( "Success!", "Message Sent!!" );
		}
		else
		{
			$Page->setAlert( "Oh No!", "Message was unable to send!", 2 );
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
			$Page->setAlert( "Oh No!", "Some messages could not be deleted!", 2 );
		}
		
	}
	
}

?>