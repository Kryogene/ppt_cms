<?PHP

class Login_Handler extends Page_Handler
{
	
	function __construct()
	{
		
	}
	
	public function PostHandler()
	{
	
		if( isset( $_POST['submit_login'] ) )
			$this->_handleLogin();
		if( isset( $_POST['recover'] ) )
			$this->_handleRecover();
	
	}
	
	public function GetHandler()
	{
	
		if( isset( $_GET['logout'] ) )
			$this->_handleLogout();
		if( isset( $_GET['forgot'] ) )
			$this->_handleForgotLink();
		if( isset( $_GET['recovery_hash'] ) )
			$this->_handleRecoveryLink();
	
	}
	
	private function _handleLogin()
	{
		$Page = Page::getInstance();
		try
		{
			Login::doLogin();
		}
		catch(Exception $e)
		{
			$Page->setAlert( "Oh No!", $e->getMessage(), 2 );
			$Page->setSection( $Page->Title, Login::loginSection());
			return;
		}
		
		$Page->setAlert("Logged In!", "You have logged in successfully!");
		$Page->setSection( $Page->Title, Login::loggedInMsg());
		
	}
	
	private function _handleRecover()
	{
		$Page = Page::getInstance();
		if(!isset($_POST['email']))
		{
			$Page->setAlert( "Oh No!", "You must enter an email!", 1 );
			$Page->setSection( $Page->Title, Login::loginSection() );
			return;
		}
		if(empty(trim($_POST['email'])))
		{
			$Page->setAlert( "Oh No!", "You must enter an email!", 1 );
			$Page->setSection( $Page->Title, Login::loginSection() );
			return;
		}
		$db = Database::getInstance();
		$SQL = $db->getConnection();
		
		$q_str = "SELECT * FROM `players` WHERE `email` = '" . $SQL->real_escape_string($_POST['email']) . "'";
		$query = $SQL->query($q_str);
		if($query)
		{
			if($query->num_rows > 0)
			{
				$time_start = time();
				$recovery_hash = md5(md5($time_start) + md5( CMS_Core::$hash ));
				$time_end = time() + 3600 * 48; // 3600 (hour) multiplied by 48 hours.
				
				$result = $query->fetch_assoc();
				$player_id = $result['id'];
					$to = $result['email'];
					$subject = "Password Recovery";
					$message = <<<MSG
<html>
<head>
  <title>Password Recovery</title>
</head>
<body>
	<img src="http://www.playerspokertour.net/cms/images/global/pptlogo.png"><br><br>
	<span style="font-size: 16px;">Hello {$result['firstName']} {$result['lastName']}!
  <p>You seem to have requested to recover your account on Players Poker Tour. If this is correct
	please <a href="http://www.playerspokertour.net/cms/index.php?p=login&recovery_hash={$recovery_hash}">Click Here</a>
	or copy and paste the link below. The recovery link is only good for 48 hours! If this was not you please ignore this email and have a wonderful day!</p>
 	<p>
		<span style="font-size: 18px;">
			<a href="http://www.playerspokertour.net/cms/index.php?p=login&recovery_hash={$recovery_hash}">
				http://www.playerspokertour.net/cms/index.php?p=login&recovery_hash={$recovery_hash}
			</a>
		</span>
	</p>
	<p>
		Sincerely,
		<span style="text-indent:1em;">The Players Poker Tour Staff</span>
	</p>
</body>
</html>
MSG;
						// To send HTML mail, the Content-type header must be set
						$headers[] = 'MIME-Version: 1.0';
						$headers[] = 'Content-type: text/html; charset=iso-8859-1';
						$headers[] = "Reply-To: Players Poker Tour (Support) <support@playerspokertour.net>";
  					$headers[] = "Return-Path: Players Poker Tour Return <return_to_sender@playerspokertour.net>";
						$headers[] = "Organization: Players Poker Tour";
						// Additional headers
						$headers[] = "To: {$result['lastName']}, {$result['firstName']} <{$result['email']}>";
						$headers[] = 'From: Players Poker Tour Recovery <do_no_reply@playerspokertour.net>';
				if(mail($to, $subject, $message, implode("\r\n", $headers)))
				{
					$q_str = "INSERT INTO `player_recovery` VALUES(null,
																												{$player_id},
																												'{$recovery_hash}',
																												{$time_start},
																												{$time_end}
																												)";
					$query = $SQL->query($q_str);
					if(!$query)
						$donothing=null; // Do Nothing, for now!
				}
			}
			$Page->setAlert("Success!", "If you have an email registered with us an email with a recovery link has been sent!");
			$Page->setSection( $Page->Title, Login::loginSection() );
			return;
		}
		else
		{
			$Page->setAlert( "Oh No!", "An error has occured, please try again later!", 2 );
			$Page->setSection( $Page->Title, Login::loginSection() );
			return;
		}
	}
	
	private function _handleRecoveryLink()
	{
		$db = Database::getInstance();
		$SQL = $db->getConnection();
		$Page = Page::getInstance();
		
		if(strlen($_GET['recovery_hash']) != 32)
		{
			$Page->setAlert("Oh No!", "That is not a valid recovery hash!", 2);
			return;
		}
		
		$q_str = "SELECT * FROM `player_recovery` WHERE `hash` = '" . $SQL->real_escape_string(addslashes($_GET['recovery_hash'])) . "' AND `time_end` > '" .time()."'";
		$query = $SQL->query($q_str);
		if($query)
		{
			if($query->num_rows > 0)
			{
				$result = $query->fetch_assoc();
				/*-------------------------
				// For added security we will complete this form post in the module.
				//-----------------------*/
				if(isset($_POST['new_password']))
				{
					if( empty( $_POST['password'] ) ) 
						$Page->setAlert("Uh oh", "You must enter a password!", 1 );
					elseif( strlen($_POST['password']) < 5 ) 
						$Page->setAlert("Uh oh", "Your password must exceed more than 5 characters!", 1 );
					elseif( isset($whitespace[1]) ) 
						$Page->setAlert("Uh oh", "Spaces are not allowed in your password!", 1 );
					elseif( $_POST['password'] != $_POST['password2'] ) 
						$Page->setAlert("Uh oh", "Passwords do not match!", 1 );
					else
					{
						$password = md5( md5($_POST['password']) + md5(CMS_Core::$hash) );
						$q_str = "UPDATE `players` SET `password` = '" . $password . "' WHERE `id` = '" . $result['player_id'] . "'";
						$query = $SQL->query($q_str);
						if($query)
						{
							$q_str = "UPDATE `player_recovery` SET `time_end` = '" . time() . "' WHERE `id` = " . $result['id'];
							$query = $SQL->query($q_str);
							$Page->setAlert("Success", "Your password has been updated successfully, please attempt to login to continue!");
							$Page->setSection("Login", Login::loginSection());
							return;
						}
						else
						{
							$Page->setAlert("Oh No!", "Your password could not be set, please try again in a few minutes!", 2 );
						}
					}
				}
				$Page->setSection("Reset Password", Login::passwordRecovery());
			}
			else
			{
				$Page->setAlert("Uh Oh!", "You do not have a valid recovery hash, the hash may have expired! Remember, you only have 48 hours to redeem a password recovery!", 1);
				$Page->setSection("Reset Password", Login::recoveryForm());
			}
		}
		
	}
	
	private function _handleLogout()
	{
	
		$Page = Page::getInstance();
		
		Login::doLogout();
		$Page->setAlert("Logged Out!", "You have been logged out successfully!");
		
	}
	
	private function _handleForgotLink()
	{
		$Page = Page::getInstance();
		
		$Page->setSection($Page->Title . " Recovery", Login::recoveryForm());
	}
	
	public function SectionHandler()
	{
	
		$Page = Page::getInstance();
	
		$Page->setSection( $Page->Title, Login::loginSection() );
		
	}
	
}

?>