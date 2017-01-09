<?PHP

class Statistics
{
  
  public static $rows = 30;
  
  protected $_id;
  protected $_data;
  
  function __construct( $id )
  {
    
    $this->_id = $id;
    $this->_query();
    
  }
  
  protected function _query()
  {
    $db = Database::getInstance();
		$SQL = $db->getConnection();
    
    $qstr = "SELECT player_statistics.*, players.id, players.lastName, players.firstName FROM player_statistics INNER JOIN players ON player_statistics.player_id = players.id WHERE player_statistics.id = {$this->_id}";
    $query = $SQL->query($qstr);
    if($query)
    {
      $results = $query->fetch_assoc();
    }
    else
    {
      $results = array();
    }
    $this->_data = $results;
    
  }
  
  public function getModifyHTML()
  {
    $Template = Template::getInstance();
    
    $row = $Template->Skin['statistics']->statisticModifyField($this->_data);
    
    $options = array();
    $options['years'] = $Template->Skin['globals']->selectField("year", $Template->getYearOptions($this->_data['year']));
    $options['months'] = $Template->Skin['globals']->selectField("month", $Template->getMonthOptions($this->_data['month']));
    $options['days'] = $Template->Skin['globals']->selectField("day", $Template->getNumericDayOptions($this->_data['day']));
    $options['venues'] = $Template->Skin['globals']->selectField("venue_id", Venue::getVenueOptions($this->_data['venue_id']));
    
    $table = $Template->Skin['statistics']->statisticHeaderBox($options);
    
    $table .= $Template->Skin['statistics']->statisticBodyBox($Template->Skin['statistics']->statisticTable($row));
    return $Template->Skin['statistics']->modifyForm($table);
  }
  
  public static function addForm( $Template )
  {
    
    // Let's get the header options.
    $header = self::formHeader($Template);
    $body = self::formBody($Template);
    
    return $Template->Skin['statistics']->addForm(($header . $body));
    
  }
  
  protected static function formHeader($Template)
  {
    $options = array();
    $options['years'] = $Template->Skin['globals']->selectField("year", $Template->getYearOptions());
    $options['months'] = $Template->Skin['globals']->selectField("month", $Template->getMonthOptions(date('n')));
    $options['days'] = $Template->Skin['globals']->selectField("day", $Template->getNumericDayOptions(date('j')));
    $options['venues'] = $Template->Skin['globals']->selectField("venue_id", Venue::getVenueOptions());
    
    return $Template->Skin['statistics']->statisticHeaderBox($options);
  }
  
  protected static function formBody($Template)
  {
    $fields = "";
    $players = $Template->Skin['globals']->selectFieldBlank("player[]", $Template->getUserOptions());
    for($row = 1; $row <= self::$rows; $row++)
      $fields .= $Template->Skin['statistics']->statisticField($players) . "\n";
    
    return $Template->Skin['statistics']->statisticBodyBox($Template->Skin['statistics']->statisticTable($fields));
  }
  
}