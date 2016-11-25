<?php
/**
* Coding Pirates Teaminator
* Used to generate teams at Coding Pirates Game Jam 2015-2016
*/

include("header.php");

if(isset($_REQUEST['submit'])) {
  // Form already filled out
  $sql = "INSERT INTO participants
    (name,age,visualprog,textprog,graphic,ultra,updated_since_csv,teaminated)
    VALUES (:name, :age, :visualprog, :textprog, :graphic, :ultra, true, false)";

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

  if(isset($_REQUEST['ultra'])) {
    $ultra = true;
  } else {
    $ultra = false;
  }

  // make array with list of values
  $values = [
    [":name", $_REQUEST['name']],
    [":age", $_REQUEST['age']],
    [":visualprog", $visualprog],
    [":textprog", $textprog],
    [":graphic", $graphic],
    [":ultra", $ultra]
  ];
  $db->query($sql,$values);
}
?>
<h2>KUN hvis du har brug for at tilføje en person manuelt af en eller anden grund. Ellers brug CSV upload!</h2>
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
  Navn: <input type="text" name="name" /><br />
  Alder <input type="number" name="age" /><br />
  Interesser: <br />
  Visuel programmering: <input type="checkbox" name="visualprog" value="visualprog" /><br />
  Tekstprogrammering: <input type="checkbox" name="textprog" value="textprog" /><br />
  Grafik / game design: <input type="checkbox" name="graphic" value="graphic" /><br />
  Ultra må følge mig: <input type="checkbox" name="ultra" value="ultra" /><br /><br />

  <input type="submit" name="submit" value="Bliv Team-inated!" />
</form>
<?php
include("footer.php");
?>
