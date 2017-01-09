<?PHP

class sk_announcements
{
  
  function search_table( $rows, $nav="" )
	{
		
		$HTML = <<<HTML
		<table class="search_table">
			<tr>
				<th>
					Author
				</th>
				<th>
					Subject
				</th>
				<th>
					Content
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
					{$data['created_by']}
				</td>
				<td>
					{$data['subject']}
				</td>
				<td>
					{$data['content']}
				</td>
				<td>
					<a href="index.php?cat=announcements&modify&id={$data['id']}">Modify</a> | <a href="index.php?cat=announcements&delete&id={$data['id']}">Delete</a>
			</tr>
HTML;
		return $HTML;
		
	}
	
	
	public function modifyTable( $fields )
	{
		$HTML = <<<HTML
		<form method="POST" action="index.php?cat=announcements&search">
		{$fields['id']}
			<table class="profileTable">
				<tr>
					<td>
						Subject:
					</td>
					<td>
						{$fields['subject']}
					</td>
				</tr>
				<tr>
					<td colspan="2">
						Article:
						<p>
							{$fields['content']}
						</p>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<input type="submit" name="modifyAnnouncement" value="Post">
					</td>
				</tr>
			</table>
		</form>
HTML;
		return $HTML;
	}
	
	public function createTable()
	{
		$HTML = <<<HTML
		<form method="POST" action="index.php?cat=announcements&search">
			<table class="profileTable">
				<tr>
					<td>
						Subject:
					</td>
					<td>
						<input type="text" name="subject">
					</td>
				</tr>
				<tr>
					<td colspan="2">
						Article:
						<p>
							<textarea name="content"></textarea>
						</p>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<input type="submit" name="postAnnouncement" value="Post">
					</td>
				</tr>
			</table>
		</form>
HTML;
		return $HTML;
	}
  
}