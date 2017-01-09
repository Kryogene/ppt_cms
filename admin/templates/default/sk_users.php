<?PHP

class sk_users
{

	function __construct()
	{
		// DO NOTHING
	}
	
	function navigationWelcome( $name )
	{
		$HTML = <<<HTML
<!-- User Login -->
			<div class='navWelcome' id='welcomeMsg'>
				<!-- Login Form -->
					Welcome Back, {$name}!
			</div>
			
HTML;
		return $HTML;
	}
	
	function navigationSettingsIcon()
	{
	
		$HTML = <<<HTML
			<a href="index.php?p=user&settings">
				<div class='userNavOption navLink' id='settingsIcon'>
					<span class="navLink"> </span>
				</div>
			</a>

HTML;
		return $HTML;
		
	}
		
	function navigationUserPanelIcon()
	{
	
		$HTML = <<<HTML
			<a href="index.php?p=user&update">
				<div class='userNavOption navLink' id='userPanelIcon'>
					<span class="navLink"> </span>
				</div>
			</a>

HTML;
		return $HTML;
		
	}
	
	function navigationMailIcon()
	{
	
		$HTML = <<<HTML
			<a href="index.php?p=user&mail">
				<div class='userNavOption navLink' id='mailIcon'>
					<span class="navLink"> </span>
				</div>
			</a>

HTML;
		return $HTML;
		
	}
	
	function navigationUnReadMailIcon($unread = 0)
	{
	
		$HTML = <<<HTML
			<a href="index.php?p=user&mail">
				<div class='userNavOption navLink' id='mailIcon'>
					<span class="navLink">{$unread}</span>
				</div>
			</a>

HTML;
		return $HTML;
		
	}
	
	function navigationStatisticsIcon()
	{
	
		$HTML = <<<HTML
			<a href="index.php?p=user&statistics">
				<div class='userNavOption navLink' id='statisticsIcon'>
					<span class="navLink"> </span>
				</div>
			</a>

HTML;
		return $HTML;
		
	}
	
	function navigationAdminIcon()
	{
	
		$HTML = <<<HTML
			<a href="index.php?p=admin">
				<div class='userNavOption navALink' id='adminIcon'>
					<span class="navLink"> </span>
				</div>
			</a>

HTML;
		return $HTML;
		
	}
	
	function settingsForm( $setting )
	{
	
		$HTML = <<<HTML
<fieldset>
	<legend> User Settings </legend>
	
	<form action='index.php?p=user&settings' name='settingsForm' method='POST'>	
		<table class='settingsFormTable' id='settingsFormTable'>
			<tr>
				<td><h4>Template:</span></h4>
				<td> <input type='text' name='template_id' value='{$setting['template_id']}'> </td>
			</tr>
			<tr>
				<td colspan='2'>
					<input type='submit' name='submitSettings' value='Submit'>
				</td>
			</tr>
		</table>
	</form>
</fieldset>
HTML;
		return $HTML;
		
	}
	
	function profileForm( $user )
	{
	
		$HTML = <<<HTML
<fieldset>
	<legend> Update Account </legend>
	
	<form action='index.php?p=user&profile' name='profileForm' method='POST'>	
		<table class='profileFormTable' id='profileFormTable'>
			<tr>
				<td><h4>First Name:</span></h4>
				<td> <input type='text' name='firstName' value='{$user['firstName']}'> </td>
			</tr>
			<tr>
				<td><h4>Last Name:</span></h4>
				<td> <input type='text' name='lastName' value='{$user['lastName']}'> </td>
			</tr>
			<tr>
				<td><h4>Email:</span></h4>
				<td> <input type='text' name='email' value='{$user['email']}'> </td>
			</tr>
			<tr>
				<td><h4>Phone:</span></h4>
				<td> <input type='text' name='phone' value='{$user['phone']}'> </td>
			</tr>
			<tr>
				<td colspan='2'>
					<input type='submit' name='submitProfile' value='Submit'>
				</td>
			</tr>
		</table>
	</form>
</fieldset>
HTML;
		return $HTML;
		
	}
	
