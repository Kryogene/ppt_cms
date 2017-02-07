<?PHP

class FormBuilder
{
	
	private $_Template, $_SQL;
	private $States = array(
    "AL" => "Alabama",
    "AK" => "Alaska",
    "AZ" => "Arizona",
    "AR" => "Arkansas",
    "CA" => "California",
    "CO" => "Colorado",
    "CT" => "Connecticut",
    "DE" => "Delaware",
    "FL" => "Florida",
    "GA" => "Georgia",
    "HI" => "Hawaii",
    "ID" => "Idaho",
    "IL" => "Illinois",
    "IN" => "Indiana",
    "IA" => "Iowa",
    "KS" => "Kansas",
    "KY" => "Kentucky",
    "LA" => "Louisiana",
    "ME" => "Maine",
    "MD" => "Maryland",
    "MA" => "Massachusetts",
    "MI" => "Michigan",
    "MN" => "Minnesota",
    "MS" => "Mississippi",
    "MO" => "Missouri",
    "MT" => "Montana",
    "NE" => "Nebraska",
    "NV" => "Nevada",
    "NH" => "New Hampshire",
    "NJ" => "New Jersey",
    "NM" => "New Mexico",
    "NY" => "New York",
    "NC" => "North Carolina",
    "ND" => "North Dakota",
    "OH" => "Ohio",
    "OK" => "Oklahoma",
    "OR" => "Oregon",
    "PA" => "Pennsylvania",
    "RI" => "Rhode Island",
    "SC" => "South Carolina",
    "SD" => "South Dakota",
    "TN" => "Tennessee",
    "TX" => "Texas",
    "UT" => "Utah",
    "VT" => "Vermont",
    "VA" => "Virginia",
    "WA" => "Washington",
    "WV" => "West Virginia",
    "WI" => "Wisconsin",
    "WY" => "Wyoming"
    );
	
