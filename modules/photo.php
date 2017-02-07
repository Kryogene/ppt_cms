<?PHP

class Photo
{
  public $Title, $Description, $Type, $AlbumID, $AlbumTitle;
  protected $_SQL, $_Template, $id;

  private $_CreatedBy, $_CreatedOn, $_EditedBy, $_EditedOn;
  
  function __construct( $p_id, $sql, $template )
  {

    if(!is_numeric($p_id))
      return 0;
    
    $this->_SQL = $sql;
    $this->_Template = $template;
    
    $this->id = $p_id;
    
    $this->_getData();
  }
  
  private function _getData()
  {
    $q_str = "SELECT * FROM `gallery_photos` WHERE `id` = {$this->id}";
    $query = $this->_SQL->query($q_str);
    if($query->num_rows > 0)
    {
      $result = $query->fetch_assoc();
      $this->Title = $result['photo_title'];
      $this->Description = $result['photo_description'];
      $this->AlbumID = $result['album_id'];
      $this->AlbumTitle = Album::getTitle($result['album_id'], $this->_SQL);
      $this->Type = $result['type'];
      $this->_CreatedBy = $result['created_by'];
      $this->_CreatedOn = $result['date_created'];
      $this->_EditedBy = $result['edited_by'];
      $this->_EditedOn = $result['date_last_edited'];
    }
  }
  
  public function getImageSrc()
  {
    $src = CMS_Core::getInstance()->parentDirectory() . CMS_Core::getInstance()->Settings['uploadDir'] . strtolower($this->_getRaw($this->AlbumTitle)) . DIR_SPACER . $this->_getRaw($this->Title) . "." . $this->Type;
    return $src;
  }
	
	public function getImageSmallSrc()
  {
    $src = CMS_Core::getInstance()->parentDirectory() . CMS_Core::getInstance()->Settings['uploadDir'] . strtolower($this->_getRaw($this->AlbumTitle)) . DIR_SPACER . $this->_getRaw($this->Title) . SMALL_IMAGE_EXT . "." . $this->Type;
    return $src;
  }
	
	public function photoSrc()
	{
		return $this->_getRaw($this->Title);
	}
  
  private function _getRaw($name)
  {
    return implode("_", explode(" ", $name));
  }
  
}

?>