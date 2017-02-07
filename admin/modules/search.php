<?PHP

class Search
{
	private $_table, $_query, $_data_additions;
	public $error;
	public $offset = 0;
	public $limit = 30;
	public $group_by = array();
	public $count = array();
	public $http_query = "";
	private $total_results;
	
	function __construct( $table )
	{
		$this->_table = $table;
		$this->limit = (isset($_GET['limit'])) ? $_GET['limit'] : $this->limit;
		$this->offset = (isset($_GET['offset'])) ? $_GET['offset'] : $this->offset;
		
	}
	
	function query( $selectors, $where = "", $inner_join = "", $joins = "" )
	{
		$db = Database::getInstance();
		$SQL = $db->getConnection();
		
		if(is_array($where))
		{
			$tmp = array();
			foreach($where as $k => $v)
			{
				$tmp[] = "{$k} = '{$v}'";
			}
			unset($where);
			$where = "";
			for($i = 0; $i < count($tmp); ++$i)
			{
					$where .= " AND {$tmp[$i]}";
			}
		}
		else
			$where = "";
		
		$selections = "";
		foreach($selectors as $k => $v)
		{
			if($k < (count($selectors) - 1))
				$selections .= "{$v}, ";
			else
				$selections .= "{$v}";
		}
		
		if(empty($this->order_by)) $order_by = "";
		else $order_by = "ORDER BY {$this->order_by}";
		
		if($this->order == 0 && empty($order_by)) $order = "";
		elseif(strtolower($this->order) == "asc") $order = "ASC";
		else $order = "DESC";
		
		$join = "";
		if(!empty($inner_join))
		{
			if(!is_array($inner_join))
			{
				$join = "INNER JOIN " . $inner_join . " ON ";
				foreach($joins as $k => $v)
				{
					$join .= $k . " = " . $v;
				}
			}
			else
			{
				for($i=0;$i<count($inner_join);$i++)
				{
					$join .= "INNER JOIN " . $inner_join[$i] . " ON {$joins[$i][0]} = {$joins[$i][1]} ";
				}
			}
		}
		$exception_id = "id";
		if(!empty($join))
		{
			$exception_id = $this->_table . ".id";
		}
		
		$group_by = "";
		if(count($this->group_by) > 0)
		{
			$grp_by = implode(", ", $this->group_by);
			$group_by = "GROUP BY " . $grp_by;
		}
		
		$str = "SELECT {$selections} FROM {$this->_table} {$join} WHERE 1=1 {$where} {$group_by} {$order_by} {$order} LIMIT {$this->limit} OFFSET {$this->offset}";
		$query = $SQL->query($str) or $this->_handle_error($SQL->error . "<p>{$str}</p>");
		if(empty($this->error))
		{
			$this->_query = $query;
		}
	}
	