	private $_Timezones = array('Pacific/Midway' => '(GMT-11:00) Midway Island',
'Pacific/Samoa' => '(GMT-11:00) Samoa',
'Pacific/Honolulu' => '(GMT-10:00) Hawaii',
'US/Alaska' => '(GMT-09:00) Alaska',
'America/Los_Angeles' => '(GMT-08:00) Pacific Time (US & Canada)',
'America/Tijuana' => '(GMT-08:00) Tijuana',
'US/Arizona' => '(GMT-07:00) Arizona',
'America/Chihuahua' => '(GMT-07:00) Chihuahua',
'America/Chihuahua' => '(GMT-07:00) La Paz',
'America/Mazatlan' => '(GMT-07:00) Mazatlan',
'US/Mountain' => '(GMT-07:00) Mountain Time (US & Canada)',
'America/Managua' => '(GMT-06:00) Central America',
'US/Central' => '(GMT-06:00) Central Time (US & Canada)',
'America/Mexico_City' => '(GMT-06:00) Guadalajara',
'America/Mexico_City' => '(GMT-06:00) Mexico City',
'America/Monterrey' => '(GMT-06:00) Monterrey',
'Canada/Saskatchewan' => '(GMT-06:00) Saskatchewan',
'America/Bogota' => '(GMT-05:00) Bogota',
'US/Eastern' => '(GMT-05:00) Eastern Time (US & Canada)',
'US/East-Indiana' => '(GMT-05:00) Indiana (East)',
'America/Lima' => '(GMT-05:00) Lima',
'America/Bogota' => '(GMT-05:00) Quito',
'Canada/Atlantic' => '(GMT-04:00) Atlantic Time (Canada)',
'America/Caracas' => '(GMT-04:30) Caracas',
'America/La_Paz' => '(GMT-04:00) La Paz',
'America/Santiago' => '(GMT-04:00) Santiago',
'Canada/Newfoundland' => '(GMT-03:30) Newfoundland',
'America/Sao_Paulo' => '(GMT-03:00) Brasilia',
'America/Argentina/Buenos_Aires' => '(GMT-03:00) Buenos Aires',
'America/Argentina/Buenos_Aires' => '(GMT-03:00) Georgetown',
'America/Godthab' => '(GMT-03:00) Greenland',
'America/Noronha' => '(GMT-02:00) Mid-Atlantic',
'Atlantic/Azores' => '(GMT-01:00) Azores',
'Atlantic/Cape_Verde' => '(GMT-01:00) Cape Verde Is.',
'Africa/Casablanca' => '(GMT+00:00) Casablanca',
'Europe/London' => '(GMT+00:00) Edinburgh',
'Etc/Greenwich' => '(GMT+00:00) Greenwich Mean Time : Dublin',
'Europe/Lisbon' => '(GMT+00:00) Lisbon',
'Europe/London' => '(GMT+00:00) London',
'Africa/Monrovia' => '(GMT+00:00) Monrovia',
'UTC' => '(GMT+00:00) UTC',
'Europe/Amsterdam' => '(GMT+01:00) Amsterdam',
'Europe/Belgrade' => '(GMT+01:00) Belgrade',
'Europe/Berlin' => '(GMT+01:00) Berlin',
'Europe/Berlin' => '(GMT+01:00) Bern',
'Europe/Bratislava' => '(GMT+01:00) Bratislava',
'Europe/Brussels' => '(GMT+01:00) Brussels',
'Europe/Budapest' => '(GMT+01:00) Budapest',
'Europe/Copenhagen' => '(GMT+01:00) Copenhagen',
'Europe/Ljubljana' => '(GMT+01:00) Ljubljana',
'Europe/Madrid' => '(GMT+01:00) Madrid',
'Europe/Paris' => '(GMT+01:00) Paris',
'Europe/Prague' => '(GMT+01:00) Prague',
'Europe/Rome' => '(GMT+01:00) Rome',
'Europe/Sarajevo' => '(GMT+01:00) Sarajevo',
'Europe/Skopje' => '(GMT+01:00) Skopje',
'Europe/Stockholm' => '(GMT+01:00) Stockholm',
'Europe/Vienna' => '(GMT+01:00) Vienna',
'Europe/Warsaw' => '(GMT+01:00) Warsaw',
'Africa/Lagos' => '(GMT+01:00) West Central Africa',
'Europe/Zagreb' => '(GMT+01:00) Zagreb',
'Europe/Athens' => '(GMT+02:00) Athens',
'Europe/Bucharest' => '(GMT+02:00) Bucharest',
'Africa/Cairo' => '(GMT+02:00) Cairo',
'Africa/Harare' => '(GMT+02:00) Harare',
'Europe/Helsinki' => '(GMT+02:00) Helsinki',
'Europe/Istanbul' => '(GMT+02:00) Istanbul',
'Asia/Jerusalem' => '(GMT+02:00) Jerusalem',
'Europe/Helsinki' => '(GMT+02:00) Kyiv',
'Africa/Johannesburg' => '(GMT+02:00) Pretoria',
'Europe/Riga' => '(GMT+02:00) Riga',
'Europe/Sofia' => '(GMT+02:00) Sofia',
'Europe/Tallinn' => '(GMT+02:00) Tallinn',
'Europe/Vilnius' => '(GMT+02:00) Vilnius',
'Asia/Baghdad' => '(GMT+03:00) Baghdad',
'Asia/Kuwait' => '(GMT+03:00) Kuwait',
'Europe/Minsk' => '(GMT+03:00) Minsk',
'Africa/Nairobi' => '(GMT+03:00) Nairobi',
'Asia/Riyadh' => '(GMT+03:00) Riyadh',
'Europe/Volgograd' => '(GMT+03:00) Volgograd',
'Asia/Tehran' => '(GMT+03:30) Tehran',
'Asia/Muscat' => '(GMT+04:00) Abu Dhabi',
'Asia/Baku' => '(GMT+04:00) Baku',
'Europe/Moscow' => '(GMT+04:00) Moscow',
'Asia/Muscat' => '(GMT+04:00) Muscat',
'Europe/Moscow' => '(GMT+04:00) St. Petersburg',
'Asia/Tbilisi' => '(GMT+04:00) Tbilisi',
'Asia/Yerevan' => '(GMT+04:00) Yerevan',
'Asia/Kabul' => '(GMT+04:30) Kabul',
'Asia/Karachi' => '(GMT+05:00) Islamabad',
'Asia/Karachi' => '(GMT+05:00) Karachi',
'Asia/Tashkent' => '(GMT+05:00) Tashkent',
'Asia/Calcutta' => '(GMT+05:30) Chennai',
'Asia/Kolkata' => '(GMT+05:30) Kolkata',
'Asia/Calcutta' => '(GMT+05:30) Mumbai',
'Asia/Calcutta' => '(GMT+05:30) New Delhi',
'Asia/Calcutta' => '(GMT+05:30) Sri Jayawardenepura',
'Asia/Katmandu' => '(GMT+05:45) Kathmandu',
'Asia/Almaty' => '(GMT+06:00) Almaty',
'Asia/Dhaka' => '(GMT+06:00) Astana',
'Asia/Dhaka' => '(GMT+06:00) Dhaka',
'Asia/Yekaterinburg' => '(GMT+06:00) Ekaterinburg',
'Asia/Rangoon' => '(GMT+06:30) Rangoon',
'Asia/Bangkok' => '(GMT+07:00) Bangkok',
'Asia/Bangkok' => '(GMT+07:00) Hanoi',
'Asia/Jakarta' => '(GMT+07:00) Jakarta',
'Asia/Novosibirsk' => '(GMT+07:00) Novosibirsk',
'Asia/Hong_Kong' => '(GMT+08:00) Beijing',
'Asia/Chongqing' => '(GMT+08:00) Chongqing',
'Asia/Hong_Kong' => '(GMT+08:00) Hong Kong',
'Asia/Krasnoyarsk' => '(GMT+08:00) Krasnoyarsk',
'Asia/Kuala_Lumpur' => '(GMT+08:00) Kuala Lumpur',
'Australia/Perth' => '(GMT+08:00) Perth',
'Asia/Singapore' => '(GMT+08:00) Singapore',
'Asia/Taipei' => '(GMT+08:00) Taipei',
'Asia/Ulan_Bator' => '(GMT+08:00) Ulaan Bataar',
'Asia/Urumqi' => '(GMT+08:00) Urumqi',
'Asia/Irkutsk' => '(GMT+09:00) Irkutsk',
'Asia/Tokyo' => '(GMT+09:00) Osaka',
'Asia/Tokyo' => '(GMT+09:00) Sapporo',
'Asia/Seoul' => '(GMT+09:00) Seoul',
'Asia/Tokyo' => '(GMT+09:00) Tokyo',
'Australia/Adelaide' => '(GMT+09:30) Adelaide',
'Australia/Darwin' => '(GMT+09:30) Darwin',
'Australia/Brisbane' => '(GMT+10:00) Brisbane',
'Australia/Canberra' => '(GMT+10:00) Canberra',
'Pacific/Guam' => '(GMT+10:00) Guam',
'Australia/Hobart' => '(GMT+10:00) Hobart',
'Australia/Melbourne' => '(GMT+10:00) Melbourne',
'Pacific/Port_Moresby' => '(GMT+10:00) Port Moresby',
'Australia/Sydney' => '(GMT+10:00) Sydney',
'Asia/Yakutsk' => '(GMT+10:00) Yakutsk',
'Asia/Vladivostok' => '(GMT+11:00) Vladivostok',
'Pacific/Auckland' => '(GMT+12:00) Auckland',
'Pacific/Fiji' => '(GMT+12:00) Fiji',
'Pacific/Kwajalein' => '(GMT+12:00) International Date Line West',
'Asia/Kamchatka' => '(GMT+12:00) Kamchatka',
'Asia/Magadan' => '(GMT+12:00) Magadan',
'Pacific/Fiji' => '(GMT+12:00) Marshall Is.',
'Asia/Magadan' => '(GMT+12:00) New Caledonia',
'Asia/Magadan' => '(GMT+12:00) Solomon Is.',
'Pacific/Auckland' => '(GMT+12:00) Wellington',
'Pacific/Tongatapu' => '(GMT+13:00) Nuku\'alofa'
);
	
