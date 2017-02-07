<?PHP

class FileManager
{
  public $file_name, $dir, $size, $ext;
  public $date_format = "F d Y H:i:s";
  
  public function __construct( $file_name, $dir="/" )
  {
    $this->file_name = $file_name;
    $this->dir = $dir;
  }
	
	public static function createDir( $dir, $chmod = 0775, $recursive = true )
	{

		if( mkdir( $dir, $chmod, $recursive ) )
			return 1;
		else
			return 0;
	}
  
  public function write( $text )
  {
    // If file exists, open it, if not, create it!
    $file = fopen($this->dir . $this->file_name, "w");
    if(!fwrite($file, $text))
      return 0;
    fclose($file);
    return 1;
  }
  
  public function writeCSV( $array )
  {
    // If file exists, open it, if not, create it!
    $file = fopen($this->dir . $this->file_name, "w");
    foreach($array as $fields)
			fputcsv($file, $fields);
    fclose($file);
    return 1;
  }
	
	public function getSize()
	{
		
	}
	
	public function uploadImage( $photo_tmp )
	{

    $fileNameRaw = implode("_", explode(" ", $this->file_name));

    //if( ($_FILES['photo']['error'][$index]) )
    //{
    //    return $Panel->Template->Skins['s_globals']->form_error($fileTitle." Is Too Large!");
    //}

    if( move_uploaded_file($photo_tmp, $this->dir . $fileNameRaw . "." . $this->ext  ) )
    {
        return 1;
  	}
 		else
  	{
			return 0;
  	}
	}
	
	public function uploadResizedImage( $fn, $width, $height, $size )
	{
		$src = imagecreatefromstring( file_get_contents( $fn ) );
    $dst = imagecreatetruecolor( $width, $height );
    imagecopyresampled( $dst, $src, 0, 0, 0, 0, $width, $height, $size[0], $size[1] );
    imagedestroy( $src );
		switch($this->ext)
		{
			case "jpg":
			case "jpeg":
    		imagejpeg( $dst, $this->dir . $this->file_name . "_small." . $this->ext );
			break;
			case "bmp":
				imagebmp( $dst, $this->dir . $this->file_name . "_small." . $this->ext );
			break;
			default:
				return 0;
		}
    imagedestroy( $dst );
		return 1;
	}
  
  public function exists()
  {
    if(file_exists($this->dir . $this->file_name))
      return 1;
    else
      return 0;
  }
  
  public function timestamp()
  {
    if(!$this->exists())
      return "No file exists!";
    else
      return date($this->date_format, filectime($this->dir . $this->file_name));
  }
  
  public static function getFilesInDirectory( $dir )
  {
    $files = scandir($dir);
        
    // Delete unneeded directory backs
    unset($files[0]);
    unset($files[1]);
    
    if(empty($files))
      return 0;
    
    return $files;
    
  }
  
}
?>