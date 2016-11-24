<?php
/**
* Coding Pirates Teaminator
* Used to generate teams at Coding Pirates Game Jam 2015-2016
*/

include("header.php");

// Get team number
if(!isset($_REQUEST['team'])) {
  die("Fejl");
} else {
  $team = $_REQUEST['team'];
}

// see if form was already submitted
if(!isset($_REQUEST['submit'])) {
  // Form not submitted yet
  // Fetch names
  $sql = "SELECT ID, name FROM participants WHERE teaminated=0";
  $names = $db->query($sql);
  $selected_sql = "SELECT participants.ID, participants.name FROM participants INNER JOIN team ON participants.ID=team.participants_ID WHERE team_ID=:team_ID";
  $selected_val = [[":team_ID",$team]];
  $team_participants = $db->query($selected_sql,$selected_val);
  ?>
  <form class="names" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <input type="hidden" name="team" value="<?php echo $team; ?>" />
    <select multiple="multiple" size="10" name="names_teams[]">
      <?php
      foreach ($names as $name) {
        echo "<option value=\"" . $name['ID']  . "\">" . $name['name'] . "</option>";
      }
      foreach($team_participants as $participant) {
        echo "<option selected='selected' value=\"" . $participant['ID'] . "\">" . $participant['name'] . "</option>";
      }
      ?>
    </select>
    <br />
    <button name="submit" type="submit" class="btn btn-default btn-block">Ret hold</button>
  </form>
  <script>var names = $('.names').bootstrapDualListbox({moveOnSelect:false});</script>
  <?php
} else {
  // Okay submitted - get selected team members
  if(isset($_REQUEST['names_teams'])) {
    $names = $_REQUEST['names_teams'];

    if(!isset($names)) {
      die("Du har ikke valgt nogen holddeltagere.");
    } else {
      // we need to know who's already in the team so we can correct
      $selected_sql = "SELECT participants.ID, participants.name FROM participants INNER JOIN team ON participants.ID=team.participants_ID WHERE team_ID=:team_ID";
      $selected_val = [[":team_ID",$team]];
      $team_participants = $db->query($selected_sql,$selected_val);

      $new_in_team_sql = "INSERT INTO team (team_ID, participants_ID) VALUES (:team_ID, :participants_ID)";
      $nNames = count($names);
      $update_sql = "UPDATE participants SET teaminated=1 WHERE ID=:ID";
      $update_remove_sql = "UPDATE participants SET teaminated=0 WHERE ID=:ID";
      $remove_sql = "DELETE FROM team WHERE participants_ID=:participants_ID";

      foreach($team_participants as $participant) {
        // Remove existing from DB
        $update_value = [[":ID",$participant['ID']]];
        $remove_value = [[":participants_ID",$participant['ID']]];
        $db->query($update_remove_sql,$update_value);
        $db->query($remove_sql,$remove_value);
      }
      for($i=0;$i < $nNames;$i++) {
        $update_value = [[":ID",$names[$i]]];
        $values = [
          [":team_ID",$_REQUEST['team']],
          [":participants_ID",$names[$i]]
        ];
        $db->query($new_in_team_sql,$values);
        $db->query($update_sql,$update_value);
      }
      echo "Hold " . $_REQUEST['team'] . " ændret og har nu " . $nNames . " deltagere.";
    }
  }
}
include("footer.php");
?>