	public function __construct( Template $template, $sql )
	{
		$this->_Template = $template;
		$this->_SQL = $sql;
	}
	
	public function buildByType($data, $type)
	{
		$converge = array();
		$data_keys = array_keys($data);
		$arr = array();
		for($i = 0; $i < count($data); $i++)
		{
			// Detect if a style class is attached
			if(is_array($type[$i]))
				$arr[$data_keys[$i]] = $this->_buildHTML($data[$data_keys[$i]], $data_keys[$i], $type[$i][0], $type[$i][1]);
			else
				$arr[$data_keys[$i]] = $this->_buildHTML($data[$data_keys[$i]], $data_keys[$i], $type[$i]);
		}
		return $arr;
	}
	
	private function _buildHTML($data, $data_key, $type, $class="")
	{
		switch($type)
		{
				default:
					$html = $this->_Template->Skin['globals']->inputField($data_key, $type, $data, $class);
				break;
				case "textarea":
					$html = $this->_Template->Skin['globals']->textArea($data_key, $data, $class);
				break;
				case "dropdown":
					$html = $this->_Template->Skin['globals']->selectField($data_key, $this->_buildOptions($data), $class);
				break;
				case "timezone":
					$html = $this->_Template->Skin['globals']->selectField($data_key, $this->_buildOptions( $this->_Timezones, (empty($data) ? "US/Eastern" : $data) ), $class);
				break;
				case "num_day":
					$html = $this->_Template->Skin['globals']->selectField($data_key, $this->_buildNumDayOptions($data), $class);
				break;
				case "month":
					$html = $this->_Template->Skin['globals']->selectField($data_key, $this->_buildMonthOptions($data), $class);
				break;
				case "year":
					$html = $this->_Template->Skin['globals']->selectField($data_key, $this->_buildYearOptions($data), $class);
				break;
				case "day":
					$html = $this->_Template->Skin['globals']->selectField($data_key, $this->_buildDayOptions($data), $class);
				break;
				case "time":
					$html = $this->_buildTimeSelections($data);
				break;
				case "day[]":
					$days = explode("|", $data);
					$html = $this->_buildMultiDayOptions($days);
				break;
				case "time[]":
					$times = explode("|", $data);
					$html = $this->_buildMultiTimeSelections($times);
				break;
				case "checkbox":
					$html = $this->_Template->Skin['globals']->checkBox($data_key, 1, null, (($data) ? "checked" : ""), $class);
				break;
				case "image_single":
					$html = $this->_Template->Skin['globals']->imageUpload($data_key);
				break;
				case "image_multiple":
					$html = $this->_Template->Skin['globals']->imageUpload($data_key."[]", "multiple");
				break;
				case "gallery_album":
					$html = $this->_Template->Skin['globals']->selectField($data_key, Album::getAlbumOptions($data, $this->_SQL), $class);
				break;
				case "venues":
					$html = $this->_Template->Skin['globals']->selectField($data_key, Venue::getVenueOptions($data), $class);
				break;
				case "venue_features":
					$html = $this->_buildVenueFeatures($data);
				break;
				case "state":
				 $html = $this->_Template->Skin['globals']->selectField($data_key, $this->_buildOptions( $this->States, (empty($data) ? "FL" : $data) ), $class);
				break;
				case "user_group":
					$html = $this->_Template->Skin['globals']->selectField($data_key, $this->_buildOptions( $this->_getUserGroups(), (empty($data) ? "3" : $data) ), $class);
				break;
				case "page":
					$html = $this->_Template->Skin['globals']->selectField($data_key, $this->_buildOptions( Page::getAllPublicPages(), (empty($data) ? "1" : $data) ), $class);
				break;
				case "template":
					$html = $this->_Template->Skin['globals']->selectField($data_key, $this->_buildOptions( Template::getAllTemplates(), (empty($data) ? "1" : $data) ), $class);
				break;
				case "hidden":
					$html = $this->_Template->Skin['globals']->inputField($data_key, $type, $data);
				break;
		}
		return $html;
	}
	
