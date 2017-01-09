<?PHP

class sk_venues
{

	function __construct()
	{
		// DO NOTHING
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
	
	function venueCardCategory($title, $val)
	{
		global $Panel;
		$html = ("
			
					<fieldset>
						<legend>
							{$title}
						</legend>
						{$val}
					</fieldset>
		");
		return $html;
	}

	function searchRow( $venue )
	{
		global $Panel;
		$html = ("
					<tr>
						<td onclick=\"location.href='index.php?p=venues&id={$venue['id']}'\">
							<a href='index.php?p=venues&id={$venue['id']}'>{$venue['name']}</a>
						</td>
						<td onclick=\"location.href='index.php?p=venues&id={$venue['id']}'\">
							{$venue['time']}
						</td>
						<td onclick=\"location.href='index.php?p=venues&id={$venue['id']}'\">
							{$venue['address']}<br>{$venue['city']}, {$venue['state']} {$venue['zipCode']}
						</td>
						<td onclick=\"location.href='index.php?p=venues&id={$venue['id']}'\">
							{$venue['phone']}
						</td>
						<td onclick=\"location.href='index.php?p=venues&id={$venue['id']}'\">
							{$venue['sh_desc']}<br>
							{$venue['features']}
						</td>
					</tr>
		");
		return $html;
	}
	
	function searchRowCard( $venue )
	{
		global $Panel;
		$html = ("
				<div class=\"VenueCard\" onclick=\"location.href='index.php?p=venues&id={$venue['id']}'\">
					<a href='index.php?p=venues&id={$venue['id']}'>{$venue['name']}</a>
						<img class=\"CardImg\" src=\"images/venues/no_img_mid.jpg\">
					<p>
						<b>Time:</b> {$venue['time']}
					</p>
					<p>
						{$venue['address']}<br>
						{$venue['city']}, {$venue['state']} {$venue['zipCode']}
					</p>
					<p>
						{$venue['phone']}
					</p>
					<p>
						{$venue['features']}
					</p>
				</div>

		");
		return $html;
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
	
	function FeatureImage( $data )
	{
		$html = <<<HTML
		<img alt="{$data['name']}" title="{$data['name']}" src="images/templates/default/icons/venues/{$data['img']}"> 
HTML;
		return $html;
	}
	
}

?>