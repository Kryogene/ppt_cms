<?PHP

class Album
{
  protected $_SQL, $_Template;
  
  public $id;
  public $Title, $Description, $PhotosInAlbum;
  private $_CreatedBy, $_CreatedOn, $_EditedBy, $_EditedOn;
  
  public function __construct( $a_id, $sql, $template )
  {
    if(!is_numeric($a_id))
      return 0;
    
    $this->_SQL = $sql;
    $this->_Template = $template;
    
    $this->id = $a_id;
    
    $this->_getData();
  }
  
  private function _getData()
  {
    $q_str = "SELECT * FROM `gallery_albums` WHERE `id` = {$this->id}";
    $query = $this->_SQL->query($q_str);
    if($query->num_rows > 0)
    {
      $result = $query->fetch_assoc();
      $this->Title = $result['album_title'];
      $this->Description = $result['album_description'];
      $this->_CreatedBy = $result['created_by'];
      $this->_CreatedOn = $result['date_created'];
      $this->_EditedBy = $result['edited_by'];
      $this->_EditedOn = $result['date_last_edited'];
    }
		unset($q_str);
		unset($query);
		$q_str = "SELECT COUNT(*) FROM `gallery_photos` WHERE `album_id` = {$this->id}";
    $query = $this->_SQL->query($q_str);
		$row = $query->fetch_row();
    $this->PhotosInAlbum = $row[0];
  }
  
	public static function getTitle( $a_id, $sql )
	{
		$q_str = "SELECT `album_title` FROM `gallery_albums` WHERE `id` = {$a_id}";
		$query = $sql->query($q_str) or die ("error");
		if($query->num_rows > 0)
		{
			$result = $query->fetch_assoc();
			return $result['album_title'];
		}
		return -1;
	}
	
	public function getPhotos($limit=5, $offset=0, $orderBy = "date_created", $order = "DESC")
	{
		$q_str = "SELECT `id` FROM `gallery_photos` WHERE `album_id` = {$this->id} ORDER BY `{$orderBy}` {$order} LIMIT {$limit} OFFSET {$offset}";
		$query = $this->_SQL->query($q_str);
		if($query->num_rows > 0)
		{
			$photos  = array();
			while($result = $query->fetch_assoc())
			{
				$photos[] = new Photo($result['id'], $this->_SQL, $this->_Template);
			}
			return $photos;
		}
		return -1;
	}
	
	
}

?>