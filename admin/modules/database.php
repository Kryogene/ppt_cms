<?PHP

class Database {
	private $_connection;
	// Store the single instance.
	private static $_instance;
	
	public static function getInstance() {
		if(!self::$_instance) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	
	public function __construct() {
	
		$sqlHost = 'localhost';
		$sqlUser = 'root';
		$sqlPass = '';
		$sqlDB = 'cms';
	
		$this->_connection = new mysqli($sqlHost, $sqlUser, $sqlPass, $sqlDB);
	}
	
	private function __clone() {}
	
	public function getConnection() {
	
		return $this->_connection;
	}
	
	public function &backup_tables_php($name, $tables = '*'){
        $data = "<?PHP
        \n/*---------------------------------------------------------------".
            "\n  SQL DB BACKUP ".date("d.m.Y H:i")." ".
            "\n  DATABASE: {$name}".
            "\n  TABLES: {$tables}".
            "\n  ---------------------------------------------------------------*/\n";
        $this->_connection->query( "SET NAMES `utf8` COLLATE `utf8_general_ci`"); // Unicode

        if($tables == '*'){ //get all of the tables
            $tables = array();
            $result = $this->_connection->query("SHOW TABLES");
            while($row = $result->fetch_row()){
                $tables[] = $row[0];
            }
        }else{
            $tables = is_array($tables) ? $tables : explode(',',$tables);
        }

        foreach($tables as $table){
            $data.= "\n/*---------------------------------------------------------------".
                "\n  TABLE: `{$table}`".
                "\n  ---------------------------------------------------------------*/\n";
            $data.= "\$drop[] = \"DROP TABLE IF EXISTS `{$table}`;\";\n";
            $res = $this->_connection->query("SHOW CREATE TABLE `{$table}`");
            $row = $res->fetch_row();
            $data.= <<<EOF
\$create[] = "{$row[1]};";

EOF;

            $result = $this->_connection->query("SELECT * FROM `{$table}`");
            $num_rows = $result->num_rows;

            if($num_rows>0){
                $vals = Array(); $z=0;
                for($i=0; $i<$num_rows; $i++){
                    $items = $result->fetch_row();
                    $vals[$z]="(";
                    for($j=0; $j<count($items); $j++){
                        if (isset($items[$j])) { $vals[$z].= "\"".$this->_connection->real_escape_string( $items[$j])."\""; } else { $vals[$z].= "NULL"; }
                        if ($j<(count($items)-1)){ $vals[$z].= ","; }
                    }
                    $vals[$z].= ")"; $z++;
                }
                $data.= "$"."insert[] = 'INSERT INTO `{$table}` VALUES ";
                $data .= "  ".implode(";';\n$"."insert[] = 'INSERT INTO `{$table}` VALUES ", $vals).";';\n";
            }
        }
        $data .= "\n?>";
        return $data;
    }
	
	public function &backup_tables_sql($name, $tables = '*'){
        $data = "\n/*---------------------------------------------------------------".
            "\n  SQL DB BACKUP ".date("d.m.Y H:i")." ".
            "\n  DATABASE: {$name}".
            "\n  TABLES: {$tables}".
            "\n  ---------------------------------------------------------------*/\n";
        $this->_connection->query( "SET NAMES `utf8` COLLATE `utf8_general_ci`"); // Unicode

        if($tables == '*'){ //get all of the tables
            $tables = array();
            $result = $this->_connection->query("SHOW TABLES");
            while($row = $result->fetch_row()){
                $tables[] = $row[0];
            }
        }else{
            $tables = is_array($tables) ? $tables : explode(',',$tables);
        }

        foreach($tables as $table){
            $data.= "\n/*---------------------------------------------------------------".
                "\n  TABLE: `{$table}`".
                "\n  ---------------------------------------------------------------*/\n";
            $data.= "DROP TABLE IF EXISTS `{$table}`;\n";
            $res = $this->_connection->query("SHOW CREATE TABLE `{$table}`");
            $row = $res->fetch_row();
            $data.= $row[1].";\n";

            $result = $this->_connection->query("SELECT * FROM `{$table}`");
            $num_rows = $result->num_rows;

            if($num_rows>0){
                $vals = Array(); $z=0;
                for($i=0; $i<$num_rows; $i++){
                    $items = $result->fetch_row();
                    $vals[$z]="(";
                    for($j=0; $j<count($items); $j++){
                        if (isset($items[$j])) { $vals[$z].= "'".$this->_connection->real_escape_string( $items[$j])."'"; } else { $vals[$z].= "NULL"; }
                        if ($j<(count($items)-1)){ $vals[$z].= ","; }
                    }
                    $vals[$z].= ")"; $z++;
                }
                $data.= "INSERT INTO `{$table}` VALUES ";
                $data .= "  ".implode(";\nINSERT INTO `{$table}` VALUES ", $vals).";\n";
            }
        }
        return $data;
    }
}

?>