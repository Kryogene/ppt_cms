<?PHP

class Album
{
  protected $_SQL, $_Template;
  
  protected $id;
  public $Title, $Description;
  private $_CreatedBy, $_CreatedOn, $_EditedBy, $_EditedOn;
  private $_Types = array(	"hidden" ,
								"text",
								"textarea"
							);
  
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
  }
  
  public function getFormData()
	{
    $_Data['id'] = $this->id;
    $_Data['album_title'] = htmlspecialchars_decode($this->Title);
    $_Data['album_description'] = htmlspecialchars_decode($this->Description);
		
		return $this->_Template->convertToForm($_Data, $this->_Types);
	}
  
  public function modify($title, $description, $created_by)
  {
    if(empty($title))
    {
			return 0;
    }
    
    $user = $created_by;
    $time = time();
    $title = addslashes(htmlspecialchars($title));
    $description = addslashes(htmlspecialchars($description));
		
		$old = GALLERY_UPLOAD_DIR . strtolower(implode("_", explode(" ", $this->Title)));
		$new = GALLERY_UPLOAD_DIR . strtolower(implode("_", explode(" ", $title)));

		if(!rename($old, $new))
			return 0;
    
    $q_str = "UPDATE `gallery_albums` SET `album_title` = '{$title}', `album_description` = '{$description}', `date_last_edited` = '{$time}', `edited_by` = '{$user}' WHERE `id` = '{$this->id}'";
    $this->_SQL->query($q_str) or die($SQL->error);
    return 1;
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
	
	public static function getAlbumOptions( $selection="", $sql )
	{
		$html = "";
		
		$q_str = "SELECT * FROM `gallery_albums` ORDER BY `album_title` ASC";
		$query = $sql->query($q_str);
		
		while($result = $query->fetch_assoc())
		{
			if($result['id'] == $selection)
				$html .= Template::getInstance()->Skin['search']->selectOption( $result['album_title'], $result['id'], "selected" );
			else
				$html .= Template::getInstance()->Skin['search']->selectOption( $result['album_title'], $result['id'] );
		}
		return $html;
	}
  
}

?>