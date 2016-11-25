<?php
/**
* Coding Pirates Teaminator
* Used to generate teams at Coding Pirates Game Jam 2015-2016
*/

include("header.php");
?>
<div class="col-md-4">
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
Antal: <input type="number" name="teamsize" /><br />
Mindst alder: <input type="number" name="minage" /><br />
Maks alder: <input type="number" name="maxage" /><br />
Antal designere: <input type="number" name="designers" /><br />
Team med visuel programmering <input type="radio" name="visualtext" value="visualprog" /><br />
Team med tekstprogrammering <input type="radio" name="visualtext" value="textprog" /><br />
DR Ultra må følge team <input type="checkbox" name="ultra" value="ultra" /><br />
Tilføj til holdnummer (efterlad blank for at lave nyt hold) <input type="number" name="team_ID" /><br />
<input type="submit" name="submit" value="Generer team" />
</form>
<?php
if(isset($_REQUEST['submit'])) {
  include("teamGenClass.php");
  $team = new teamGen($db);
  ?>
  <pre>
  <?php
  if(isset($_REQUEST['team_ID'])) {
    print_r($team->genTeam($_REQUEST['teamsize'],$_REQUEST['minage'],$_REQUEST['maxage'],$_REQUEST['designers'],$_REQUEST['visualtext'],$_REQUEST['ultra'],$_REQUEST['team_ID']));
  } else {
    print_r($team->genTeam($_REQUEST['teamsize'],$_REQUEST['minage'],$_REQUEST['maxage'],$_REQUEST['designers'],$_REQUEST['visualtext'],$_REQUEST['ultra']));
  }
  ?>
  </pre>
  <?php
}
?>
</div>
<div class="col-md-4"></div>
<div class="col-md-4">
  <h2>Aldersoversigt</h2>
  <?php
  $sql_gen = "SELECT * FROM participants WHERE teaminated=0 AND updated_since_csv=1 AND age=:age";
  $sql_vis = "SELECT * FROM participants WHERE teaminated=0 AND updated_since_csv=1 AND age=:age AND visualprog=1";
  $sql_tex = "SELECT * FROM participants WHERE teaminated=0 AND updated_since_csv=1 AND age=:age AND textprog=1";
  $sql_des = "SELECT * FROM participants WHERE teaminated=0 AND updated_since_csv=1 AND age=:age AND graphic=1";
  $sql_ultra = "SELECT * FROM participants WHERE teaminated=0 AND updated_since_csv=1 AND age=:age AND ultra=1";
  for($i=7;$i<=17;$i++) {
    $sql_val = [[":age",$i]];
    if($db->count($sql_gen,$sql_val) > 0) {
      echo "<b>" . $i . " år</b><br />";
      echo $db->count($sql_gen,$sql_val) . " i alt<br />";
      echo $db->count($sql_vis,$sql_val) . " visuelle<br />";
      echo $db->count($sql_tex,$sql_val) . " tekst<br />";
      echo $db->count($sql_des,$sql_val) . " designere<br />";
      echo $db->count($sql_ultra,$sql_val) . " ultra<br />";
    }
  }
  ?>
</div>
<?php
include("footer.php");
?>
