<?PHP

class MainSettingsEditor
{
	
	private $_Data;
	private $_Types = array(	"hidden",
													"text" ,
													"timezone",
													"text",
													"text",
													"text",
													"text",
													"checkbox",
													"checkbox",
													"text",
													"text",
													"text",
													"text"
							);
								
	
	public function __construct()
	{
		$this->_Data = array();
	}
	
	public function query( $fields = "*" )
	{
		$db = Database::getInstance();
		$SQL = $db->getConnection();
		
		$query = $SQL->query("SELECT {$fields} FROM `settings`");
		if($query->num_rows > 0)
		{
			$this->_Data = $query->fetch_assoc();
		}
	}
	
	public function output()
	{
		$html = "";
		foreach($this->_Data as $k => $v)
		{
			$html .= $k . " -> " . $v . "<br>";
		}
		return $html;
	}
	
	public function getFormData()
	{
		$Template = Template::getInstance();
		//To ensure proper saving of timestamp
		$this->_Data['defaultTimestamp'] = addslashes($this->_Data['defaultTimestamp']);
		
		return $Template->convertToForm($this->_Data, $this->_Types);
	}
	
	public function update($siteTitle, 
												 $defaultTimeZone, 
												 $defaultTimestamp, 
												 $defaultURL, 
												 $charSet, 
												 $uploadDir, 
												 $online, 
												 $debugMode, 
												 $facebook,
												 $twitter,
												 $googlePlus,
												 $youTube)
	{
		if(empty(trim($siteTitle)) ||
			empty(trim($defaultTimeZone)) ||
			empty(trim($defaultTimestamp)) ||
			empty(trim($defaultURL)) ||
			empty(trim($charSet)) ||
			empty(trim($uploadDir)))
			return 0;
		
		$db = Database::getInstance();
		$SQL = $db->getConnection();
		
		$q_str = "UPDATE `settings` SET `siteTitle` = '{$siteTitle}', 
																		`defaultTimeZone` = '{$defaultTimeZone}', 
																		`defaultTimestamp` = '{$defaultTimestamp}', 
																		`defaultURL` = '{$defaultURL}',
																		`charSet` = '{$charSet}', 
																		`uploadDir` = '{$uploadDir}', 
																		`online` = '{$online}',
																		`debugMode` = '{$debugMode}', 
																		`facebook` = '{$facebook}', 
																		`twitter` = '{$twitter}', 
																		`googlePlus` = '{$googlePlus}', 
																		`youTube` = '{$youTube}'
																		WHERE `id` = '1'";
    $SQL->query($q_str) or die($SQL->error);
		return 1;
			
	}
	
}

?>