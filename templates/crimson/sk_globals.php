<?PHP

class sk_globals
{

	function __construct()
	{
		// DO NOTHING
	}
	
	public function Header($values, $body="")
	{
		$HTML = <<<HTML
<!DOCTYPE html>
<html>
	<head>
		{$values}
	</head>
	<body {$body}>
HTML;
		return $HTML;
	}
	
	public function Shell($main)
	{
		$HTML = <<<HTML
	
	<!-- The Sites Main Container -->
	<div class='container' id='Shell'>
		
		{$main}
		
	</div>
HTML;
		return $HTML;
	}

	public function Footer()
	{
		$HTML = <<<HTML
	</body>
</html>
HTML;
		return $HTML;
	}
	
	public function Title($title)
	{
		$HTML = <<<HTML
		<title>{$title}</title>
HTML;
		return $HTML;
	}
	
	public function Link($rel, $type="", $href="")
	{
		$HTML = <<<HTML
		<link rel='{$rel}' type='{$type}' href='{$href}' />
HTML;
		return $HTML;
	}
	
	public function MetaCharSet($charSet)
	{
		$HTML = <<<HTML
		<meta charset="{$charSet}">
HTML;
		return $HTML;
	}
	
	public function MetaHttpEquiv($httpEquiv, $content)
	{
		$HTML = <<<HTML
		<meta http-equiv="{$httpEquiv}" content="{$content}">
HTML;
		return $HTML;
	}
	
	public function MetaTag($name, $content)
	{
		$HTML = <<<HTML
		<meta name="{$name}" content="{$content}">
HTML;
		return $HTML;
	}
	
	public function MetaProperty($property, $content)
	{
		$HTML = <<<HTML
		<meta property="{$property}" content="{$content}">
HTML;
		return $HTML;
	}
	
	public function jQuery()
	{
		$HTML = <<<HTML
		<script type='text/javascript' src='scripts/jquery-3.1.1.min.js'></script>
HTML;
		return $HTML;
	}
	
	public function javaScript($src, $run="")
	{
		$HTML = <<<HTML
		<script type="text/javascript" src="{$src}">{$run}</script>
HTML;
		return $HTML;
	}
	
	public function bodyNav($elements)
	{
		$HTML = <<<HTML
		<!-- The Sites Initial Top Navigation -->
		<nav class='loginNav' id='loginShell'>
		
			{$elements}
			
		</nav>
HTML;
		return $HTML;
	}
	
	public function navigationRight($elements)
	{
		$HTML = <<<HTML
		<div class="navRight">
			{$elements}
		</div>
HTML;
		return $HTML;
	}
	
	
	public function bodyHeader()
	{
		$HTML = <<<HTML
		<!-- The Sites Header Elements -->
		<header>
		
			<!-- Header Image -->
			<div class='headerImage'>
				<div class='imgContainer'>
					<img id='logoImage' src='images/templates/default/pptlogo.png'>
				</div>
			</div>
			
			<!-- Quick Navigation -->
			<div class='quickNavigation' id='quickNav'>
				<span class='chip'  onclick="location.href='index.php?p=home'">
					<div>Home</div>
				</span>
				<span class='chip'  onclick="location.href='index.php?p=venues'">
					<div>Venues</div>
				</span>
				<span class='chip'  onclick="location.href='index.php?p=leaderboard'">
					<div>Leader Board</div>
				</span>
				<span class='chip'  onclick="location.href='index.php?p=tournaments'">
					<div>Tourna ments</div>
				</span>
				<span class='chip'  onclick="location.href='index.php?p=gallery'">
					<div>Gallery</div>
				</span>
				<span class='chip'  onclick="location.href='index.php?p=faq'">
					<div>FAQ</div>
				</span>
			</div>
			
		</header>
HTML;
		return $HTML;
	}
	
	public function bodyMain($section, $widgets, $alerts="")
	{
		$HTML = <<<HTML
				<!-- The Sites Main Section Elements -->
		<main>
		
			<!-- The Sites MAIN Section -->
			
			{$alerts}
			
			<!-- Create Section -->
			<section>
			
				<div class="titleBar"><img src='images/templates/default/icons/main/t_bullet.png'> {$section['title']}</div>
			
				<div class="content">
					{$section['content']}
				</div>
				
			</section>
			
			<!-- The Sites Widget Asides  -->
			
			{$widgets}
			
		</main>
HTML;
		return $HTML;
	}
	
