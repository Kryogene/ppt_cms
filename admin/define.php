<?PHP
	
if( !defined( "CORE_DIR" ) )
	define ( "CORE_DIR", "../core/" );

if( !defined( "HANDLERS_DIR" ) )
	define ( "HANDLERS_DIR", "handlers/" );
	
if( !defined( "IMAGES_DIR" ) )
	define ( "IMAGES_DIR", "../images/" );

if( !defined( "GALLERY_UPLOAD_DIR" ) )
	define ( "GALLERY_UPLOAD_DIR", "../uploads/gallery/" );
	
if( !defined( "MODULES_DIR" ) )
	define ( "MODULES_DIR", "modules/" );
	
if( !defined( "TEMPLATES_DIR" ) )
	define ( "TEMPLATES_DIR", "templates/" );
	
/* FILES */
if( !defined( "SKIN_PREFIX" ) )
	define ( "SKIN_PREFIX", "sk_" );
	
if( !defined( "FILE_EXT" ) )
	define( "FILE_EXT", ".php" );
	
if( !defined( "DIR_SPACER" ) )
	define ( "DIR_SPACER", "/" );

if( !defined( "PAGES_FILE" ) )
	define ( "PAGES_FILE", "pages.php" );
	
if( !defined( "TEMPLATES_FILE" ) )
	define ( "TEMPLATES_FILE", "templates.php" );
	
if( !defined( "CONFIG_FILE" ) )
	define ( "CONFIG_FILE", "config.php" );
	
if( !defined( "CORE_FILE" ) )
	define ( "CORE_FILE", "core.php"  );
	
/* HANDLERS */
if( !defined( "DEFAULT_PAGE_HANDLER_OBJECT" ) )
	define ( "DEFAULT_PAGE_HANDLER_OBJECT", "Page_Handler" );

if( !defined( "HANDLER_EXT" ) )
	define ( "HANDLER_EXT", "_Handler" );
	
if( !defined( "PAGE_HANDLER_INTERFACE" ) )
	define ( "PAGE_HANDLER_INTERFACE", "page_handler.php" );
	
/* PAGES */
if( !defined( "PAGE_BUILDER" ) )
	define ( "PAGE_BUILDER", "pageBuilder.php" );
	
/* MEMBERS */
if( !defined( "DEFAULT_GUEST_ID" ) )
	define ( "DEFAULT_GUEST_ID", 0 );
	
/* MAIL */
if( !defined( "DEFAULT_NO_MAIL_SUBJECT" ) )
	define ( "DEFAULT_NO_MAIL_SUBJECT", "(No Subject)" );
	
/* VENUES */
if( !defined( "VENUE_IMAGES" ) )
	define ( "VENUE_IMAGES", IMAGES_DIR . "venues/" );
	
/* DEFAULTS */
if( !defined( "DEFAULT_IMG" ) )
	define ( "DEFAULT_IMG", "no_img.jpg" );
	
if( !defined( "ADMIN_HOME_PAGE" ) )
	define ( "ADMIN_HOME_PAGE", "main" );

if( !defined( "SMALL_IMAGE_EXT" ) )
	define( "SMALL_IMAGE_EXT", "_small" );

	
?>