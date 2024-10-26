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
$teams = "SELECT DISTINCT team_ID FROM team ORDER BY team_ID";
$teams_result = $db->query($teams);

foreach ($teams_result as $team) {
  ?><h3>Hold <?php echo $team['team_ID']; ?></h3><a href="<?php echo $teaminator_url . 'editTeam.php?team=' . $team['team_id']; ?>" title="Ret hold <?php echo $team['team_ID']; ?>">Ret</a>
  <br />
  <?php
  $find_team_members = "SELECT * FROM team WHERE team_ID=:team_ID";
  $values = [
    [":team_ID",$team['team_ID']]
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