	public function offlineBodyMain($section, $widgets, $alerts="")
	{
		$HTML = <<<HTML
				<!-- The Sites Main Section Elements -->
		<main>
		
			<!-- The Sites MAIN Section -->
			
			{$alerts}
			
			<!-- Offline Strip -->
			<div class="offline">Currently we are offline due to maintenance, please check back later!</div>
			
			<!-- Create Section -->
			<section>
			
				<div class="titleBar"><img src='images/templates/default/icons/main/t_bullet.png'> {$section['title']}</div>
			
				<div class="content">
					{$section['content']}
				</div>
				
			</section>
			
			<!-- The Sites Widget Asides  -->
			
			{$widgets}
			
		</main>
HTML;
		return $HTML;
	}
	
	public function socialLinksWithIcons()
	{
		$HTML = <<<HTML
			<div class='socialLinks' id='socialIcons'>
			
				<!-- Social Icons -->
				
					<a href="http://www.facebook.com" target="_blank"><img src='images/templates/default/icons/social/Facebook.png' alt="Facebook" title="Facebook"></a>&nbsp;
					<a href="http://plus.google.com" target="_blank"><img src='images/templates/default/icons/social/GooglePlus.png' alt="Google Plus" title="Google Plus"></a>&nbsp;
					<a href="http://www.youtube.com" target="_blank"><img src='images/templates/default/icons/social/Youtube.png' alt="YouTube" title="YouTube"></a>&nbsp;
					<a href="http://www.twitter.com" target="_blank"><img src='images/templates/default/icons/social/Twitter.png' alt="Twitter" title="Twitter"></a>&nbsp;

				
			</div>
HTML;
		return $HTML;
	}
	
	public function bodyFooter()
	{
		$HTML = <<<HTML
		<!-- The Sites Footer Section -->
		<footer>
			
			<nav class='navWeb' id='webLinks'>
			
				<p>
					Navigation Web
				</p>
				
			</nav>
			
			<div class='socialLinks' id='socialIconsFooter'>
			
				<!-- Social Icons -->
				
					<a href="http://www.facebook.com" target="_blank"><img src='images/templates/default/icons/social/Facebook.png' alt="Facebook" title="Facebook"></a>&nbsp;
					<a href="http://plus.google.com" target="_blank"><img src='images/templates/default/icons/social/GooglePlus.png' alt="Google Plus" title="Google Plus"></a>&nbsp;
					<a href="http://www.youtube.com" target="_blank"><img src='images/templates/default/icons/social/Youtube.png' alt="YouTube" title="YouTube"></a>&nbsp;
					<a href="http://www.twitter.com" target="_blank"><img src='images/templates/default/icons/social/Twitter.png' alt="Twitter" title="Twitter"></a>&nbsp;

				
			</div>
			
			<p class='siteCopyright'>
				Copyright CrypticiTeej (-K
			</p>
			
		</footer>
HTML;
		return $HTML;
	}
	
		public function inputField($name, $type, $value = "", $style = "")
	{
		$HTML = <<<HTML
		<input type="{$type}" name="{$name}" value="{$value}" class="{$style}">
HTML;
		return $HTML;
	}
	
	public function textArea($name, $value = "", $style = "")
	{
		$HTML = <<<HTML
		<textarea name="{$name}" class="{$style}">{$value}</textarea>
HTML;
		return $HTML;
	}
	
	public function imageUpload($name, $multiple = "", $accept="image/*")
	{
		$HTML = <<<HTML
		<input name="{$name}" {$multiple} accept="{$accept}" type="file" id="photos">
HTML;
		return $HTML;
	}
	
	public function checkBox($name, $value, $title, $checked="", $style = "")
	{
		$HTML = <<<HTML
		<input type="checkbox" name="{$name}" value="{$value}" {$checked} class="{$style}"> {$title}<br>
HTML;
		return $HTML;
	}
	
	public function selectField($name, $options, $style = "")
	{
		$HTML = <<<HTML
		<select name="{$name}" class="{$style}">
			{$options}
		</select>
HTML;
		return $HTML;
	}
	
	public function selectFieldBlank($name, $options, $style = "")
	{
		$HTML = <<<HTML
		<select name="{$name}">
			<option value="">---</option>
			{$options}
		</select>
HTML;
		return $HTML;
	}
	
	public function optionField($value, $title, $selected="")
	{
		$HTML = <<<HTML
		<option value="{$value}" {$selected}>{$title}</option>
HTML;
		return $HTML;
	}


}

?>