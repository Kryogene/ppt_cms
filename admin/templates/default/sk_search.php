<?PHP

class sk_search
{

	function __construct()
	{
		// DO NOTHING
	}
	
	function searchVenue( $search_data )
	{
		$html = <<<HTML
		<form action="index.php" method="GET">
		<input type="hidden" name="p" value="venues">
			<div class="searchBox">
				Search: <input type="text" name="search" value="{$search_data['search']}">
				<select name="day">
					<option value="all">All</option>
					{$search_data['dayOpt']}
				</select>
				<select name="orderBy">
					{$search_data['orderByOpt']}
				</select>
				<select name="order">
					{$search_data['orderOpt']}
				</select>
				<input type="submit" value="Search">
			</div>
		</form>
HTML;
		return $html;
	}
	
	function searchTournament( $search_data )
	{
		$html = <<<HTML
		<form action="index.php" method="GET">
		<input type="hidden" name="p" value="tournaments">
			<div class="searchBox">
				Search: <input type="text" name="search" value="{$search_data['search']}">
				<select name="day">
					<option value="all">All</option>
					{$search_data['dayOpt']}
				</select>
				<select name="orderBy">
					{$search_data['orderByOpt']}
				</select>
				<select name="order">
					{$search_data['orderOpt']}
				</select>
				<input type="submit" value="Search">
			</div>
		</form>
HTML;
		return $html;
	}
	
	function selectOption( $name, $val, $selected = "" )
	{
		$html = <<<HTML
		<option value="{$val}" {$selected}>{$name}</option>
HTML;
		return $html;
	}
	
	function searchBox( $fields, $hidden_additions="" )
	{
		$html = <<<HTML
		<form action="index.php" method="GET">
		<input type="hidden" name="cat" value="{$_GET['cat']}">
		{$hidden_additions}
			<div class="searchBox">
				{$fields}
				<input type="submit" value="Search">
			</div>
		</form>
HTML;
		return $html;
	}
	
	function goToBeginning( $query )
	{
		$html = <<<HTML
		<span style="margin: 0 10px 0 10px; float: left;"><a href="index.php?{$query}"><<</a></span>
HTML;
		return $html;
	}
	
	function goBackOnePage( $query )
	{
		$html = <<<HTML
		<span style="margin: 0 10px 0 10px; float: left;"><a href="index.php?{$query}"><</a></span>
HTML;
		return $html;
	}
	
	function goForwardOnePage( $query )
	{
		$html = <<<HTML
		<span style="margin: 0 10px 0 10px; float: right;"><a href="index.php?{$query}">></a></span>
HTML;
		return $html;
	}
	
	function goToLast( $query )
	{
		$html = <<<HTML
		<span style="margin: 0 10px 0 10px; float: right;"><a href="index.php?{$query}">>></a></span>
HTML;
		return $html;
	}
	
}

?>