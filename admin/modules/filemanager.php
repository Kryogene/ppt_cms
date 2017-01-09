<?PHP

class FileManager
{
  private $file_name, $dir;
  public $date_format = "F d Y H:i:s";
  
  public function __construct( $file_name, $dir="/" )
  {
    $this->file_name = $file_name;
    $this->dir = $dir;
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