<?PHP

class sk_backup
{
  
  public function backup_found($date, $latest_file)
  {
    $HTML = <<<HTML
    The last backup was created on <b>{$date}</b>.<br />
     - Download the backup <a href="index.php?backup&download={$latest_file}">Here</a>.
HTML;
    return $HTML;
  }
  
  public function no_backup_found()
  {
    $HTML = <<<HTML
    <span class="no_backup">No backups exist on the server!</span>
HTML;
    return $HTML;
  }
  
  public function main_table($backup_txt)
  {
    $HTML = <<<HTML
    <div style="width: 95%; margin: 0 auto 0 auto;">
    <p style="margin: 5px 5px 5px 5px; border-bottom: 1px solid #000000;">{$backup_txt}</p>
    <p style="margin: 5px 5px 5px 5px; border-bottom: 1px solid #000000;">If you wish to create a backup now <a href="index.php?backup&create">Click Here</a>.</p>
    <p style="margin: 5px 5px 5px 5px;">To upload a saved backup use the form below.</p>
    <p style="margin: 5px 5px 5px 5px; border-bottom: 1px solid #000000;"><input type="submit" name="upload_backup" value="Upload"><br>
    <b>Note:</b> <i>By uploading a backup all previous database records will be lost!</i></p>
    </div>
HTML;
    return $HTML;
  }
  
}
?>