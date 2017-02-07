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
  
  public function album( $id )
  {
    return new Album( $id, $this->_SQL, $this->_Template );
  }
  
  public function photo( $id )
  {
    $photo = new Photo( $id, $this->_SQL, $this->_Template);
    return $photo;
  }
  
  public function getLatestAlbums($limit)
  {
    $arr = array();
    
    $q_str = "SELECT id FROM `gallery_albums` ORDER BY date_created DESC LIMIT {$limit}";
		$query = $this->_SQL->query($q_str);
		if($query->num_rows > 0)
		{
			while($results = $query->fetch_assoc())
			{
				$arr[] = $this->album($results['id']);
			}
		}
		return $arr;
  }
  
  public function error()
  {
    return $this->error;
  }
  
}