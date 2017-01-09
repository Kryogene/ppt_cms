<?PHP

class Backup_Handler extends Page_Handler
{
	private $backup_dir = "backups/";
	
	public function PostHandler()
	{
	
	}
	
	public function GetHandler()
	{
		if(isset($_GET['create']))
			$this->_handleCreateBackup();
		elseif(isset($_GET['download']))
			$this->_handleDownload($_GET['download']);
			
	}
	
	public function SectionHandler()
	{
	
		$Page = Page::getInstance();
		$Template = Template::getInstance();
		
		$Template->loadSkin("backup");

		$backup_files = FileManager::getFilesInDirectory($this->backup_dir);
		if(!$backup_files)
			$backup_text = $Template->Skin['backup']->no_backup_found();
		else
		{
			$file_count = count($backup_files);
			$latest_file = $this->_findNewest($backup_files);
			$latest_date = filectime($this->backup_dir . $latest_file);
			$tmp = explode(".", $latest_file);
			unset($tmp[count($tmp) - 1]);
			$latest_file = implode(".", $tmp);
			$backup_text = $Template->Skin['backup']->backup_found(date("F d Y H:i:s.", $latest_date), $latest_file);
		}
		
		
	
		$Page->setSection( $Page->Name . " - Site Backup", $Template->Skin['backup']->main_table($backup_text) );
		
	}
	
	private function _handleCreateBackup()
	{
		$db = Database::getInstance();
		$Page = Page::getInstance();
		
		$sql_backup_text = $db->backup_tables_sql("cms");
		$php_backup_text = $db->backup_tables_php("cms");
		$file_name = "Backup-".date("d.m.Y")."-".date("H.i.s");
		
		$sql_file = new FileManager($file_name . ".sql", $this->backup_dir);
		$php_file = new FileManager($file_name . ".php", $this->backup_dir);
		
		if($sql_file->write($sql_backup_text) && $php_file->write($php_backup_text))
		{
			$zip = new ZipArchive;
      $zip->open($this->backup_dir . $file_name . ".zip", ZipArchive::CREATE);
      $zip->addFile($this->backup_dir . $file_name . ".sql");
      $zip->addFile($this->backup_dir . $file_name . ".php");
      $zip->close();
			
			$Page->setAlert("Success", "Backup successfully created and saved!");
		}
		else
			$Page->setAlert("Uh Oh!", "Backup could not be created!", 2);
	}
	
	private function _findNewest($files)
	{
		$newest_file_time = 0;
		$newest_file = "";
		foreach($files as $val)
		{
			if(filectime($this->backup_dir . $val) > $newest_file_time)
			{
				$newest_file = $val;
				$newest_file_time = filectime($this->backup_dir . $val);
			}
		}
		return $newest_file;
	}

	private function _handleDownload($file)
	{
		header('Content-Type: application/zip');
    header('Content-disposition: attachment; filename=' . $file . '.zip');
    header('Content-Length: ' . filesize($this->backup_dir . $file . ".zip"));
    readfile($this->backup_dir . $file . ".zip");
	}
	
}

?>