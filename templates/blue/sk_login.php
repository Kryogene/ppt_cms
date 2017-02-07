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
					<form action='index.php?p=login' name='login_form' method='POST'>
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
				<a href="index.php?p=login&logout">[Logout]</a>
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
			<form action='index.php?p=login' name='login_form' method='POST'>
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
						<a href="index.php?p=login&forgot"><span style="font-size: 10px;">Forgot Password or First Time Access?</span></a><br>
							<input type='submit' name='submit_login' value='LOGIN'>
						</td>
					</tr>
				</table>
			</form>
		</fieldset>
			
HTML;
		return $HTML;
	}
	
	function recovery_form()
	{
		$HTML = <<<HTML
		<span class="small-text">
			If you forgot your password or registered at an event you can recover your account simply by entering your email below and checking your email. If you do not have an email registered with us but are registered as a player please contact us HERE with your email address so we can set-up your account!
		</span>
		<form action="index.php?p=login&forgot" method="POST">
		<table class="centered menu">
			<tr>
				<td>
					Email:
				</td>
				<td>
					<input type="text" name="email">
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<input type="submit" name="recover" value="Recover">
				</td>
			</tr>
		</table>
		</form>
HTML;
		return $HTML;
	}
	
	function password_recovery_form($hash)
	{
		$HTML = <<<HTML
		<form action="index.php?p=login&recovery_hash={$hash}" method="POST">
		<table class="centered menu">
			<tr>
				<td>
					New Password:
				</td>
				<td>
					<input type="password" name="password">
				</td>
			</tr>
			<tr>
				<td>
					Re-Enter New Password:
				</td>
				<td>
					<input type="password" name="password2">
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<input type="submit" name="new_password" value="Save">
				</td>
			</tr>
		</table>
		</form>
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
	
	function loggedIn()
	{
		$HTML = <<<HTML
		<div class="light dialog">
			<p>
				<span class="small">You will be redirected shortly...</span>
			</p>
		</div>
		<script>
    window.setTimeout(function(){

        // Redirect
        window.location = "index.php?p=home";

    }, 3000);
		</script>
HTML;
		return $HTML;
	}
	
	function registrationForm($fields)
	{
		$HTML = <<<HTML
<!-- User Registration -->
		<fieldset>
			<legend>Registration Form</legend>
			<form action='index.php?p=register' name='registration_form' method='POST'>
				<table class='userForm' id='registrationForm'>
					<tr>
						<td>
							<span class='formTextTitle'>First Name:</span>
						</td>
						<td>
							{$fields['firstName']}
						</td>
					</tr>
					<tr>
						<td>
							<span class='formTextTitle'>Last Name:</span>
						</td>
						<td>
							{$fields['lastName']}
						</td>
					</tr>
					<tr>
						<td>
							<span class='formTextTitle'>Email:</span>
						</td>
						<td>
							{$fields['email']}
						</td>
					</tr>
					<tr>
						<td>
							<span class='formTextTitle'>Password:</span>
						</td>
						<td>
							{$fields['password']}
						</td>
					</tr>
					<tr>
						<td>
							<span class='formTextTitle'>Re-Enter Password:</span>
						</td>
						<td>
							{$fields['password2']}
						</td>
					</tr>
					<tr>
						<td>
							<span class='formTextTitle'>Phone:</span>
						</td>
						<td>
							{$fields['phone']}
						</td>
					</tr>
					<tr>
						<td>
							<span class='formTextTitle'>Date of Birth:</span>
						</td>
						<td>
							{$fields['month']} {$fields['day']} {$fields['year']}
						</td>
					</tr>
					<tr>
						<td colspan=2>
							<input type='submit' name='submit_registration' value='Register'>
						</td>
					</tr>
				</table>
			</form>
		</fieldset>
			
HTML;
		return $HTML;
	}
	
	public function haveLoginLink()
	{
		$HTML = <<<HTML
		<span class="needAccountTxt">Already have an account? <a href="index.php?p=login">Login Here!</a></span>
HTML;
		return $HTML;
	}

}

?>