<?PHP

class Photo
{
  public $Title, $Description, $Type, $AlbumID, $AlbumTitle;
  protected $_SQL, $_Template, $id;

  private $_CreatedBy, $_CreatedOn, $_EditedBy, $_EditedOn;
  private static $small_max_dimensions = 100;
  private $_Types = array(	"hidden" ,
								"text",
                "gallery_album",
                "image_single",
								"textarea"
							);
  
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
  
  public function getFormData()
	{
    $_Data['id'] = $this->id;
    $_Data['photo_title'] = htmlspecialchars_decode($this->Title);
    $_Data['album_id'] = $this->AlbumID;
    $_Data['img_upload'] = "";
    $_Data['photo_description'] = htmlspecialchars_decode($this->Description);

		return $this->_Template->convertToForm($_Data, $this->_Types);
	}
  
  public function getImageSrc()
  {
    $src = GALLERY_UPLOAD_DIR . strtolower($this->_getRaw($this->AlbumTitle)) . DIR_SPACER . $this->_getRaw($this->Title) . "." . $this->Type;
    return $src;
  }
	
	public function getImageSmallSrc()
  {
    $src = GALLERY_UPLOAD_DIR . strtolower($this->_getRaw($this->AlbumTitle)) . DIR_SPACER . $this->_getRaw($this->Title) . SMALL_IMAGE_EXT . "." . $this->Type;
    return $src;
  }
  
  private function _getRaw($name)
  {
    return implode("_", explode(" ", $name));
  }
  
  public function modify($album, $photo, $title, $description, $created_by)
  {
    if(empty($title))
    {
			return 0;
    }
    
    $user = $created_by;
    $time = time();
    $title = addslashes(htmlspecialchars($title));
    $description = addslashes(htmlspecialchars($description));
    
    if($photo != null)
    {
      $fileSize = $photo['size'];
      $ext = explode(".", $photo['name']);
      $ext = end($ext);
    }

    $fileName = $this->_getRaw($title);
    $fileDescription = $description;

    $fileNameRaw = implode("_", explode(" ", $title));
    $fileTitle = ucwords(implode(" ", explode("_", $title)));
      
    $albumDir = strtolower(implode("_", explode(" ", $this->AlbumTitle)));
    $uploadDir = "..".CMS_Core::getInstance()->Settings['uploadDir'] . $albumDir . "/";

    $old = GALLERY_UPLOAD_DIR . strtolower($this->_getRaw($this->AlbumTitle)) . DIR_SPACER . ucfirst($this->_getRaw($this->Title)) . "." . $this->Type;
		$new = GALLERY_UPLOAD_DIR . strtolower($this->_getRaw(Album::getTitle($album, $this->_SQL))) . DIR_SPACER . $fileNameRaw . "." . $this->Type;    
		$old_thumb = GALLERY_UPLOAD_DIR . strtolower($this->_getRaw($this->AlbumTitle)) . DIR_SPACER . ucfirst($this->_getRaw($this->Title)) . SMALL_IMAGE_EXT . "." . $this->Type;
		$new_thumb = GALLERY_UPLOAD_DIR . strtolower($this->_getRaw(Album::getTitle($album, $this->_SQL))) . DIR_SPACER . $fileNameRaw . SMALL_IMAGE_EXT . "." . $this->Type; 

		if($photo['size'] == 0)
    {
      if(!rename($old, $new) || !rename($old_thumb, $new_thumb))
			{
        return 0;
			}
    }
    else
    {
      $file = new FileManager($fileNameRaw, GALLERY_UPLOAD_DIR . strtolower($this->_getRaw(Album::getTitle($album, $this->_SQL))) . DIR_SPACER);
      $file->ext = $ext;
      $file->size = $fileSize;
			
			Photo::shrink($photo['tmp_name'], $fileNameRaw, GALLERY_UPLOAD_DIR . strtolower($this->_getRaw(Album::getTitle($album, $this->_SQL))) . DIR_SPACER, $ext);
      $file->uploadImage( $photo['tmp_name'] );
			if($album != $this->AlbumID)
				$this->delete();
    }
    if($photo['size'] > 0)
    {
      $q_str = "UPDATE `gallery_photos` SET `photo_title` = '{$title}', `album_id` = '{$album}', `photo_description` = '{$description}', `photo_name` = '{$fileNameRaw}', `type` = '{$ext}', `size` = '{$fileSize}', `date_last_edited` = '{$time}', `edited_by` = '{$user}' WHERE `id` = '{$this->id}'";
      $this->_SQL->query($q_str) or die($this->_SQL->error);
    }
    else
    {
      $q_str = "UPDATE `gallery_photos` SET `photo_title` = '{$title}', `album_id` = '{$album}', `photo_description` = '{$description}', `photo_name` = '{$fileNameRaw}', `date_last_edited` = '{$time}', `edited_by` = '{$user}' WHERE `id` = '{$this->id}'";
      $this->_SQL->query($q_str) or die($this->_SQL->error);
    }
    return 1;
  }
  
  public static function upload($name, $dir, $size, $ext, $tmp)
  {
    
    $file = new FileManager($name, $dir);
    $file->ext = $ext;
    $file->size = $size;
    
    return $file->uploadImage( $tmp );
      
  }
  
  public static function shrink($tmp, $name, $dir, $ext)
  {
    list($width, $height, $type, $attr) = getimagesize( $tmp );
    if ( $width > self::$small_max_dimensions || $height > self::$small_max_dimensions ) {
        $fn = $tmp;
        $size = getimagesize( $fn );
        $ratio = $size[0]/$size[1]; // width/height
        if( $ratio > 1) {
            $width = self::$small_max_dimensions;
            $height = self::$small_max_dimensions/$ratio;
        } else {
            $width = self::$small_max_dimensions*$ratio;
            $height = self::$small_max_dimensions;
        }
        $file = new FileManager($name, $dir);
        $file->ext = $ext;
        return $file->uploadResizedImage($fn, $width, $height, $size);
    }
  }
  
  public function delete()
  {
    if(unlink($this->getImageSrc()) && unlink($this->getImageSmallSrc()))
      return 1;
    else
      return 0;
  }
  
}

?>