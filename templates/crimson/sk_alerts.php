<?PHP

class sk_alerts
{

	function __construct()
	{
		// DO NOTHING
	}
	
	function Error($title, $msg)
	{
		$HTML = <<<HTML
		<div class='error alert'>
		
			<div class="titleBar"><img src='images/templates/default/icons/error.png'> {$title}!</div>
			
			<div class="alertMessage">
			
				$msg
				
			</div>
			
		</div>
HTML;
		return $HTML;
	}

	function Warning($title, $msg)
	{
		$HTML = <<<HTML
		<div class='warning alert'>
		
			<div class="titleBar"><img src='images/templates/default/icons/warning.png'> {$title}!</div>
			
			<div class="alertMessage">
			
				$msg
				
			</div>
			
		</div>
HTML;
		return $HTML;
	}
	
	function Success($title, $msg)
	{
		$HTML = <<<HTML
		<div class='success alert'>
		
			<div class="titleBar"><img src='images/templates/default/icons/success.png'> {$title}</div>
			
			<div class="alertMessage">
			
				{$msg}
				
			</div>
			
		</div>
HTML;
		return $HTML;
	}

}

?>