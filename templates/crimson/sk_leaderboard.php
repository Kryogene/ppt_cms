<?PHP

class sk_leaderboard
{

	function __construct()
	{
		// DO NOTHING
	}
	
	function leaderboardTable($title, $val, $nav="")
	{
		$html = <<<EOF
							<span class="title">{$title}</span>
						<table class='leaderboardTable'>
						<tr>
						<th>
						Player
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
						<tr>
							<td colspan=99 align="left">
							{$nav}
							</td>
						</tr>
						</table>
EOF;
		return $html;
	}

	function searchRow( $leaderboard )
	{
		$html = ("
					<tr>
						<td>
						{$leaderboard['user']}
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
	
	function searchRowByMonth( $leaderboard )
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
	
	function noResults()
	{
		$html = <<<HTML
		<tr>
			<td colspan=99>
				No Results Found!
			</td>
		</tr>
HTML;
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