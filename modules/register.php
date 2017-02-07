<?PHP

class Register
{

	public $DEBUG;

	public function __construct()
	{
	
	}
			
		public static function doRegister()
		{
		
			$db = Database::getInstance();
			$SQL = $db->getConnection();
			$Core = CMS_Core::getInstance();
		
			if(  !isset( $_POST['submit_registration'] ) ) throw new Exception( "No form submission has been sent!" );
			
			if( empty( $_POST['firstName'] ) ) throw new Exception( "You must enter a First Name!" );
			
			if( empty( $_POST['lastName'] ) ) throw new Exception( "You must enter a Last Name!" );
			
			if( empty( $_POST['email'] ) ) throw new Exception( "You must enter an email address!" );
			
			$email = explode("@", $_POST['email']);
			
			if( !isset($email[1]) ) throw new Exception( "You must enter a valid email address!" );
			$ext = explode(".", $email[1]);
			if( !isset($ext[1]) ) throw new Exception( "You must enter a valid email address!" );
			
			if( empty( $_POST['password'] ) ) throw new Exception( "You must enter a password!" );
			
			if( strlen($_POST['password']) < 5 ) throw new Exception( "Your password must exceed more than 5 characters!" );
			
			$whitespace = explode(" ", $_POST['password']);
			if( isset($whitespace[1]) ) throw new Exception( "Spaces are not allowed in your password!" );
			
			if( $_POST['password'] != $_POST['password2'] ) throw new Exception( "Passwords do not match!" );
			
			if( !self::_validateAge( $_POST['month'] . "/" . $_POST['day'] . "/" . $_POST['year'], 21 ) ) throw new Exception( "You must at least be 21 to register!" );
			
			$_POST['password'] = md5( md5($_POST['password']) + md5(CMS_CORE::$hash) );
			$dob = date("F", $_POST['month']) . " " . $_POST['day'] . ", " . $_POST['year'];
			
			$query = $SQL->query("INSERT INTO `players` VALUES (null,
																'" . $SQL->escape_string( $_POST['password'] ) . "',
																'" . $SQL->escape_string( time() ) . "',
																'" . $SQL->escape_string( 'Registration' ) . "',
																'',
																'',
																'3',
																'" . $SQL->escape_string( $_POST['lastName'] ) . "',
																'" . $SQL->escape_string( $_POST['firstName'] ) . "',
																'" . $SQL->escape_string( $_POST['email'] ) . "',
																'" . $SQL->escape_string( $dob ) . "',
																'" . $SQL->escape_string( $_POST['phone'] ) . "')
							");
			if(!$query)
				throw new Exception( "There was a problem with sending your information, please try again shortly!" );
			
			$query = $SQL->query("INSERT INTO `player_settings` VALUES (null, '" . Template::defaultTemplate() . "')");
			if(!$query)
				throw new Exception( "There was a problem with creating your personal settings, please try updating them later!" );
			
		}
	
	// validate birthday
private static function _validateAge($birthday, $age = 21)
{
    // $birthday can be UNIX_TIMESTAMP or just a string-date.
    if(is_string($birthday)) {
        $birthday = strtotime($birthday);
    }

    // check
    // 31536000 is the number of seconds in a 365 days year.
    if(time() - $birthday < $age * 31536000)  {
        return false;
    }

    return true;
}
		
}

?>