	function mailBoxMain( $unread, $total, $messages, $toolbar )
	{
	
		$HTML = <<<HTML
<fieldset>
	<legend> Mailbox </legend>
	
	<i>You have <b>{$unread}</b> Unread message(s) out of <b>{$total}</b>.</i>
	
	{$toolbar}

		<table class='mailBoxTable main' id='mailBox'>
			<tr>
				<th class="selection">
					 
				</th>
				<th class="from">
					From
				</th>
				<th class="subject">
					Subject
				</th>
				<th class="message">
					Message
				</th>
			</tr>
			{$messages}
		</table>
		
	{$toolbar}
		
</fieldset>
HTML;
		return $HTML;	
	}
	
	function mailBoxToolbar( $tools )
	{
		$HTML = <<<HTML
		<div class="mailBoxToolbar"> <input type="button" name="composeMessage" value="Compose" onclick="location.href='index.php?p=user&mail&compose'">
		{$tools}
		</div>
HTML;
		return $HTML;
	}
	
	function mainMailTools()
	{
		$HTML = <<<HTML
<form id="markForm" action="index.php?p=user&mail" method="post">
	Mark As <select name="mark" onchange="this.form.submit()">
		<option disabled selected hidden> </option>
		<option value="0">Read</option>
		<option value="1">Unread</option>
	</select>
	<input type="submit" id="delete" name="deleteMail" value="Delete">
</form>
HTML;
		return $HTML;
	}
	
	function defaultNoMailMessages()
	{
		$HTML = <<<HTML
		<tr>
			<td colspan=99>
				<div class="noMessages">No Messages Found!</div>
			</td>
		</tr>
HTML;
		return $HTML;
	}
	
	function noMessageExists()
	{
		$HTML = <<<HTML
				<div class="noMessages">The message you are looking for does not exist!</div>
HTML;
		return $HTML;
	}
	
	function readMailMessage( $message )
	{
		$HTML = <<<HTML
		<tr>
			<td>
				<input form="markForm" type="checkbox" name="message[]" value={$message['id']}>
			</td>
			<td onclick="location.href='index.php?p=user&mail&id={$message['id']}'">
				{$message['sender']}
			</td>
			<td onclick="location.href='index.php?p=user&mail&id={$message['id']}'">
				{$message['subject']}
			</td>
			<td onclick="location.href='index.php?p=user&mail&id={$message['id']}'">
				{$message['message']}
			</td>
		</tr>
HTML;
		return $HTML;
	}
	
	function unreadMailMessage( $message )
	{
		$HTML = <<<HTML
		<tr>
			<td class="selection">
				<input form="markForm" type="checkbox" name="message[]" value={$message['id']}>
			</td>
			<td class="from" onclick="location.href='index.php?p=user&mail&id={$message['id']}'">
				<span class="unread">{$message['sender']}</span>
			</td>
			<td class="subject" onclick="location.href='index.php?p=user&mail&id={$message['id']}'">
				<span class="unread">{$message['subject']}</span>
			</td>
			<td class="message" onclick="location.href='index.php?p=user&mail&id={$message['id']}'">
				<span class="unread">{$message['message']}</span>
			</td>
		</tr>
HTML;
		return $HTML;
	}
	
	function showMessage( $message )
	{
		$HTML = <<<HTML
<fieldset>
	<legend> Mailbox > {$message['subject']} </legend>

		<table class='mailBoxTable' id='mailBox'>
			<tr>
				<td>
					<span class="mailText">From:</span> {$message['sender_id']}
				</td>
			</tr>
			<tr>
				<td>
					<span class="mailText">Subject:</span> {$message['subject']}
				</td>
			</tr>
			<tr>
				<td>
					{$message['message']}
				</td>
			</tr>
		</table>
		
</fieldset>
HTML;
		return $HTML;
	}
	
