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
  
  function search_row( $data, $options )
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
					{$options}
			</tr>
HTML;
		return $HTML;
		
	}
	
	function modify_link($id)
	{
		$HTML = <<<HTML
		<a href="index.php?cat=announcements&modify&id={$id}">
			<img src="images/icons/modify.png" alt="Modify" title="Modify">
		</a>
HTML;
		return $HTML;
	}
	
	function delete_link($id)
	{
		$HTML = <<<HTML
		<a href="index.php?cat=announcements&delete&id={$id}">
			<img src="images/icons/delete.png" alt="Delete" title="Delete">
		</a>
HTML;
		return $HTML;
	}
	
	
	public function modifyTable( $fields )
	{
		$HTML = <<<HTML
		<form method="POST" action="index.php?cat=announcements&search">
		{$fields['id']}
			<table class="dialog no_border form">
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
			<table class="dialog no_border form">
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