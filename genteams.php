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
Køn:
<input type="radio" id="male" name="gender" value="m">
<label for="male">Dreng</label>
<input type="radio" id="female" name="gender" value="f">
<label for="female">Pige</label><br />
Antal designere: <input type="number" name="designers" /><br />
Team med visuel programmering <input type="radio" name="visualtext" value="visualprog" /><br />
Team med tekstprogrammering <input type="radio" name="visualtext" value="textprog" /><br />
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
    print_r($team->genTeam($_REQUEST['teamsize'],$_REQUEST['minage'],$_REQUEST['maxage'],$_REQUEST['gender'],$_REQUEST['designers'],$_REQUEST['visualtext'],$_REQUEST['team_ID']));
  } else {
    print_r($team->genTeam($_REQUEST['teamsize'],$_REQUEST['minage'],$_REQUEST['maxage'],$_REQUEST['gender'],$_REQUEST['designers'],$_REQUEST['visualtext']));
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
  $sql_gen_boy = "SELECT * FROM participants WHERE teaminated=0 AND updated_since_csv=1 AND age=:age AND gender='m'";
  $sql_gen_girl = "SELECT * FROM participants WHERE teaminated=0 AND updated_since_csv=1 AND age=:age AND gender='f'";
  $sql_vis_boy = "SELECT * FROM participants WHERE teaminated=0 AND updated_since_csv=1 AND age=:age AND visualprog=1 AND gender='m'";
  $sql_vis_girl = "SELECT * FROM participants WHERE teaminated=0 AND updated_since_csv=1 AND age=:age AND visualprog=1 AND gender='f'";
  $sql_tex_boy = "SELECT * FROM participants WHERE teaminated=0 AND updated_since_csv=1 AND age=:age AND textprog=1 AND gender='m'";
  $sql_tex_girl = "SELECT * FROM participants WHERE teaminated=0 AND updated_since_csv=1 AND age=:age AND textprog=1 AND gender='f'";
  $sql_des_boy = "SELECT * FROM participants WHERE teaminated=0 AND updated_since_csv=1 AND age=:age AND graphic=1 AND gender='m'";
  $sql_des_girl = "SELECT * FROM participants WHERE teaminated=0 AND updated_since_csv=1 AND age=:age AND graphic=1 AND gender='f'";
  for($i=10;$i<=17;$i++) {
    $sql_val = [[":age",$i]];
    if($db->count($sql_gen_boy,$sql_val) > 0 || $db->count($sql_gen_girl,$sql_val) > 0) {
      echo "<b>" . $i . " år</b><br />";
      echo $db->count($sql_gen_boy,$sql_val) . " drenge i alt<br />";
      echo $db->count($sql_gen_girl,$sql_val) . " piger i alt<br />";
      echo $db->count($sql_vis_boy,$sql_val) . " visuelle drenge<br />";
      echo $db->count($sql_vis_girl,$sql_val) . " visuelle piger<br />";
      echo $db->count($sql_tex_boy,$sql_val) . " tekst drenge<br />";
      echo $db->count($sql_tex_girl,$sql_val) . " tekst piger<br />";
      echo $db->count($sql_des_boy,$sql_val) . " drenge designere<br />";
      echo $db->count($sql_des_girl,$sql_val) . " pige designere<br />";
    }
  }
  ?>
</div>
<?php
include("footer.php");
?>