	function queryContains( $contains, $selectors, $search_fields, $inner_join = "", $joins = "" )
	{
		$db = Database::getInstance();
		$SQL = $db->getConnection();
		
		if(is_array($search_fields))
		{
			$where = "AND (";
			foreach($search_fields as $k => $v)
			{
				if($k < (count($search_fields) - 1))
					$where .= "{$v} LIKE '%{$contains}%' OR ";
				else
					$where .= "{$v} LIKE '%{$contains}%'";
			}
			$where .= ")";
		}
		
		$selections = "";
		foreach($selectors as $k => $v)
		{
			$joined = explode(".", $v);
			if(!isset($joined[1]))
			{
				if($k < (count($selectors) - 1))
					$selections .= "`{$v}`, ";
				else
					$selections .= "`{$v}`";
			}
			else
			{
				if($k < (count($selectors) - 1))
					$selections .= "{$joined[0]}.`{$joined[1]}`, ";
				else
					$selections .= "{$joined[0]}.`{$joined[1]}`";
			}
		}
		
		if($this->order == 0 && empty($this->order_by)) $order = "";
		elseif(strtolower($this->order) == "asc") $order = "ASC";
		else $order = "DESC";
		
		if(empty($this->order_by)) $order_by = "";
		else 
		{
			if(!is_array($this->order_by))
				$order_by = "ORDER BY {$this->order_by} {$order}";
			else
			{
				$order_by = "ORDER BY ";
				$ob = array();
				foreach($this->order_by as $val)
				{
					$ob[] .= $val . " " . $order;
				}
				$order_by .= implode(", ", $ob);
			}
		}
		
		$join = "";
		if(!empty($inner_join))
		{
			if(!is_array($inner_join))
			{
				$join = "INNER JOIN " . $inner_join . " ON ";
				foreach($joins as $k => $v)
				{
					$join .= $k . " = " . $v;
				}
			}
			else
			{
				for($i=0;$i<count($inner_join);$i++)
				{
					$join .= "INNER JOIN " . $inner_join[$i] . " ON {$joins[$i][0]} = {$joins[$i][1]} ";
				}
			}
		}
		
		$group_by = "";
		if(count($this->group_by) > 0)
		{
			$grp_by = implode(", ", $this->group_by);
			$group_by = "GROUP BY " . $grp_by;
		}
		
		$count = "";
		if(count($this->count) > 0)
		{
			$count = ", COUNT({$this->count[0]}) as `{$this->count[1]}`";
		}
		
		$cstr = "SELECT {$selections} FROM `{$this->_table}` {$join} WHERE 1=1 {$where} {$group_by}";
		$count_query = $SQL->query($cstr) or die($SQL->error . "<p>" . $cstr . "</p>");
		$this->total_results = $count_query->num_rows;
		
		$str = "SELECT {$selections}{$count} FROM `{$this->_table}` {$join} WHERE 1=1 {$where} {$group_by} {$order_by} LIMIT {$this->limit} OFFSET {$this->offset}";
		$query = $SQL->query($str) or $this->_handle_error($SQL->error . "<p>{$str}</p>");
		if(empty($this->error))
		{
			$this->_query = $query;
		}
	}
	
	private function _handle_error( $error )
	{
		$this->error = $error;
	}
	
	private function _getRowData()
	{
		if(!empty($this->error)) return;
		$arr = array();
		while($results = $this->_query->fetch_assoc())
		{

				$arr[$results['id']] = $results;
		}
		return $arr;
	}
	
	public function addDataRow($key, $val="")
	{
		$this->_data_additions[$key] = $val;
	}
	
	private function _getRowHTML($skin, $table_ext = "")
	{
		$rows = "";
		$row_data = $this->_getRowData();
		$row_func = "search_row" . $table_ext;
		$modify_link = "modify" . $table_ext . "_link";
		$delete_link = "delete" . $table_ext . "_link";
		$create_default = FALSE; // For detection on option links
		//Let's cycle through all the search data...
		foreach($row_data as $k => $v)
		{
			// Additional data being added? Let's merge!
			if(!empty($this->_data_additions))
			$v = array_merge($v, $this->_data_additions);
			
			// Some data should be presented differently, here we convert them.
			foreach($v as $key => $val)
			{
				// If the string is too long then let's snip it.
				if(strlen($val) > 100)
					$v[$key] = substr($val,0,100) . "...";
				
				// Convert any player id fields to the player name
				if($key == "player_id")
					$v[$key] = CMS_Core::getInstance()->getUserNameByID($val);
				
				// Convert any venue id fields to the venue name
				//if($key == "venue_id")
				//	$v[$key] = Venue::getVenueNameByID($val);
				
				// Convert any month fields to the string equivalent
				if($key == "month")
				{
					//We will replace the original keys value while creating a numerical key and value just in case!
					$v[$key] = date("F", mktime(null, null, null, $val));
					$v['num_month'] = $val;
				}
				
				if($key == "startTime")
				{
					$multi = explode("|", $v[$key]);
					$v[$key] = implode("<br>", $multi);
				}
					
				if($key == "weekday")
				{
					$multi = explode("|", $v[$key]);
					foreach($multi as $mk => $mv)
					{
						$multi[$mk] = @CMS_Core::getInstance()->Day[$mv];
					}
					$v[$key] = implode("<br>", $multi);
				}

				// Convert online or default fields to a simple yes or no
				if($key == "online" || $key == "default")
					$v[$key] = ($val == 0) ? "No" : "Yes";
				if($key == "default" && $val == 1)
					$create_default = TRUE;
				
				// Convert img fields to the proper url.
				if($key == "img")
					$v[$key] = GALLERY_UPLOAD_DIR . strtolower(implode("_", explode(" ", $v['album_title']))) . DIR_SPACER . $v['photo_name'] . SMALL_IMAGE_EXT . "." . $v['type'];
			}
			
			//Now Let's setup our options...
			// Let's see if the user wants add a query string to the links or we default to the key.
			if(!empty($this->http_query))
			{
				$http_query_array = array();
				foreach($this->http_query as $qry)
				{
					if($qry == "month")
						$http_query_array[$qry] = $v['num_month'];
					else
						$http_query_array[$qry] = $v[$qry];
				}
				$http_query = http_build_query($http_query_array);
			}
			else
				$http_query = $k;
			
			$options = Template::getInstance()->Skin[$skin]->$modify_link($http_query);
			if($create_default)
				$options .= Template::getInstance()->Skin[$skin]->default_link();
			if($k != 0)
				$options .= Template::getInstance()->Skin[$skin]->$delete_link($http_query);
			
			$rows .= Template::getInstance()->Skin[$skin]->$row_func($v,$options);
			$create_default = FALSE;
		}
		return $rows;
	}
	
