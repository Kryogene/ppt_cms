<?PHP

class sk_venues
{

	function __construct()
	{
		// DO NOTHING
	}
	
	public function addTable( $fields )
	{
		$HTML = <<<HTML
		<form method="POST" action="index.php?cat=venues&add">
			<table class="dialog no_border form">
				<tr>
					<td>
						Venue Name: <sup>*</sup>
					</td>
					<td>
						{$fields['name']}
					</td>
				</tr>
				<tr>
					<td>
						Day(s): <sup>*</sup>
					</td>
					<td>
						<div style="float:left;margin: 3px;">{$fields['weekday']}</div><div style="float:left;margin: 3px;">{$fields['startTime']}</div>
					</td>
				</tr>
				<tr>
					<td>
						Address: <sup>*</sup>
					</td>
					<td>
						{$fields['address']}
					</td>
				</tr>
				<tr>
					<td>
						City: <sup>*</sup>
					</td>
					<td>
						{$fields['city']}
					</td>
				</tr>
				<tr>
					<td>
						State: <sup>*</sup>
					</td>
					<td>
						{$fields['state']}
					</td>
				</tr>
				<tr>
					<td>
						Zip Code: <sup>*</sup>
					</td>
					<td>
						{$fields['zipCode']}
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
						Features:
					</td>
					<td>
						{$fields['features']}
					</td>
				</tr>
				<tr>
					<td colspan="2">
						Description:
						<p>
							{$fields['description']}
						</p>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<input type="submit" name="addVenue" value="Add">
					</td>
				</tr>
			</table>
		</form>
HTML;
		return $HTML;
	}
	
	function venueCategory($title, $val)
	{
		global $Panel;
		$html = ("
			
					<fieldset>
						<legend>
							{$title}
						</legend>
						<table class='venueTable'>
						{$val}
						</table>
					</fieldset>
		");
		return $html;
	}
	
	function search_table( $rows, $nav="" )
	{
		
		$HTML = <<<HTML
		<table class="search_table">
			<tr>
				<th>
					Name
				</th>
				<th>
					Start Time
				</th>
				<th>
					Day
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
					{$data['name']}
				</td>
				<td>
					{$data['startTime']}
				</td>
				<td>
					{$data['weekday']}
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
		<a href="index.php?cat=venues&modify&id={$id}">
			<img src="images/icons/modify.png" alt="Modify" title="Modify">
		</a>
HTML;
		return $HTML;
	}
	
	function delete_link($id)
	{
		$HTML = <<<HTML
		<a href="index.php?cat=venues&deactivate&id={$id}">
			<img src="images/icons/deactivate.png" alt="Deactivate" title="Deactivate">
		</a>
HTML;
		return $HTML;
	}
	
	public function modifyTable( $fields )
	{
		$HTML = <<<HTML
		<form method="POST" action="index.php?cat=venues&search">
		{$fields['id']}
			<table class="dialog no_border form">
				<tr>
					<td>
						Venue Name:
					</td>
					<td>
						{$fields['name']}
					</td>
				</tr>
				<tr>
					<td>
						Day(s):
					</td>
					<td>
						<div style="float:left;margin: 3px;">{$fields['weekday']}</div><div style="float:left;margin: 3px;">{$fields['startTime']}</div>
					</td>
				</tr>
				<tr>
					<td>
						Address:
					</td>
					<td>
						{$fields['address']}
					</td>
				</tr>
				<tr>
					<td>
						City:
					</td>
					<td>
						{$fields['city']}
					</td>
				</tr>
				<tr>
					<td>
						State:
					</td>
					<td>
						{$fields['state']}
					</td>
				</tr>
				<tr>
					<td>
						Zip Code:
					</td>
					<td>
						{$fields['zipCode']}
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
						Features:
					</td>
					<td>
						{$fields['features']}
					</td>
				</tr>
				<tr>
					<td colspan="2">
						Description:
						<p>
							{$fields['description']}
						</p>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<input type="submit" name="modifyVenue" value="Update">
					</td>
				</tr>
			</table>
		</form>
HTML;
		return $HTML;
	}
	
}

?>