<?PHP

class sk_statistics
{
	
	function search_table( $rows, $nav="" )
	{
		
		$HTML = <<<HTML
		<table class="search_table">
			<tr>
				<th>
					Player
				</th>
				<th>
					Venue
				</th>
				<th>
					Day
				</th>
				<th>
					Month
				</th>
				<th>
					Year
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
					{$data['player_id']}
				</td>
				<td>
					{$data['venue_id']}
				</td>
				<td>
					{$data['day']}
				</td>
				<td>
					{$data['month']}
				</td>
				<td>
					{$data['year']}
				</td>
				<td>
					<a href="index.php?cat=statistics&modify&id={$data['id']}">Modify</a> | <a href="index.php?cat=statistics&delete&id={$data['id']}">Delete</a>
			</tr>
HTML;
		return $HTML;
		
	}
	
	function addForm( $content )
	{
		$HTML = <<<HTML
		<form action="index.php?cat=statistics&add" method="POST">
			{$content}
			<div>
						<input type="submit" name="addStatistics" value="Add">
			</div>
		</form>
HTML;
		return $HTML;
	}
	
	function modifyForm( $content )
	{
		$HTML = <<<HTML
		<form action="index.php?cat=statistics&search" method="POST">
			{$content}
			<div>
						<input type="submit" name="modifyStatistics" value="Update">
			</div>
		</form>
HTML;
		return $HTML;
	}
  
  function statisticHeaderBox( $options )
  {
    
    $HTML = <<<HTML
    <div class="searchBox">
				{$options['years']} {$options['months']} {$options['days']} {$options['venues']} 
			</div>
HTML;
    return $HTML;
  }
  
  function statisticTable($fields)
  {
    $HTML = <<<HTML
    <table class="statisticTable">
      <tr>
        <th>
          Player
        </th>
        <th>
          Non-Venues
        </th>
				<th>
					Venue Wins
				</th>
        <th>
          Bounties
        </th>
        <th>
          High Hands
        </th>
        <th>
          Extra Points
        </th>
        <th>
          Hands Played
        </th>
        <th>
          Event Points
        </th>
      </tr>
      {$fields}
    </table>
HTML;
    return $HTML;
  }
	
	function statisticModifyField($data)
  {
    $HTML = <<<HTML
      <tr>
        <td>
          {$data['lastName']}, {$data['firstName']}
					<input type="hidden" name="sid" value="{$data['id']}">
        </td>
        <td>
          <input type="number" name="nonvenue" value="{$data['nonvenue']}">
        </td>
				<td>
					<input type="number" name="venue_wins" value="{$data['venue_wins']}">
				</td>
        <td>
          <input type="number" name="bounty" value="{$data['bounty']}">
        </td>
        <td>
          <input type="number" name="high_hand" value="{$data['high_hand']}">
        </td>
        <td>
          <input type="number" name="xtra_points" value="{$data['xtra_points']}">
        </td>
        <td>
          <input type="number" name="hands_played" value="{$data['hands_played']}">
        </td>
        <td>
          <input type="number" name="event_points" value="{$data['event_points']}">
        </td>
      </tr>
HTML;
    return $HTML;
  }
  
  function statisticField($players)
  {
    $HTML = <<<HTML
      <tr>
        <td>
          {$players}
        </td>
        <td>
          <input type="number" name="nonvenue[]">
        </td>
				<td>
          <input type="number" name="venue_wins[]">
        </td>
        <td>
          <input type="number" name="bounty[]">
        </td>
        <td>
          <input type="number" name="high_hand[]">
        </td>
        <td>
          <input type="number" name="xtra_points[]">
        </td>
        <td>
          <input type="number" name="hands_played[]">
        </td>
        <td>
          <input type="number" name="event_points[]">
        </td>
      </tr>
HTML;
    return $HTML;
  }
  
  function statisticBodyBox( $content )
  {
    
    $HTML = <<<HTML
    <div class="bodyBox">
				{$content} 
			</div>
HTML;
    return $HTML;
  }
	
	function mainTable()
	{
		$HTML = <<<HTML
		<div class="bodyBox">
			To create and download a Comma Seperated Value (CSV) file of the statistics <a href="index.php?cat=statistics&csv">Click Here</a>.
		</div>
HTML;
		return $HTML;
	}
  
}

?>