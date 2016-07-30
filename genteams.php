<?php
/**
* Coding Pirates Teaminator
* Used to generate teams at Coding Pirates Game Jam 2015-2016
*/
include("dbConnect.php");
$db = new DB;
?>
<!DOCTYPE html>
<head>
  <title>Coding Pirates Team-inator</title>
</head>
<h1>Coding Pirates Team-inator til Coding Pirates Game Jam 2015!</h1>
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
Antal: <input type="number" name="teamsize" /><br />
Mindst alder: <input type="number" name="minage" /><br />
Maks alder: <input type="number" name="maxage" /><br />
Antal designere: <input type="number" name="designers" /><br />
Team med visuel programmering <input type="radio" name="visualtext" value="visualprog" /><br />
Team med tekstprogrammering <input type="radio" name="visualtext" value="textprog" /><br />
<input type="submit" name="submit" value="Generer team" />
</form>
<?php
if(isset($_REQUEST['submit'])) {
  include("teamGenClass.php");
  $team = new teamGen($db);
  ?>
  <pre>
  <?php
  print_r($team->genTeam($_REQUEST['teamsize'],$_REQUEST['minage'],$_REQUEST['maxage'],$_REQUEST['designers'],$_REQUEST['visualtext']));
  ?>
  </pre>
  <?php
}
?>
