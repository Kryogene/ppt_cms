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
			<table class="profileTable">
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
						<div style="float:left;margin: 3px;">{$fields['day']}</div><div style="float:left;margin: 3px;">{$fields['startTime']}</div>
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
					Address
				</th>
				<th>
					City
				</th>
				<th>
					State
				</th>
				<th>
					Zip Code
				</th>
				<th>
					Phone
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

	function search_row( $data )
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
					{$data['day']}
				</td>
				<td>
					{$data['address']}
				</td>
				<td>
					{$data['city']}
				</td>
				<td>
					{$data['state']}
				</td>
				<td>
					{$data['zipCode']}
				</td>
				<td>
					{$data['phone']}
				</td>
				<td>
					{$data['description']}
				</td>
				<td>
					<a href="index.php?cat=venues&modify&id={$data['id']}">Modify</a> | <a href="index.php?cat=venues&deactivate&id={$data['id']}">Deactivate</a>
			</tr>
HTML;
		return $HTML;
		
	}
	
	public function modifyTable( $fields )
	{
		$HTML = <<<HTML
		<form method="POST" action="index.php?cat=venues&search">
		{$fields['id']}
			<table class="profileTable">
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
						<div style="float:left;margin: 3px;">{$fields['day']}</div><div style="float:left;margin: 3px;">{$fields['startTime']}</div>
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
	
	function showPublicVenue( $venue )
	{
	$html = <<<HTML
		<p>
			<table class='publicVenueTable'>
				<tr>
					<th colspan=3>{$venue['name']}</th>
				</tr>
				<tr>
					<td rowspan=4>
						<img src="{$venue['img']}">
					</td>

					<td>
						<span class='textTitle'>Day and Time:</span>
					</td>
					<td>
						<span class='textVal'>{$venue['dayAndTime']}</span>
					</td>
				</tr>
				<tr>
					<td>
						<span class='textTitle'>Address:</span>
					</td>
					<td>
						<span class='textVal'>{$venue['address']}</span><br />
						<span class='textVal'>{$venue['city']}, {$venue['state']} {$venue['zipCode']}</span>
					</td>
				</tr>
				<tr>
					<td>
						<span class='textTitle'>Phone:</span>
					</td>
					<td>
						<span class='textVal'>{$venue['phone']}</span>
					</td>
				</tr>
				<tr>
					<td>
						<span class='textTitle'>Features:</span>
					</td>
					<td>
						{$venue['features_txt']}
					</td>
				</tr>
				<tr>
					<td colspan=3>
						<span class='textVal'>{$venue['lg_desc']}</span>
					</td>
				</tr>
			</table>
		</p>
HTML;
		return $html;
	}
	
}

?>