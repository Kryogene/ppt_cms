<?PHP

class Announcement
{
  
  private $_Core;
  private $_id;
	private $_Data;
	private $_Types = array(	"hidden" ,
								"text",
								"textarea"
							);
  
  function __construct( $id )
  {
    $this->_Core = CMS_Core::getInstance();
    $this->_id = $id;
    
    $this->_queryData();
    
  }
  
  private function _queryData()
  {
    
    $db = Database::getInstance();
		$SQL = $db->getConnection();
    
    $qstr = "SELECT id, subject, content FROM `announcements` WHERE `id` = '{$this->_id}'";
    $query = $SQL->query($qstr);
    
    if($query->num_rows > 0)
    {
      
      $this->_Data = $query->fetch_assoc();
      
    }
    
  }
  
  public function getFormData()
	{
		$Template = Template::getInstance();
    $this->_Data['subject'] = htmlspecialchars_decode($this->_Data['subject']);
    $this->_Data['content'] = htmlspecialchars_decode($this->_Data['content']);
		
		return $Template->convertToForm($this->_Data, $this->_Types);
	}
  
  public static function create($subject, $content)
  {
   	$db = Database::getInstance();
		$SQL = $db->getConnection();
    
    if(empty($subject) || empty($content))
    {
			return 0;
    }
    
    $user = CMS_Core::getInstance()->User->fullName;
    $time = time();
    $subject = addslashes(htmlspecialchars($subject));
    $content = addslashes(htmlspecialchars($content));
    
    $q_str = "INSERT INTO `announcements` (subject, created_by, content, date_created) VALUES ('{$subject}', '{$user}', '{$content}', {$time})";
    $SQL->query($q_str) or die($SQL->error);
    return 1;
    
  }
  
  public function modify($subject, $content)
  {
    $db = Database::getInstance();
		$SQL = $db->getConnection();
    
    if(empty($subject) || empty($content))
    {
			return 0;
    }
    
    $user = CMS_Core::getInstance()->User->fullName;
    $time = time();
    $subject = addslashes(htmlspecialchars($subject));
    $content = addslashes(htmlspecialchars($content));
    
    $q_str = "UPDATE `announcements` SET `subject` = '{$subject}', `content` = '{$content}', `date_last_edited` = '{$time}', `edited_by` = '{$user}' WHERE `id` = '{$this->_id}'";
    $SQL->query($q_str) or die($SQL->error);
    return 1;
  }
  
  public function delete()
  {
    $db = Database::getInstance();
		$SQL = $db->getConnection();
		$querystr = "DELETE FROM `announcements` WHERE `id` = {$this->_id}";
		if($SQL->query($querystr))
			return 1;
		else
			return 0;
  }
  
}

?>