<?php
/**
* Coding Pirates Teaminator
* Used to generate teams at Coding Pirates Game Jam 2015-2016
*/

include("header.php");

if(isset($_REQUEST['submit'])) {
  // now find the data
  $visualprog = isset($_REQUEST['visualprog']) ? 1 : 0;
  $textprog = isset($_REQUEST['textprog']) ? 1 : 0;
  $graphic = isset($_REQUEST['graphic']) ? 1 : 0;
  if (!$visualprog && !$textprog && !$graphic) {
      echo "Husk at vælge interesser!";
  } else {
      $update_sql = "UPDATE participants SET visualprog=:visualprog, textprog=:textprog, graphic=:graphic, updated_since_csv=1 WHERE ID=:ID";
      $values = [
        [":visualprog",$visualprog],
        [":textprog",$textprog],
        [":graphic",$graphic],
        [":ID",$_REQUEST['names_select']]
      ];
      $db->query($update_sql,$values);
      echo "Opdateret<br />";
  }
}

$fetch_names_sql = "SELECT ID, name FROM participants WHERE teaminated=0 AND updated_since_csv=0";
$names = $db->query($fetch_names_sql);
?>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="names">
  <select name="names_select" class="names_select">
    <?php
      foreach($names as $name) {
        echo "<option value='" . $name['ID'] . "'>" . $name['name'] . "</option>";
      }
    ?>
  </select>
  <br />
  <label for="visualprog">Visuel programmering</label>
  <input type="checkbox" name="visualprog" value="visualprog" /><br />
  <label for="textprog">Tekstprogrammering</label>
  <input type="checkbox" name="textprog" value="textprog" /><br />
  <label for="graphic">Grafik / game design</label>
  <input type="checkbox" name="graphic" value="graphic" /><br />

  <button type="submit" name="submit" class="btn btn-default btn-block">Opdater interesser</button>
</form>
<script>
  $(document).ready(function() {
    $(".names_select").select2();
  });
</script>

<?php
include("footer.php");
?>
