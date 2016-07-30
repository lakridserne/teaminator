<?php
/**
* Coding Pirates Teaminator
* Used to generate teams at Coding Pirates Game Jam 2015-2016
*/
include("dbConnect.php");
$db = new DB;

if(isset($_REQUEST['submit'])) {
  // Form already filled out
  $sql = "INSERT INTO participants
    (name,age,visualprog,textprog,graphic,teaminated)
    VALUES (:name, :age, :visualprog, :textprog, :graphic, false)";

  // if statements determining whether the interests should be true or false
  if(isset($_REQUEST['visualprog'])) {
    $visualprog = true;
  } else {
    $visualprog = false;
  }

  if(isset($_REQUEST['textprog'])) {
    $textprog = true;
  } else {
    $textprog = false;
  }

  if(isset($_REQUEST['graphic'])) {
    $graphic = true;
  } else {
    $graphic = false;
  }

  // make array with list of values
  $values = [
    [":name", $_REQUEST['name']],
    [":age", $_REQUEST['age']],
    [":visualprog", $visualprog],
    [":textprog", $textprog],
    [":graphic", $graphic]
  ];
  $db->query($sql,$values);
}
?>
<!DOCTYPE html>
<head>
  <title>Coding Pirates Team-inator</title>
</head>
<h1>Coding Pirates Team-inator til Coding Pirates Game Jam 2015!</h1>
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
  Navn: <input type="text" name="name" /><br />
  Alder <input type="number" name="age" /><br />
  Interesser: <br />
  Visuel programmering: <input type="checkbox" name="visualprog" value="visualprog" /><br />
  Tekstprogrammering: <input type="checkbox" name="textprog" value="textprog" /><br />
  Grafik / game design: <input type="checkbox" name="graphic" value="graphic" /><br /><br />

  <input type="submit" name="submit" value="Bliv Team-inated!" />
</form>
