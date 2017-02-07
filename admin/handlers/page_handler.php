<?PHP

class Page_Handler
{

	public $DEBUG;
	
	function __construct()
	{

	}
	
	// Required!
	public function FireAllPresets()
	{
		$this->SectionHandler();
		$this->PostHandler();
		$this->GetHandler();
	}
	
	public function PostHandler()
	{
		if( isset($_POST['create_page']) )
			$this->_handleCreatePage();
		if( isset($_POST['modify_page']) )
			$this->_handleModifyPage();
	}
	
	public function GetHandler()
	{
		$this->DEBUG[] = "Firing Get Handlers...";

		if( isset( $_GET['search'] ) )
			$this->_handleSearch();
		elseif( isset( $_GET['create'] ) )
			$this->_handleCreate();
		elseif( isset( $_GET['modify'] ) )
			$this->_handleModify();
		elseif( isset( $_GET['delete'] ) )
			$this->_handleDelete();
	}	
	
	public function SectionHandler()
	{
	
		$Page = Page::getInstance();
		$Template = Template::getInstance();
		$Template->loadSkin("pages");

		$Page->setSection( $Page->Title, $this->_handlePagesMain() );
		
	}
	
	private function _handlePagesMain()
	{
		return "Test";
	}
	
	private function _handleCreate()
	{
		$Page = Page::getInstance();
		$Template = Template::getInstance();

		$Page->setSection( $Page->Title . " - Create", $Template->Skin['pages']->createTable() );
	}
	
	private function _handleSearch()
	{
		$sh = new Search_Handler( "pages" );
		$sh->fireAllPresets();
	}
	
	private function _handleCreatePage()
	{
		$Page = Page::getInstance();
		if(!Page::create($_POST['page_name'], $_POST['page_title'], $_POST['page_description'], $_POST['page_type'], (isset($_POST['page_default']) ? $_POST['page_default'] : 0), (isset($_POST['page_online']) ? $_POST['page_online'] : 0), $_POST['page_content']))
			$Page->setAlert( "Oh No!", "Some required fields are empty!", 2 );
		else
			$Page->setAlert( "Posted", "Page successfully created!" );
	}
	
	private function _handleModify()
	{
		$Page = Page::getInstance();
		$Template = Template::getInstance();
		
		if(!isset($_GET['id']) || !is_numeric($_GET['id'])) 
		{
			$this->SectionHandler();
			return;
		}
		$data = Page::getData($_GET['id']);
		$Page->setSection( $Page->Name . " - Modify", $Template->Skin['pages']->modifyTable($data) );
		
	}
	
	private function _handleModifyPage()
	{
		$Page = Page::getInstance();
		
		$page_mod = Page::modify($_POST['id'], $_POST['name'], $_POST['title'], $_POST['description'], $_POST['type'], (isset($_POST['default']) ? $_POST['default'] : 0), (isset($_POST['online']) ? $_POST['online'] : 0), $_POST['page_default_content']);
		
		if($page_mod != 1)
			$Page->setAlert( "Oh No!", $page_mod, 2 );
		else
			$Page->setAlert( "Posted", "Page successfully modified!" );
	}

}