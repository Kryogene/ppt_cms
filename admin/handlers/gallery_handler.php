<?PHP

class Gallery_Handler extends Page_Handler
{
	
	private $_Page, $_Template;
	
	function __construct()
	{
    
	}
	
	public function PostHandler()
	{
		$this->DEBUG[] = "Firing Post Handlers...";
	
		if( isset( $_POST['submitSettings'] ) )
			$this->_handleUpdateSettings();
			
		if( isset( $_POST['create_album'] ) )
			$this->_handleCreateGalleryAlbum();
		if( isset( $_POST['modify_album'] ) )
			$this->_handleModifyGalleryAlbum();
		if( isset( $_POST['upload_photos'] ) )
			$this->_handleUploadGalleryPhoto();
		if( isset( $_POST['modify_photo'] ) )
			$this->_handleModifyGalleryPhoto();

		$this->DEBUG[] = "Post Handlers Fired!";
	}
	
	public function GetHandler()
	{	
	
		$this->DEBUG[] = "Firing Get Handlers...";

		if( isset( $_GET['search'] ) )
			$this->_handleSearch();
		
		if( isset($_GET['albums']) )
		{
			if( isset($_GET['create']) )
				$this->_handleCreateAlbum();
			elseif( isset($_GET['modify']) )
				$this->_handleModifyAlbum();
			elseif( isset( $_GET['delete'] ) )
				$this->_handleDeleteAlbum();
		}
		elseif( isset($_GET['photos']) )
		{
			if( isset($_GET['upload']) )
				$this->_handleUploadPhoto();
			elseif( isset($_GET['modify']))
				$this->_handleModifyPhoto();
		}
	}
	
	public function SectionHandler()
	{
		
		$this->_Page = Page::getInstance();
		$this->_Template = Template::getInstance();
    
    $this->_Template->loadSkin("gallery");
	
		$this->_Page->setSection( $this->_Page->Name . " - Main", $this->_handleGalleryMain() );
		
	}
	
	private function _handleGalleryMain()
	{
		return "Gallery Main";
	}
	
	/*---------------------------
	// Create search handlers and do the search.
	//-------------------------*/
	private function _handleSearch()
	{
		if(isset($_GET['albums']))
			$sh = new Search_Handler( "gallery_albums" );
		elseif(isset($_GET['photos']))
			$sh = new Search_Handler( "gallery_photos" );
		else
			return;
		$sh->fireAllPresets();
	}
	
	/*--------------------------
	//
	// From here on we handle Album creation, modification, and deletion.
	//
	//------------------------*/
	
	/*--------------------------
	// Set the Page section to the creation table
	//------------------------*/
	private function _handleCreateAlbum()
	{
		$this->_Page->setSection( $this->_Page->Name . " - Create Album", $this->_Template->Skin['gallery']->createAlbumTable() );
		
	}
	
	private function _handleModifyAlbum()
	{
		$db = Database::getInstance();
		$SQL = $db->getConnection();
		
		if(!isset($_GET['id']) || !is_numeric($_GET['id'])) 
		{
			$this->SectionHandler();
			return;
		}
		$gallery = new Gallery($SQL, $this->_Template);
		$album = $gallery->album($_GET['id']);
		$data = $album->getFormData();
		$this->_Page->setSection( $this->_Page->Name . " - Modify Album", $this->_Template->Skin['gallery']->modifyAlbumTable($data) );
		
	}
	
	/*private function _handleDelete()
	{
		if(!isset($_GET['id']) || !is_numeric($_GET['id'])) 
		{
			$this->SectionHandler();
			return;
		}
		$announcement = new Announcement($_GET['id']);
		if(!$announcement->delete())
			$this->_Page->setAlert( "Oh No!", "We were unable to delete the announcement!", 2 );
		else
			$this->_Page->setAlert( "Success!", "The announcement was successfully removed!");
			
		$this->_handleSearch();
	}*/
	
	private function _handleCreateGalleryAlbum()
	{
		$db = Database::getInstance();
    $SQL = $db->getConnection();
		
		if(!Gallery::createAlbum($_POST['album_title'], $_POST['album_description'], $SQL))
			$this->_Page->setAlert( "Oh No!", "Some required fields are empty!", 2 );
		else
			$this->_Page->setAlert( "Posted", "Album successfully created!" );
		
	}
	
