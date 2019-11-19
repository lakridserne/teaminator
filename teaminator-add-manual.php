<?php
/**
* Coding Pirates Teaminator
* Used to generate teams at Coding Pirates Game Jam 2015-2016
*/

include("header.php");

if(isset($_REQUEST['submit'])) {
  // Form already filled out
  $sql = "INSERT INTO participants
    (name,age,visualprog,textprog,graphic,updated_since_csv,teaminated)
    VALUES (:name, :age, :visualprog, :textprog, :graphic, true, false)";

  // if statements determining whether the interests should be true or false
  $visualprog = isset($_REQUEST['visualprog']) ? 1 : 0;
  $textprog = isset($_REQUEST['textprog']) ? 1 : 0;
  $graphic = isset($_REQUEST['graphic']) ? 1 : 0;

  // make array with list of values
  $values = [
    [":name", $_REQUEST['name']],
    [":age", $_REQUEST['age']],
    [":visualprog", $visualprog],
    [":textprog", $textprog],
    [":graphic", $graphic]
  ];
  $db->query($sql,$values);
  echo $_REQUEST['name'] . " er oprettet!";
}
?>
<h2>KUN hvis du har brug for at tilføje en person manuelt af en eller anden grund. Ellers brug CSV upload!</h2>
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
  Navn: <input type="text" name="name" /><br />
  Alder <input type="number" name="age" /><br />
  Interesser: <br />
  Visuel programmering: <input type="checkbox" name="visualprog" value="visualprog" /><br />
  Tekstprogrammering: <input type="checkbox" name="textprog" value="textprog" /><br />
  Grafik / game design: <input type="checkbox" name="graphic" value="graphic" /><br /><br />

  <input type="submit" name="submit" value="Bliv Team-inated!" />
</form>
<?php
include("footer.php");
?>
