<?PHP

class Gallery_Handler extends Page_Handler
{

	public $DEBUG;
	
	function __construct()
	{
		$Template = Template::getInstance();
		$Template->loadSkin('gallery');
	}
	
	public function PostHandler()
	{

	}
	
	public function GetHandler()
	{
		
		if( isset( $_GET['album_id'] ) )
			$this->_getAlbumSection();
	}	
	
	public function SectionHandler()
	{
		$Page = Page::getInstance();
		$Template = Template::getInstance();
		$db = Database::getInstance();
		$SQL = $db->getConnection();
		
		$gallery = new Gallery($SQL, $Template);
		$albums = $gallery->getLatestAlbums(5);

		$html = "";
		foreach($albums as $val)
		{
			$arr = $val->getPhotos();
			$photos = "";
			if($arr != -1)
			{
				foreach($arr as $photo)
				{
					$photos .= $Template->Skin['gallery']->photo_box($photo);
				}
				
			}
			else
			{
				$photos .= $Template->Skin['gallery']->no_photos();
			}
			$html .= $Template->Skin['gallery']->album_box($val, $photos);
		}
		
		$html .= $Template->Skin['globals']->javaScript("scripts/photoExpand.js");
	
		$Page->setSection( $Page->Title, $html );
	}
	
	private function _getAlbumSection()
	{
		if(!is_numeric($_GET['album_id']))
		{
			$this->SectionHandler();
			return;
		}
		
		$Page = Page::getInstance();
		$Template = Template::getInstance();
		$db = Database::getInstance();
		$SQL = $db->getConnection();
		
		$album = new Album($_GET['album_id'], $SQL, $Template);

		$html = "";
		
		$limit = (isset($_GET['limit']) ? $_GET['limit'] : 30);
		$offset = (isset($_GET['offset']) ? $_GET['offset'] : 0);
		
		$arr = $album->getPhotos($limit, $offset);
		$photos = "";
		
		if($arr != -1)
		{
			foreach($arr as $photo)
			{
				$photos .= $Template->Skin['gallery']->photo_box($photo);
			}
			
		}
		else
		{
			$photos .= $Template->Skin['gallery']->no_photos();
		}
		$html .= $Template->Skin['gallery']->album_box($album, $photos);
		
		
		$html .= $Template->Skin['globals']->javaScript("scripts/photoExpand.js");
	
		$Page->setSection( $Page->Title, $html );
		
	}

}