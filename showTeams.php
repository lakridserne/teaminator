<?php
/**
* Coding Pirates Teaminator
* Used to generate teams at Coding Pirates Game Jam 2015-2016
*/

include("header.php");
?>
<a href="<?php echo $teaminator_url . 'download_csv.php'; ?>" title="Download CSV">Download CSV</a>
<?php
// Get teams and show them
$number_teams = "SELECT COUNT(DISTINCT team_ID) FROM team";
$number_teams_result = $db->query($number_teams);

for($i=1;$i<=$number_teams_result[0][0];$i++) {
  ?><h3>Hold <?php echo $i; ?></h3><a href="<?php echo $teaminator_url . 'editTeam.php?team=' . $i; ?>" title="Ret hold <?php echo $i; ?>">Ret</a>
  <br />
  <?php
  $find_team_members = "SELECT * FROM team WHERE team_ID=:team_ID";
  $values = [
    [":team_ID",$i]
  ];
  $find_team_members_result = $db->query($find_team_members,$values);
  foreach ($find_team_members_result as $member) {
    # find name, display
    $member_id = $member["participants_ID"];
    $name_sql = "SELECT participants.name, participants.age, team.created FROM participants INNER JOIN team ON participants.ID=team.participants_ID WHERE ID=:id";
    $values = [
      [":id",$member_id]
    ];
    $name = $db->query($name_sql,$values);
    echo $name['0']["name"] . " - " . $name['0']['age'] . " år - lavet: " . $name['0']['created'] . "<br />";
  }
  echo "<br /><br />";
}
include("footer.php");
?>
