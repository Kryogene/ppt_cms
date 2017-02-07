<?PHP

class Search
{
	private $_table, $_query;
	public $error;
	public $offset = 0;
	public $limit = 30;
	private $total_results;
	
	function __construct( $table )
	{
		$this->_table = $table;
		$this->limit = (isset($_GET['limit'])) ? $_GET['limit'] : $this->limit;
		$this->offset = (isset($_GET['offset'])) ? $_GET['offset'] : $this->offset;
		
	}
	
	function query( $selectors, $where = "", $order_by = "", $order = 0, $inner_join = "", $joins = "" )
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
		
		if($order == 0) $order = "ASC";
		else $order = "DESC";
		
		if(empty($order_by)) $order = "";
		else $order_by = "'{$order_by}'";
		
		$join = "";
		if(!empty($inner_join))
		{
			$join = "INNER JOIN " . $inner_join . " ON ";
			foreach($joins as $k => $v)
			{
				$join .= $k . " = " . $v;
			}
		}
		$exception_id = "id";
		if(!empty($join))
		{
			$exception_id = $this->_table . ".id";
		}
		
		$str = "SELECT {$selections} FROM {$this->_table} {$join} WHERE {$exception_id} != 0 {$where} {$order_by} {$order} LIMIT {$this->limit} OFFSET {$this->offset}";
		$query = $SQL->query($str) or $this->_handle_error($SQL->error . "<p>{$str}</p>");
		if(empty($this->error))
		{
			$this->_query = $query;
		}
	}
	
	function queryContains( $contains, $selectors, $search_fields, $order_by = "", $order = 0, $inner_join = "", $joins = "" )
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
			if($k < (count($selectors) - 1))
				$selections .= "`{$v}`, ";
			else
				$selections .= "`{$v}`";
		}
		
		if($order == 0) $order = "ASC";
		else $order = "DESC";
		
		if(empty($order_by)) $order = "";
		else $order_by = "'{$order_by}'";
		
		$join = "";
		if(!empty($inner_join))
		{
			$join = "INNER JOIN " . $inner_join . " ON ";
			foreach($joins as $k => $v)
			{
				$join .= $k . " = " . $v;
			}
		}
		
		$cstr = "SELECT COUNT({$selectors[0]}) FROM `{$this->_table}` {$join} WHERE {$selectors[0]} != 0 {$where}";
		$count_query = $SQL->query($cstr) or die($SQL->error . "<p>" . $cstr . "</p>");
		$row = $count_query->fetch_row();
		$this->total_results = $row[0];
		
		$str = "SELECT {$selections} FROM `{$this->_table}` {$join} WHERE {$selectors[0]} != 0 {$where} {$order_by} {$order} LIMIT {$this->limit} OFFSET {$this->offset}";
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

				$arr[] = $results;
		}
		return $arr;
	}
	
	private function _getRowHTML($skin)
	{
		$rows = "";
		$row_data = $this->_getRowData();
		
		//Let's cycle through all the search data...
		foreach($row_data as $v)
		{
			// Some data should be presented differently, here we convert them.
			foreach($v as $key => $val)
			{
				if(strlen($val) > 100)
					$v[$key] = substr($val,0,100) . "...";
				if($key == "player_id")
				{
					$v[$key] = CMS_Core::getInstance()->getUserNameByID($val);
				}
				if($key == "venue_id")
				{
					$v[$key] = Venue::getVenueNameByID($val);
				}
				if($key == "month")
				{
					$v[$key] = date("F", mktime(null, null, null, $val));
				}
				if($key == "online" || $key == "default")
					$v[$key] = ($val == 0) ? "No" : "Yes";
			}
			$rows .= Template::getInstance()->Skin[$skin]->search_row($v);
		}
		return $rows;
	}
	
	public function getSearchBox()
	{
		$fb = new FormBuilder( Template::getInstance() );
		$data = array("search" => "");
		$type = array("text");
		$html_arr = $fb->buildByType($data, $type);
		$html="";
		foreach($html_arr as $v)
		{
			$html .= $v;
		}
		return Template::getInstance()->Skin['search']->searchBox($html);
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
	
	public function getHTML($skin)
	{
		$html = $this->getSearchBox();

		$html .= Template::getInstance()->Skin[$skin]->search_table($this->_getRowHTML($skin), $this->_calcLinks());
		return $html;
	}
	
}

?>