<?PHP

class sk_login
{

	function __construct()
	{
		// DO NOTHING
	}
	
	function loginNavigationForm()
	{
		$HTML = <<<HTML
<!-- User Login -->
			<div class='userLogin' id='loginForm'>
			
				<!-- Login Form -->
					<form action='index.php?login' name='login_form' method='POST'>
						<span class='formTextTitle'>Email:</span> <input type='text' name='email'>
						<span class='formTextTitle'>Password:</span> <input type='password' name='password'>
						<input type='submit' name='submit_login' value='LOGIN'>
					</form>
				
			</div>
			
HTML;
		return $HTML;
	}
	
	function navigationLogoutLink()
	{
		
		$HTML = <<<HTML
<!-- User Logout Link -->
			<div class='userNavOption' id='logoutLink'>
				<a href="index.php?logout">[Logout]</a>
			</div>

HTML;
		return $HTML;
		
	}
	
	function sectionLoginForm()
	{
		$HTML = <<<HTML
<!-- User Login -->
		<fieldset>
			<legend>Login Form</legend>
			<form action='index.php?login' name='login_form' method='POST'>
				<table class='userForm' id='loginForm'>
					<tr>
						<td>
							<span class='formTextTitle'>Email:</span>
						</td>
						<td>
							<input type='text' name='email'>
						</td>
					</tr>
					<tr>
						<td>
							<span class='formTextTitle'>Password:</span>
						</td>
						<td>
							<input type='password' name='password'>
						</td>
					</tr>
					<tr>
						<td colspan=2>
							<input type='submit' name='submit_login' value='LOGIN'>
						</td>
					</tr>
				</table>
			</form>
		</fieldset>
			
HTML;
		return $HTML;
	}
	
	function createAccountLink()
	{
		$HTML = <<<HTML
		<span class="haveLoginTxt">Don't have an account? <a href="index.php?p=register">Register Here!</a></span>
HTML;
		return $HTML;
	}

}

?>