	private function _getUserGroups()
	{
		$q_str = "SELECT * FROM `player_groups` ORDER BY `group_id` ASC";
		$query = $this->_SQL->query($q_str);
		$arr = array();
		while($result = $query->fetch_assoc())
		{
			$arr[$result['group_id']] = $result['name'];
		}
		return $arr;
	}
	
	private function _buildVenueFeatures( $data )
	{
		$html = "";
		$features = explode(",", $data);
		$all_venue_features = Venue::getAllFeatures();
		
		foreach($all_venue_features as $k => $v)
		{
			$found = 0;
			foreach($features as $val)
			{
				if($k == $val)
				{
					$html .= $this->_Template->Skin['globals']->checkBox("features[]", $k, $v, "checked");
					$found = 1;
				}
			}
			if($found == 0)
				$html .= $this->_Template->Skin['globals']->checkBox("features[]", $k, $v);
		}
		return $html;
		
	}
	
	private function _buildDayOptions( $selector )
	{
		$Core = CMS_Core::getInstance();
		
		$html = $this->_buildOptions( $Core->Day, $selector );
		return $html;
	}
	
	private function _buildNumDayOptions( $selector )
	{
		$Core = CMS_Core::getInstance();
		$days = array();
		for($d=1;$d<32;$d++)
			$days[$d] = $d;
		$html = $this->_buildOptions( $days, $selector );
		return $html;
	}
	
