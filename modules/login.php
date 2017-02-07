<?PHP

class Login
{

	public $DEBUG;

	public function __construct()
	{
	
	}
	
	public static function checkLoginAndGetUser()
	{

		$Core = CMS_Core::getInstance();
	
		$Core->DEBUG[] = "Checking User Login...";
		
	
		if( isset( $_COOKIE['pid'] ) )
		{
			if( !is_numeric( $_COOKIE['pid'] ) )
			{
				$Core->DEBUG[] = "Player ID Cookie Smells Fishy, Let's Get Some New Ones...";
				self::_setGuestCookies();
				$id = 0;
			}
			else
			{
				self::_setMemberCookies();
				$id = $_COOKIE['pid'];
			}
		}
		else
		{
		
			self::_setGuestCookies();
			$id = 0;
			
		}
		return self::getUserObjectFromID( $id );
		
	}
	
	public static function getUserObjectFromID( $id )
	{
	
		if(!is_numeric($id)) 
			return new Guest;		

		switch( User::isUserType( $id ) )
		{
			Case 1:
				return new Administrator( $id );
			Case 2:
				return new Moderator( $id );
			Case 3:
				return new Player( $id );
			/*Case 4
				$this->_combineDebug();
				return new Banned( $id );*/
			default:
				return new Guest;
		}
		
	}
		
		protected static function _setGuestCookies()
		{
		
			$Core = CMS_Core::getInstance();
	
			$Core->DEBUG[] = "Creating Guest Cookies...";
		
			setcookie("pid", null, time() - 3600, '/');
            setcookie("pid", 0, time() + (3600 * 72), '/');
			
			if (session_id() == '') 
				session_start();
	
			$Core->DEBUG[] = "Guest Cookies Created!";
			
		}
		
		protected static function _setMemberCookies( $id = null, $hash = null )
		{
		
			$Core = CMS_Core::getInstance();
			
			$id = ( is_null($id) ) ? $_COOKIE['pid'] : $id;
			$hash = ( is_null($hash) ) ? isset($_COOKIE['hash']) ? $_COOKIE['hash'] : null : $hash;
	
			$Core->DEBUG[] = "Creating Member Cookies...";
		
			self::unsetMemberCookies();
			
			//echo "id: " . $id . "|hash: " . $hash . "|";
			
      setcookie("pid", $id, time() + (3600 * 72), '/');
			setcookie("hash", $hash, time() + (3600 * 72), '/');
			
			if (session_id() == '') 
				session_start();

			$_SESSION['pid'] = $id;
			$_SESSION['hash'] = $hash;
			$_COOKIE['pid'] = $id;
			$_COOKIE['hash'] = $hash;
	
			$Core->DEBUG[] = "Member Cookies Created!";
			
		}
		
		public static function unsetMemberCookies()
		{
			
			setcookie("pid", null, time() - 3600, '/');
			setcookie("hash", null, time() -3600, '/');
			
			$_SESSION['pid'] = 0;
			$_SESSION['hash'] = null;
			$_COOKIE['pid'] = 0;
			$_COOKIE['hash'] = null;
			
		}
			
		public static function doLogin()
		{
		
			$db = Database::getInstance();
			$SQL = $db->getConnection();
			$Core = CMS_Core::getInstance();
		
			if(  !isset( $_POST['submit_login'] ) ) throw new Exception( "No form submission has been sent!" );
			
			if( empty( $_POST['email'] ) ) throw new Exception( "You must enter an email address!" );
			
			if( empty( $_POST['password'] ) ) throw new Exception( "You must enter a password!" );
			
			$password = md5( md5($_POST['password']) + md5(CMS_CORE::$hash) );
			
			$query = $SQL->query("SELECT *
																FROM `players`
																WHERE `email` = '" . $SQL->escape_string( $_POST['email'] ) . "' AND
																`password` = '" . $SQL->escape_string( $password ) . "'
															");
														
			if($query->num_rows == 0)
			{
				throw new Exception( "The email or password you entered was incorrect!" );
			}
			
			$results = $query->fetch_assoc();
			
			self::_setMemberCookies( $results['id'], $results['password'] );
			
			$Core->getLoginUser();
			
		}
			
		public static function doLogout()
		{
		
			$Core = CMS_Core::getInstance();
		
			self::unsetMemberCookies();
			
			self::_setGuestCookies();
			
			$Core->getLoginUser();
			
		}
		
		public static function registrationSection()
		{
			$Template = Template::getInstance();

			$_Data['firstName'] = "";
			$_Data['lastName'] = "";
			$_Data['email'] = "";
			$_Data['password'] = "";
			$_Data['password2'] = "";
			$_Data['phone'] = "";
			$_Data['day'] = "";
			$_Data['month'] = "";
			$_Data['year'] = "";

			$_Types = array("text", "text", "text", "password", "password", "text", "num_day", "month", "year");
			$form = $Template->convertToForm($_Data,  $_Types);
			
			$temp = $Template->Skin['login']->haveLoginLink();
			$temp .= $Template->Skin['login']->registrationForm($form);
			return $temp;
		}
		
		public static function loginSection()
		{
			$Template = Template::getInstance();
			$tmp = "";

				$tmp .= $Template->Skin['login']->createAccountLink();
				$tmp .= $Template->Skin['login']->sectionLoginForm();

			return $tmp;
		}
	
		public static function loggedInMsg()
		{
			$Template = Template::getInstance();
			$tmp = $Template->Skin['login']->loggedIn();
			return $tmp;
		}
	
	public static function recoveryForm()
	{
		$Template = Template::getInstance();
		return $Template->Skin['login']->recovery_form();
	}
	
	public static function passwordRecovery()
	{
		$Template = Template::getInstance();
		return $Template->Skin['login']->password_recovery_form($_GET['recovery_hash']);
	}
			
	
}

?>