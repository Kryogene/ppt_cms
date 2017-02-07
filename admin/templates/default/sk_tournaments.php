<?PHP

class sk_tournaments
{

	function __construct()
	{
		// DO NOTHING
	}
	
	public function addTable( $fields )
	{
		$HTML = <<<HTML
		<form method="POST" action="index.php?cat=tournaments&add">
			<table class="dialog no_border form">
				<tr>
					<td>
						Venue: <sup>*</sup>
					</td>
					<td>
						{$fields['venue']}
					</td>
				</tr>
				<tr>
					<td>
						Day(s): <sup>*</sup>
					</td>
					<td>
						{$fields['month']} {$fields['day']} {$fields['year']} at {$fields['time']}
					</td>
				</tr>
				<tr>
					<td colspan="2">
						Description:
						<p>
							{$fields['information']}
						</p>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<input type="submit" name="addTournament" value="Add">
					</td>
				</tr>
			</table>
		</form>
HTML;
		return $HTML;
	}
	
	public function modifyTable( $fields )
	{
		$HTML = <<<HTML
		<form method="POST" action="index.php?cat=tournaments&search">
		{$fields['id']}
			<table class="dialog no_border form">
				<tr>
					<td>
						Venue: <sup>*</sup>
					</td>
					<td>
						{$fields['venue']}
					</td>
				</tr>
				<tr>
					<td>
						Day(s): <sup>*</sup>
					</td>
					<td>
						{$fields['month']} {$fields['day']} {$fields['year']} at {$fields['time']}
					</td>
				</tr>
				<tr>
					<td colspan="2">
						Description:
						<p>
							{$fields['information']}
						</p>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<input type="submit" name="modifyTournament" value="Update">
					</td>
				</tr>
			</table>
		</form>
HTML;
		return $HTML;
	}
	
	function showPublicTournament( $tournament )
	{
	$html = <<<HTML
		<p>
			<table class='publicTournamentTable'>
				<tr>
					<th colspan=3><a href="index.php?p=venues&id={$tournament['venue_id']}">{$tournament['venue_name']}</a></th>
				</tr>
				<tr>
					<td rowspan=2>
						<a href="index.php?p=venues&id={$tournament['venue_id']}"><img src="{$tournament['venue_img']}"></a>
					</td>

					<td>
						<span class='textTitle'>Date:</span>
					</td>
					<td>
						<span class='textVal'>{$tournament['month']} {$tournament['day']}, {$tournament['year']}</span>
					</td>
				</tr>
				<tr>
					<td>
						<span class='textTitle'>Time:</span>
					</td>
					<td>
						<span class='textVal'>{$tournament['time']}</span><br />
					</td>
				</tr>
				<tr>
					<td colspan=3>
						<span class='textVal'>{$tournament['lg_info']}</span>
					</td>
				</tr>
			</table>
		</p>
HTML;
		return $html;
	}
	
	function search_table( $rows, $nav="" )
	{
		
		$HTML = <<<HTML
		<table class="search_table">
			<tr>
				<th>
					Venue
				</th>
				<th>
					Start Time
				</th>
				<th>
					Date
				</th>
				<th>
					Information
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
					{$data['time']}
				</td>
				<td>
					{$data['month']} {$data['day']}, {$data['year']}
				</td>
				<td>
					{$data['information']}
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
		<a href="index.php?cat=tournaments&modify&id={$id}">
			<img src="images/icons/modify.png" alt="Modify" title="Modify">
		</a>
HTML;
		return $HTML;
	}
	
	function delete_link($id)
	{
		$HTML = <<<HTML
		<a href="index.php?cat=tournaments&delete&id={$id}">
			<img src="images/icons/delete.png" alt="Delete" title="Delete">
		</a>
HTML;
		return $HTML;
	}
	
}

?>