	private function _buildMonthOptions( $selector )
	{
		$Core = CMS_Core::getInstance();
		$months = array();
		for($m=1;$m<13;$m++)
			$months[$m] = date("F", mktime(null, null, null, $m));
		$html = $this->_buildOptions( $months, $selector );
		return $html;
	}
	
	private function _buildYearOptions( $selector )
	{
		$Core = CMS_Core::getInstance();
		$years = array();
		for($y=date('Y');$y>2011;$y--)
			$years[$y] = $y;
		$html = $this->_buildOptions( $years, $selector );
		return $html;
	}
	
	private function _buildMultiDayOptions( $selectors )
	{
		$Core = CMS_Core::getInstance();
		$html = "";
		foreach($selectors as $val)
		{
			$html .= $this->_Template->Skin['globals']->selectField("day[]", $this->_buildOptions( $Core->Day, $val )) . "<br>";
		}
		return $html;
	}
	
	private function _buildTimeSelections( $data, $multi=0 )
	{
		$Core = CMS_Core::getInstance();
		
		$tam = explode(" ", $data);
		$time = explode(":", $tam[0]);
		
		//Get First Time Options
		$ft_opt = "";
		for($t = 1; $t < 13; $t++)
		{
			if($time[0] == $t)
				$ft_opt .= $this->_Template->Skin['globals']->optionField($t, $t, "selected");
			else
				$ft_opt .= $this->_Template->Skin['globals']->optionField($t, $t);
		}
		//Get Second Time Options
		$st_opt = "";
		for($t = 0; $t < 60; $t+=5)
		{
			if(isset($time[1]))
			{
				if($time[1] == $t)
					$st_opt .= $this->_Template->Skin['globals']->optionField(str_pad($t, 2, '0', STR_PAD_LEFT), str_pad($t, 2, '0', STR_PAD_LEFT), "selected");
				else
					$st_opt .= $this->_Template->Skin['globals']->optionField(str_pad($t, 2, '0', STR_PAD_LEFT), str_pad($t, 2, '0', STR_PAD_LEFT));
			}else
				$st_opt .= $this->_Template->Skin['globals']->optionField(str_pad($t, 2, '0', STR_PAD_LEFT), str_pad($t, 2, '0', STR_PAD_LEFT));
		}
		//Get Meridiem Options
		$m_opt = "";
		if(isset($tam[1]))
		{
			if($tam[1] == "AM")
			{
				$m_opt .= $this->_Template->Skin['globals']->optionField("AM", "AM", "selected");
				$m_opt .= $this->_Template->Skin['globals']->optionField("PM", "PM");
			}
			else
			{
				$m_opt .= $this->_Template->Skin['globals']->optionField("AM", "AM");
				$m_opt .= $this->_Template->Skin['globals']->optionField("PM", "PM", "selected");
			}
		}
		else
		{
			$m_opt .= $this->_Template->Skin['globals']->optionField("AM", "AM");
			$m_opt .= $this->_Template->Skin['globals']->optionField("PM", "PM");
		}
			
		// Build all Fields
		if(!$multi)
		{
			$html = $this->_Template->Skin['globals']->selectField("time_1", $ft_opt);
			$html .= $this->_Template->Skin['globals']->selectField("time_2", $st_opt);
			$html .= $this->_Template->Skin['globals']->selectField("time_3", $m_opt);
		}
		else
		{
			$html = $this->_Template->Skin['globals']->selectField("time_1[]", $ft_opt);
			$html .= $this->_Template->Skin['globals']->selectField("time_2[]", $st_opt);
			$html .= $this->_Template->Skin['globals']->selectField("time_3[]", $m_opt);
		}
		return $html;
		
	}
	
	private function _buildMultiTimeSelections( $data )
	{
		$html = "";
		foreach($data as $val)
		{
			$html .= $this->_buildTimeSelections($val, 1) . "<br>";
		}
		return $html;
		
	}
	
	private function _buildOptions( $arr, $selector="" )
	{
		$html = "";
		foreach($arr as $k => $v)
		{
			if($selector == $v || $selector == $k)
			{
				$html .= $this->_Template->Skin['globals']->optionField($k, $v, "selected");
			}
			else
			{
				$html .= $this->_Template->Skin['globals']->optionField($k, $v);
			}
		}
		return $html;
	}
	
}