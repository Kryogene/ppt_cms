<?PHP

include("../modules/database.php");

$db = Database::getInstance();
$SQL = $db->getConnection();

$search = "WHERE `id` != 0";
if(isset($_GET['search']) && !empty(trim($_GET['search'])))
{
  $explode = explode(" ", $_GET['search']);
  if(count($explode) == 1)
  {
    $st = $SQL->real_escape_string( $_GET['search'] );
    $search .= " AND `firstName` LIKE '%" . $st . "%' OR `lastName` LIKE '%" . $st . "%'";
  }
  else
  {
    $f = $SQL->real_escape_string( $explode[0] );
    $s = $SQL->real_escape_string( $explode[1] );
    
    $search .= " AND `firstName` LIKE '%" . $f . "%' AND `lastName` LIKE '%" . $s . "%'";
  }

$q_str = "SELECT `firstName`, `lastName`, `id` FROM `players` {$search} ORDER BY `lastName` ASC";

$query = $SQL->query($q_str) or die($SQL->error);

if($query->num_rows > 0)
  while($results = $query->fetch_assoc())
  {
    $users[$results['id']] = $results['firstName'] . "." . $results['lastName'] . "." . $results['id'];
  }
else
  $users = "No Results Found!";

if(is_array($users))
{
  foreach($users as $k => $v)
  {
    echo "<div class='datasubbox' onclick=\"send_to('{$k}', '{$v}')\">{$v}</div>";
  }
}
else
{
  echo "<div class='datasubbox'>No Results Found!</div>";
}
}
else
{
  echo "<div class='datasubbox'>No Criteria.</div>";
}

?>