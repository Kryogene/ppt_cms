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
					<img src="images/templates/blue/icons/settings.png" alt="Settings" title="Settings">
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
					<img src="images/templates/blue/icons/userpanel.png" alt="User Panel" title="User Panel">
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
					<img src="images/templates/blue/icons/mail.png" alt="Mail" title="Mail">
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
					<img src="images/templates/blue/icons/statistics.png" alt="Statistics" title="Statistics">
				</div>
			</a>

HTML;
		return $HTML;
		
	}
	
	function navigationAdminIcon()
	{
	
		$HTML = <<<HTML
			<a href="index.php?p=admin" target="_blank">
				<div class='userNavOption navALink' id='adminIcon'>
					Admin
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
				<td> {$setting['template_id']}</td>
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
	
	<form action='index.php?p=user&update' name='profileForm' method='POST'>	
		<table class='profileFormTable' id='profileFormTable'>
			<tr>
				<td><h4>Name:</span></h4>
				<td> {$user['firstName']} {$user['lastName']} </td>
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
				<th class="senton">
					Sent On
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
				{$message['date']}
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
			<td class="date" onclick="location.href='index.php?p=user&mail&id={$message['id']}'">
				<span class="unread">{$message['date']}</span>
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
					<span class="mailText">From:</span>
				</td>
				<td>
					{$message['sender_name']}
				</td>
			</tr>
			<tr>
				<td>
					<span class="mailText">To:</span>
				</td>
				<td>
					{$message['recipients']}
				</td>
			</tr>
			<tr>
				<td>
					<span class="mailText">Subject:</span>
				</td>
				<td>
					{$message['subject']}
				</td>
			</tr>
			<tr>
				<td colspan="2">
				<p class="indent">
					{$message['message']}
				</p>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<div class="forward"><input type="button" onclick="location.href='index.php?p=user&mail&id={$message['id']}&forward'" name="forward" value="Forward"></div>
					<div class="reply"><input type="button" onclick="location.href='index.php?p=user&mail&id={$message['id']}&reply'" name="reply" value="Reply"><input type="button" onclick="location.href='index.php?p=user&mail&id={$message['id']}&reply&all'" name="replyAll" value="Reply All"></div>
				</td>
			</tr>
		</table>
		
</fieldset>
HTML;
		return $HTML;
	}
	
	function recipientBox($user)
	{
		$HTML = <<<HTML
		<div class="to_recipient">{$user}</div>
HTML;
		return $HTML;
	}
	
	function composeMailForm( $data = array('subject' => '', 'message' => '') )
	{
	
		$HTML = <<<HTML
<fieldset>
	<legend> Mailbox > Compose </legend>
	
	<form action='index.php?p=user&mail&compose' name='composeMailForm' method='POST'>	
		<table class='composeMailFormTable' id='composeMailFormTable'>
			<tr>
				<td><h4>To:</span></h4>
				<td> 	<div id="to_list"></div>
							<input type='text' name='to_search' id="to_search" oninput="search_load()">
							<div id="datalist"><div class="inner"><div class="exit"></div><div id="customdatalist"></div></div></div>
				</td>
			</tr>
			<tr>
				<td><h4>Subject:</span></h4>
				<td> <input type='text' name='subject' value='{$data['subject']}'> </td>
			</tr>
			<tr>
				<td><h4>Message:</span></h4>
				<td> <textarea name='message' class="composeMsg">{$data['message']}</textarea></td>
			</tr>
			<tr>
				<td colspan='2'>
					<input type='submit' name='sendMail' value='Send'>
				</td>
			</tr>
		</table>
	</form>
</fieldset>
<script type="text/javascript" src="scripts/mail-users_search.js"></script>
HTML;
		return $HTML;
		
	}
	
function replyMailForm($data)
	{
	
		$HTML = <<<HTML
<fieldset>
	<legend> Mailbox > Compose </legend>
	
	<form action='index.php?p=user&mail&compose' name='composeMailForm' method='POST'>	
		<table class='composeMailFormTable' id='composeMailFormTable'>
			<tr>
				<td><h4>To:</span></h4>
				<td> 	<div id="to_list" style="display: block;">{$data['receivers']}</div>
							<input type='text' name='to_search' id="to_search" oninput="search_load()">
							<div id="datalist"><div class="inner"><div class="exit"></div><div id="customdatalist"></div></div></div>
				</td>
			</tr>
			<tr>
				<td><h4>Subject:</span></h4>
				<td> <input type='text' name='subject' value='Reply:{$data['subject']}'> </td>
			</tr>
			<tr>
				<td><h4>Message:</span></h4>
				<td> 
					<textarea name='message' class="composeMsg">{$data['message']}</textarea>
				</td>
			</tr>
			<tr>
				<td colspan='2'>
					<input type='submit' name='sendMail' value='Send'>
				</td>
			</tr>
		</table>
	</form>
</fieldset>
<script type="text/javascript" src="scripts/mail-users_search.js"></script>
HTML;
		return $HTML;
		
	}
	
	function replyMessageWrapper( $data )
	{
		$HTML = <<<HTML




//---------------------------------\\\\
FROM: {$data['sender']}
TO: {$data['recipients']}
SUBJECT: {$data['subject']}
{$data['message']}
HTML;
		return $HTML;
	}
	
	function receiverBox( $uid, $name )
	{
		$HTML = <<<HTML
		<div class='to_recipient' id='{$uid}'>
			<div class='exit' onclick='remove_to({$uid})'></div>
			<input type='hidden' name='to[]' value='{$uid}'>
			{$name}
		</div>
HTML;
		return $HTML;
	}
	
	function userStatistics( $statistic )
	{
		$statistic = "Test Array"; // Because of notice
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
	
	function leaderboardTableHeader($title, $val)
	{
		$html = ("
		
		<fieldset>
			<legend>{$title}</legend>

						<table class='leaderboardTable'>
						<tr>
						<th>
						Month
						</th>
						<th>
						NonVenue
						</th>
						<th>
						Bounties
						</th>
						<th>
						Total Wins
						</th>
						<th>
						High Hand
						</th>
						<th>
						Xtra Points
						</th>
						<th>
						Hands Played
						</th>
						<th>
						Event Points
						</th>
						<th>
						Chip Bonus
						</th>
						<th>
						Chip Total
						</th>
						<th>
						Total Points
						</th>
						<th>
						Points YTD
						</th>
						</tr>
						{$val}
						</table>
			</fieldset>
		");
		return $html;
	}

	function leaderboardSearchRow( $leaderboard )
	{
		$html = ("
					<tr>
						<td>
						{$leaderboard['month']}
						<td>
						{$leaderboard['nonvenue']}
						</td>
						<td>
						{$leaderboard['bounty']}
						</td>
						<td>
						{$leaderboard['total_wins']}
						</td>
						<td>
						{$leaderboard['high_hand']}
						</td>
						<td>
						{$leaderboard['xtra_points']}
						</td>
						<td>
						{$leaderboard['hands_played']}
						</td>
						<td>
						{$leaderboard['event_points']}
						</td>
						<td>
						{$leaderboard['chip_bonus_vnv']}
						</td>
						<td>
						{$leaderboard['chip_total']}
						</td>
						<td>
						{$leaderboard['point_total']}
						</td>
						<td>
						{$leaderboard['points_ytd']}
						</td>
					</tr>
		");
		return $html;
	}

}

?>