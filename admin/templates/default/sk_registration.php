<?PHP

class sk_registration
{
	
	function registrationForm()
	{
		$HTML = <<<HTML
<!-- User Registration -->
		<fieldset>
			<legend>Registration Form</legend>
			<form action='index.php?p=registration' name='registration_form' method='POST'>
				<table class='userForm' id='registrationForm'>
					<tr>
						<td>
							<span class='formTextTitle'>First Name:</span>
						</td>
						<td>
							<input type='text' name='email'>
						</td>
					</tr>
					<tr>
						<td>
							<span class='formTextTitle'>Last Name:</span>
						</td>
						<td>
							<input type='text' name='email'>
						</td>
					</tr>
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