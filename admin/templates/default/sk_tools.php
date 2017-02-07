<?PHP

class sk_tools
{
  
  function user_section($content)
  {
    $HTML = <<<HTML
    <div class="sectionWrap">
      <div class="side menu">
        <ul>
          <li><a href="index.php?cat=users&tools&groups">User Groups</a>
          <li><a href="index.php?cat=users&tools&email">Send Email</a>
          <li><a href="index.php?cat=users&tools&sync">Sync Tables</a>
        </ul>
      </div>
      <div class="main">
        {$content}
      </div>
    </div>
HTML;
    return $HTML;
  }
  
  function user_groups_main()
  {
    $HTML = <<<HTML
    <p>User Groups are essential to the security of data and user privacy. You may create, modify, or delete user groups but be aware of the restriction you grant them!</p>
    <p>
      - <a href="index.php?cat=users&tools&groups&create">Create Group</a><br>
      - <a href="index.php?cat=users&tools&groups&modify">Modify Group</a><br>
    </p>
HTML;
    return $HTML;
  }
  
  function user_groups_create()
  {
    $HTML = <<<HTML
    <form action="index.php?cat=users&tools&groups" method="POST">
      <table class="dialog no-border form">
        <tr>
          <td>
            Group Name:
          </td>
          <td>
            <input type="text" name="name" value="">
          </td>
        </tr>
        <tr>
          <td>
            Restriction Level:
          </td>
          <td>
            <input type="number" name="restriction" value="3">
            <p>
              Restriction levels are as followed:<br>
              0 - No user access.<br>
              1 - Complete access, with administration panel.<br>
              2 - Moderate access, no administration panel, later use.<br>
              3 - Basic user functionality.<br>
              4 - No access to any material.<br>
            </p>
          </td>
        </tr>
        <tr>
          <td colspan="2">
            <input type="submit" name="submit_create" value="Create">
          </td>
        </tr>
      </table>
    </form>
HTML;
     return $HTML;
  }
  
  function user_groups_modify($data)
  {
    $HTML = <<<HTML
    <form action="index.php?cat=users&tools&groups&modify" method="POST">
    <input type="hidden" name="group_id" value="{$data['group_id']}">
      <table class="dialog no-border form">
        <tr>
          <td>
            Group Name:
          </td>
          <td>
            <input type="text" name="name" value="{$data['name']}">
          </td>
        </tr>
        <tr>
          <td>
            Restriction Level:
          </td>
          <td>
            <input type="number" name="restriction" value="{$data['restriction']}">
            <p>
              Restriction levels are as followed:<br>
              0 - No user access.<br>
              1 - Complete access, with administration panel.<br>
              2 - Moderate access, no administration panel, later use.<br>
              3 - Basic user functionality.<br>
              4 - No access to any material.<br>
            </p>
          </td>
        </tr>
        <tr>
          <td colspan="2">
            <input type="submit" name="submit_modify" value="Modify">
          </td>
        </tr>
      </table>
    </form>
HTML;
     return $HTML;
  }
  
  function groups_table($content)
  {
    $HTML = <<<HTML
    <table class="dialog border menu">
      <tr>
        <th>
          Group Name
        </th>
        <th>
          Restriction
        </th>
      </tr>
      {$content}
    </table>
HTML;
    return $HTML;
  }
  
  function groups_row($data)
  {
    $HTML = <<<HTML
    <tr>
      <td>
        <a href="index.php?cat=users&tools&groups&modify&id={$data['group_id']}">{$data['name']}</a>
      </td>
      <td>
        {$data['restriction']}
      </td>
    </tr>
HTML;
    return $HTML;
  }
  
}

?>