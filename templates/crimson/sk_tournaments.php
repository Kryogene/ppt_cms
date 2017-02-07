<?PHP

class sk_tournaments
{

	function __construct()
	{
		// DO NOTHING
	}
	
	function tournamentCategory($title, $val)
	{
		global $Panel;
		$html = ("
			
					<fieldset>
						<legend>
							{$title}
						</legend>
						<table class='tournamentTable'>
						{$val}
						</table>
					</fieldset>
		");
		return $html;
	}

	function searchRow( $tournament )
	{
		global $Panel;
		$html = ("
					<tr>
						<td onclick=\"location.href='index.php?p=tournaments&id={$tournament['id']}'\">
							<a href='index.php?p=tournaments&id={$tournament['id']}'>{$tournament['venue_name']}</a>
						</td>
						<td onclick=\"location.href='index.php?p=tournaments&id={$tournament['id']}'\">
							{$tournament['month']} {$tournament['day']}, {$tournament['year']} at {$tournament['time']}
						</td>
						<td onclick=\"location.href='index.php?p=tournaments&id={$tournament['id']}'\">
							{$tournament['sh_info']}
						</td>
					</tr>
		");
		return $html;
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
	
}

?>