	private function _handleModifyGalleryAlbum()
	{
		$db = Database::getInstance();
		$SQL = $db->getConnection();
		
		$gallery = new Gallery($SQL, $this->_Template);
		
		if(!$gallery->album($_POST['id'])->modify($_POST['album_title'], $_POST['album_description'], CMS_Core::getInstance()->User->fullName))
			$this->_Page->setAlert( "Oh No!", "Some required fields are empty!", 2 );
		else
			$this->_Page->setAlert( "Posted", "Album successfully updated!" );
		
	}
	
	/*--------------------------
	//
	// From here on we handle Photo uploading, modification, and deletion.
	//
	//------------------------*/
	
	/*--------------------------
	// Set the Page section to the creation table
	//------------------------*/
	private function _handleUploadPhoto()
	{
				
		$max_photo_size = ini_get('upload_max_filesize');
		$max_upload_size = ini_get('post_max_size');
		
    $_Data['album_id'] = "";
    $_Data['img_upload'] = "";
		
		$_Types = array("gallery_album",
                "image_multiple"
							);
		
		$fields = $this->_Template->convertToForm($_Data, $_Types);
		
		$html = $this->_Template->Skin['gallery']->uploadPhotoTable($fields, $max_photo_size, $max_upload_size);
		$html .= $this->_Template->Skin['globals']->javaScript("scripts/uploadPhotos.js");
		
		$this->_Page->setSection( $this->_Page->Name . " - Upload Photo", $html );
		
	}
	
	private function _handleModifyPhoto()
	{
		$db = Database::getInstance();
		$SQL = $db->getConnection();
		
		if(!isset($_GET['id']) || !is_numeric($_GET['id'])) 
		{
			$this->SectionHandler();
			return;
		}
		$gallery = new Gallery($SQL, $this->_Template);
		$photo = $gallery->photo($_GET['id']);
		$data = $photo->getFormData();
		$img_src = $photo->getImageSrc();
		
		$script = $this->_Template->Skin['globals']->javaScript("scripts/uploadSinglePhoto.js");
		
		$this->_Page->setSection( $this->_Page->Name . " - Modify Photo", $this->_Template->Skin['gallery']->modifyPhotoTable($data, $img_src) . $script );
		
	}
	
	/*private function _handleDelete()
	{
		if(!isset($_GET['id']) || !is_numeric($_GET['id'])) 
		{
			$this->SectionHandler();
			return;
		}
		$announcement = new Announcement($_GET['id']);
		if(!$announcement->delete())
			$this->_Page->setAlert( "Oh No!", "We were unable to delete the announcement!", 2 );
		else
			$this->_Page->setAlert( "Success!", "The announcement was successfully removed!");
			
		$this->_handleSearch();
	}*/
	
	private function _handleUploadGalleryPhoto()
	{
		$db = Database::getInstance();
    $SQL = $db->getConnection();

		$upload = Gallery::uploadPhotos($_POST['album_id'], $_FILES['img_upload'], $_POST['img_name'], $_POST['photo_title'], $_POST['photo_description'], $SQL);
		if($upload != 1)
		{
			$this->_Page->setAlert( "Oh No!", $upload, 2 );
		}
		else
			$this->_Page->setAlert( "Posted", "Photo(s) successfully uploaded!" );
		
	}
	
	private function _handleModifyGalleryPhoto()
	{
		$db = Database::getInstance();
		$SQL = $db->getConnection();
		
		$gallery = new Gallery($SQL, $this->_Template);

		if(!isset($_FILES['img_upload']))
			$_FILES['img_upload'] = null;
		
		if(!$gallery->photo($_POST['id'])->modify($_POST['album_id'], $_FILES['img_upload'], $_POST['photo_title'], $_POST['photo_description'], CMS_Core::getInstance()->User->fullName))
			$this->_Page->setAlert( "Oh No!", "Some required fields are empty!", 2 );
		else
			$this->_Page->setAlert( "Posted", "Photo successfully updated!" );
		
	}
	
}

?>