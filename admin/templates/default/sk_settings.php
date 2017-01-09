<?PHP

class sk_settings
{

	public function settingsTable( $fields )
	{
		$HTML = <<<HTML
		<form method="POST">
			<table class="settingsTable">
				<tr>
					<td>
						Site Name:
					</td>
					<td>
						{$fields['siteTitle']}
					</td>
				</tr>
				<tr>
					<td>
						Site Time Zone:
					</td>
					<td>
						{$fields['defaultTimeZone']}
					</td>
				</tr>
				<tr>
					<td>
						Site Date Format:
					</td>
					<td>
						{$fields['defaultTimestamp']}
					</td>
				</tr>
				<tr>
					<td>
						Site URL:
					</td>
					<td>
						{$fields['defaultURL']}
					</td>
				</tr>
				<tr>
					<td>
						Default Char Set:
					</td>
					<td>
						{$fields['charSet']}
					</td>
				</tr>
				<tr>
					<td>
						Default Upload Directory:
					</td>
					<td>
						{$fields['uploadDir']}
					</td>
				</tr>
				<tr>
					<td>
						Site Online:
					</td>
					<td>
						{$fields['online']}
					</td>
				</tr>
				<tr>
					<td>
						Debug Mode:
					</td>
					<td>
						{$fields['debugMode']}
					</td>
				</tr>
				<tr>
					<td>
						Site Home Page:
					</td>
					<td>
						{$fields['defaultPage']}
					</td>
				</tr>
				<tr>
					<td>
						Site Default Template:
					</td>
					<td>
						{$fields['defaultTemplate']}
					</td>
				</tr>
				<tr>
					<td>
						Facebook:
					</td>
					<td>
						{$fields['facebook']}
					</td>
				</tr>
				<tr>
					<td>
						Twitter:
					</td>
					<td>
						{$fields['twitter']}
					</td>
				</tr>
				<tr>
					<td>
						Google Plus:
					</td>
					<td>
						{$fields['googlePlus']}
					</td>
				</tr>
				<tr>
					<td>
						Youtube:
					</td>
					<td>
						{$fields['youTube']}
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<input type="submit" name="updateMainSettings" value="Save">
					</td>
				</tr>
			</table>
		</form>
HTML;
		return $HTML;
	}


}

?>