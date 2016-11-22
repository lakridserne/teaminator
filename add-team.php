<?php
/**
* Coding Pirates Teaminator
* Used to generate teams at Coding Pirates Game Jam 2015-2016
*/

include("dbConnect.php");
$db = new DB;
include("header.php");

// see if form was already submitted
if(!isset($_REQUEST['submit'])) {
  // Form not submitted yet
  // Fetch names
  $sql = "SELECT name FROM participants WHERE teaminated=0";
  $names = $db->query($sql);
  ?>
  <form class="names" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <select multiple="multiple" size="10" name="names_teams[]">
      <?php
      foreach ($names as $name) {
        echo "<option value=\"" . $name['name']  . "\">" . $name['name'] . "</option>";
      }
      ?>
    </select>
    <br />
    <button type="submit" class="btn btn-default btn-block">Tilføj hold</button>
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
      $nNames = count($names);

      for($i=0;$i < $nNames;$i++) {
        echo $names[$i] . "<br />";
      }
    }
  }
}
?>