	public function getSearchBox()
	{
		$fb = new FormBuilder( Template::getInstance(), Database::getInstance()->getConnection() );
		$data = array("search" => "");
		$type = array("text");
		$html_arr = $fb->buildByType($data, $type);
		$html="";
		foreach($html_arr as $v)
		{
			$html .= $v;
		}
		// Some categories might have sub categories. To compensate for the Get type in forms we must add hidden text fields...
		$hidden_additions = "";
		if(isset($_GET['photos']))
			$hidden_additions .= Template::getInstance()->Skin['globals']->inputField("photos", "hidden");
		if(isset($_GET['albums']))
			$hidden_additions .= Template::getInstance()->Skin['globals']->inputField("albums", "hidden");
		if(isset($_GET['group_by']))
			$hidden_additions .= Template::getInstance()->Skin['globals']->inputField("group_by", "hidden", $_GET['group_by']);
		if(isset($_GET['year']))
			$hidden_additions .= Template::getInstance()->Skin['globals']->inputField("year", "hidden", $_GET['year']);
		if(isset($_GET['month']))
			$hidden_additions .= Template::getInstance()->Skin['globals']->inputField("month", "hidden", $_GET['month']);
		if(isset($_GET['day']))
			$hidden_additions .= Template::getInstance()->Skin['globals']->inputField("day", "hidden", $_GET['day']);
		return Template::getInstance()->Skin['search']->searchBox($html, $hidden_additions);
	}
	
	private function _calcLinks()
	{
		$Template = Template::getInstance();
		$begin_offset = 0;
		$back_offset = (($this->offset - $this->limit) < $begin_offset) ? $begin_offset : ($this->offset - $this->limit);
		$forward_offset = $this->offset + $this->limit;
		$last_offset = (($this->total_results % $this->limit) > 0) ? ((int)($this->total_results / $this->limit) * $this->limit) : $forward_offset;
		$html = "";
		if($this->offset > $begin_offset)
		{
			$query = $_GET;
			$query['offset'] = 0;
			$html .= $Template->Skin['search']->goToBeginning( http_build_query($query) );
			$query = $_GET;
			$query['offset'] = $back_offset;
			$html .= $Template->Skin['search']->goBackOnePage( http_build_query($query) );
		}
		if($forward_offset < $this->total_results )
		{
				$query = $_GET;
				$query['offset'] = $last_offset;
				$html .= $Template->Skin['search']->goToLast( http_build_query($query) );

			$query = $_GET;
			$query['offset'] = $forward_offset;
			$html .= $Template->Skin['search']->goForwardOnePage( http_build_query($query) );
		}
		return $html;
	}
	
	public function getHTML($skin, $table_ext = "")
	{
		$table = "search_table" . $table_ext;
		$html = $this->getSearchBox();
		
			$html .= Template::getInstance()->Skin[$skin]->$table($this->_getRowHTML($skin, $table_ext), $this->_calcLinks());
			
		return $html;
	}
	
}

?>