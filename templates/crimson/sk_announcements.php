<?PHP

class sk_announcements
{
  function announcement_table( $data )
  {
    $HTML = <<<HTML
    <table class="announcement border-sandwich">
      <tr>
        <td>
          <span class="subject">{$data['subject']}</span>
        </td>
      </tr>
      <tr>
        <td>
          <p>{$data['content']}</p>
         </td>
       </tr>
       <tr>
        <td>
          <span class="created">Created on {$data['date_created']} by {$data['created_by']}</span>
        </td>
      </tr>
     </table>
HTML;
    return $HTML;
  }
  
  function no_announcements()
  {
    $HTML = <<<HTML
    <table class="dialog no-border">
      <tr>
        <td>
          There are currently no announcements, please check back later!
        </td>
      </tr>
     </table>
HTML;
    return $HTML;
  }
  
}

?>