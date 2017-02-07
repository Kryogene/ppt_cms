<?PHP

class sk_pages
{
  
  function search_table( $rows, $nav="" )
	{
		
		$HTML = <<<HTML
		<table class="search_table">
			<tr>
				<th>
					Title
				</th>
				<th>
					Created By
				</th>
				<th>
					Online
				</th>
				<th>
					Type
				</th>
				<th>
					Description
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
					{$data['title']}
				</td>
				<td>
					{$data['created_by']}
				</td>
				<td>
					{$data['online']}
				</td>
				<td>
					{$data['type']}
				</td>
				<td>
					{$data['description']}
				</td>
				<td>
					{$options}
				</td>
			</tr>
HTML;
		return $HTML;
		
	}
	
	function modify_link($id)
	{
		$HTML = <<<HTML
		<a href="index.php?cat=pages&modify&id={$id}">
			<img src="images/icons/modify.png" alt="Modify" title="Modify">
		</a>
HTML;
		return $HTML;
	}
	
	function default_link()
	{
		$HTML = <<<HTML
		<img src="images/icons/default.png" alt="Default" title="Default">
HTML;
		return $HTML;
	}
	
	function delete_link($id)
	{
		$HTML = <<<HTML
		<a href="index.php?cat=pages&delete&id={$id}">
			<img src="images/icons/delete.png" alt="Delete" title="Delete">
		</a>
HTML;
		return $HTML;
	}
	
	public function modifyTable( $fields )
	{
		$HTML = <<<HTML
		<form method="POST" action="index.php?cat=pages&search">
		{$fields['id']}
			<table class="dialog no_border form">
				<tr>
					<td>
						Name:
					</td>
					<td>
						{$fields['name']}
					</td>
				</tr>
				<tr>
					<td>
						Title:
					</td>
					<td>
						{$fields['title']}
					</td>
				</tr>
				<tr>
					<td>
						Description:
					</td>
					<td>
						{$fields['description']}
					</td>
				</tr>
				<tr>
					<td>
						Type:
					</td>
					<td>
						{$fields['type']}
					</td>
				</tr>
				<tr>
					<td>
						Default:
					</td>
					<td>
						{$fields['default']}
					</td>
				</tr>
				<tr>
					<td>
						Online:
					</td>
					<td>
						{$fields['online']}
					</td>
				</tr>
				<tr>
					<td colspan="2">
						Content:
						<p>
							{$fields['page_default_content']}
						</p>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<input type="submit" name="modify_page" value="Modify">
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
		<form method="POST" action="index.php?cat=pages&search">
			<table class="dialog no_border form">
				<tr>
					<td>
						Name:
					</td>
					<td>
						<input type="text" name="page_name">
					</td>
				</tr>
				<tr>
					<td>
						Title:
					</td>
					<td>
						<input type="text" name="page_title">
					</td>
				</tr>
				<tr>
					<td>
						Description:
					</td>
					<td>
						<textarea name="page_description" class="small"></textarea>
					</td>
				</tr>
				<tr>
					<td>
						Type:
					</td>
					<td>
						<input type="text" name="page_type">
					</td>
				</tr>
				<tr>
					<td>
						Default:
					</td>
					<td>
						<input type="checkbox" name="page_default" value="1">
					</td>
				</tr>
				<tr>
					<td>
						Online:
					</td>
					<td>
						<input type="checkbox" name="page_online" value="1">
					</td>
				</tr>
				<tr>
					<td colspan="2">
						Content:
						<p>
							<textarea name="page_content"></textarea>
						</p>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<input type="submit" name="create_page" value="Create">
					</td>
				</tr>
			</table>
		</form>
HTML;
		return $HTML;
	}
  
}