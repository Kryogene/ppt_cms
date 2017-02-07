<?PHP

class Gallery
{
  protected $_SQL, $_Template;
  protected $error;
  
  public function __construct($sql, $template)
  {
    $this->_SQL = $sql;
    $this->_Template = $template;
   
  }
  
  public static function createAlbum($title, $description, $sql)
  {
    
    if(empty(trim($title)))
      return 0;
    
    $user = CMS_Core::getInstance()->User->fullName;
    $time = time();
    $folder_name = strtolower(implode("_", explode(" ", $title)));
    
    $dir = "..".CMS_Core::getInstance()->Settings['uploadDir'] . $folder_name;
    
    if( FileManager::createDir( $dir ) )
    {
      $q_str = "INSERT INTO `gallery_albums` (album_title, album_description, created_by, date_created) VALUES ('{$title}', '{$description}', '{$user}', {$time})";
      $query = $sql->query($q_str);
      return 1;
    }
    else
      return 0;
  }
  
  public static function uploadPhotos($album_id, $photo, $img_names, $title, $description, $sql)
  {
    
    foreach($title as $v)
    {
      if(empty(trim($v)))
      {
        return "You are missing a photo title!";
      }
    }
    
    $user = CMS_CORE::getInstance()->User->fullName;
    $time = time();
    
    $photoUploadCount = count( $photo['name'] );
    
    $album = Album::getTitle( $album_id, $sql );
    if($album == -1) 
    {
      return "The album could not be found!";
    }
    
    $albumDir = strtolower(implode("_", explode(" ", $album)));
    $uploadDir = "..".CMS_Core::getInstance()->Settings['uploadDir'] . $albumDir . "/";
    
    $successes = 0;

    for($i=0; $i < $photoUploadCount; $i++)
    {
        $ext = explode(".", $photo['name'][$i]);
        $ext = end($ext);
      
        foreach($img_names as $k => $v)
        {
          if($v == $photo['name'][$i])
          {
            $fileName = $title[$k]; // User input
            $fileDescription = $description[$k]; // User Input
          }
        }
      
        $fileSize = $photo['size'][$i];

        $fileNameRaw = implode("_", explode(" ", $fileName));
        $fileTitle = ucwords(implode(" ", explode("_", $fileName)));

        if( file_exists($uploadDir . $fileName . "." . $ext) )
        {
          return "The file already exists!";
        }
        else
        {
            if(Photo::shrink($photo['tmp_name'][$i], $fileNameRaw, $uploadDir, $ext) &&
               Photo::upload($fileNameRaw, $uploadDir, $fileSize, $ext, $photo['tmp_name'][$i]))
            {
              $q_str = "INSERT INTO `gallery_photos` (photo_title, album_id, photo_name, size, type, photo_description, created_by, date_created) 
              VALUES ('{$fileTitle}', '{$album_id}', '{$fileNameRaw}', '{$fileSize}', '{$ext}', '{$fileDescription}', '{$user}', {$time})";
              $query = $sql->query($q_str);
              $successes++;
            }
        }

    }
    if($successes > 0)
      return 1;
    else
      return 0;
    
  }
  
  public function album( $id )
  {
    return new Album( $id, $this->_SQL, $this->_Template );
  }
  
  public function photo( $id )
  {
    $photo = new Photo( $id, $this->_SQL, $this->_Template);
    return $photo;
  }
  
  public function error()
  {
    return $this->error;
  }
  
}