	function composeMailForm()
	{
	
		$HTML = <<<HTML
<fieldset>
	<legend> Mailbox > Compose </legend>
	
	<form action='index.php?p=user&mail' name='composeMailForm' method='POST'>	
		<table class='composeMailFormTable' id='composeMailFormTable'>
			<tr>
				<td><h4>To:</span></h4>
				<td> <input type='text' name='to'> </td>
			</tr>
			<tr>
				<td><h4>Subject:</span></h4>
				<td> <input type='text' name='subject'> </td>
			</tr>
			<tr>
				<td><h4>Message:</span></h4>
				<td> <textarea name='message' class="composeMsg"></textarea></td>
			</tr>
			<tr>
				<td colspan='2'>
					<input type='submit' name='sendMail' value='Send'>
				</td>
			</tr>
		</table>
	</form>
</fieldset>
HTML;
		return $HTML;
		
	}
	
	function userStatistics( $statistic )
	{
	
		$HTML = <<<HTML
<fieldset>
	<legend> Statistics </legend>

		<table class='uStatisticsTable' id='user_statistics'>
			<tr>
				<td>
					{$statistic}
				</td>
			</tr>
		</table>
	</form>
</fieldset>
HTML;
		return $HTML;
		
	}
	
		function search_table( $rows, $nav="" )
	{
		
		$HTML = <<<HTML
		<table class="search_table">
			<tr>
				<th>
					Last Name
				</th>
				<th>
					First Name
				</th>
				<th>
					Email
				</th>
				<th>
					Phone
				</th>
				<th>
					User Group
				</th>
				<th>
					Options
				</th>
			</tr>
			{$rows}
			<tr>
			<td colspan=6>
			{$nav}
			</td>
			</tr>
		</table>
HTML;
		return $HTML;
		
	}
	
	function search_row( $data )
	{
		
		$HTML = <<<HTML
			<tr>
				<td>
					{$data['lastName']}
				</td>
				<td>
					{$data['firstName']}
				</td>
				<td>
					{$data['email']}
				</td>
				<td>
					{$data['phone']}
				</td>
				<td>
					{$data['type']}
				</td>
				<td>
					<a href="index.php?cat=users&modify&id={$data['id']}">Modify</a> | <a href="index.php?cat=users&delete&id={$data['id']}">Delete</a>
			</tr>
HTML;
		return $HTML;
		
	}
	
		public function profileTable( $fields )
	{
		$HTML = <<<HTML
		<form method="POST">
		{$fields['id']}
			<table class="profileTable">
				<tr>
					<td>
						First Name:
					</td>
					<td>
						{$fields['firstName']}
					</td>
				</tr>
				<tr>
					<td>
						Last Name:
					</td>
					<td>
						{$fields['lastName']}
					</td>
				</tr>
				<tr>
					<td>
						Password:
					</td>
					<td>
						{$fields['password']}
					</td>
				</tr>
				<tr>
					<td>
						Email:
					</td>
					<td>
						{$fields['email']}
					</td>
				</tr>
				<tr>
					<td>
						Phone:
					</td>
					<td>
						{$fields['phone']}
					</td>
				</tr>
				<tr>
					<td>
						Group:
					</td>
					<td>
						{$fields['type']}
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<input type="submit" name="updateProfile" value="Update">
					</td>
				</tr>
			</table>
		</form>
HTML;
		return $HTML;
	}
	
	function confirmForm($field)
	{
				$HTML = <<<HTML
		<form method="POST" action="index.php?cat=users&search">
		{$field['id']}
			<div class="confirm">
			<p>
				Are you sure you wish to continue?
			</p>
						<input type="submit" name="confirmDelete" value="Confirm">
			</div>
		</form>
HTML;
		return $HTML;
	}

}

?>