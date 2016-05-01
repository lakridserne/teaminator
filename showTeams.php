<?php
/**
* Coding Pirates Team-inator
* Used to generate teams at Coding Pirates Game Jam 2015
*/
include("dbConnect.php");
$db = new DB;
?>
<!DOCTYPE html>
<head>
  <title>Coding Pirates Team-inator</title>
</head>
<h1>Coding Pirates Team-inator til Coding Pirates Game Jam 2015!</h1>
<h2>Teams</h2>
<?php
// Get teams and show them
$number_teams = "SELECT team_ID FROM team ORDER BY team_ID DESC LIMIT 1";
$number_teams_result = $db->count($number_teams);

for($i=1;$i<=$number_teams_result;$i++) {
  ?><h3>Hold <?php echo $i; ?></h3><?php
  $find_team_members = "SELECT * FROM team WHERE team_ID=:team_ID";
  $values = [
    [":team_ID",$i]
  ];
  $find_team_members_result = $db->query($find_team_members,$values);
  foreach ($find_team_members_result as $member) {
    # find name, display
    $member_id = $member["participants_ID"];
    $name_sql = "SELECT name FROM participants WHERE ID=:id";
    $values = [
      [":id",$member_id]
    ];
    $name = $db->query($name_sql,$values);
    echo $name['0']["name"] . "<br />";
  }
  echo "<br /><br />";
}
?>
