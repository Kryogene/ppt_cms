<?PHP

spl_autoload_register(function ($class)
{
	@include (strtolower($class) . ".php");
	//@include("../modules/" . $class_name . ".php");
	@include("modules/" . strtolower($class) . ".php");
	@include("handlers/" . strtolower($class) . ".php");
	@include("../exceptions/". strtolower($class) . ".php");
	@include("../users/". strtolower($class) . ".php");
});

// Import the Definitions library.
require_once ("define.php");
require_once ("init.php");
$Init = new Init;
$Init->init();
?>