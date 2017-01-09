<?PHP

interface Handler
{

	public $DEBUG;
	
	public function PostHandler();
	
	public function GetHandler();
	
	public function FireAllPresets();
	
}

?>