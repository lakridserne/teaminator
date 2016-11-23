<?php
/**
* Coding Pirates Teaminator
* Used to generate teams at Coding Pirates Game Jam 2015-2016
*/

include("header.php");

if(!isset($_REQUEST['submit'])) {
  // Form not submitted
  // get data
  $fetch_names_sql = "SELECT ID, name FROM participants WHERE teaminated=0 AND updated_since_csv=0";
  $names = $db->query($fetch_names_sql);
  ?>
  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="names">
    <select class="names_select">
      <?php
        foreach($names as $name) {
          echo "<option value='" . $name['ID'] . "'>" . $name['name'] . "</option>";
        }
      ?>
    </select>
    <label for="visualprog">Visuel programmering</label>
    <input type="checkbox" name="visualprog" value="visualprog" /><br />
    <label for="textprog">Tekstprogrammering</label>
    <input type="checkbox" name="textprog" value="textprog" /><br />
    <label for="graphic">Grafik / game design</label>
    <input type="checkbox" name="graphic" value="graphic" /><br />
    <label for="ultra">DR Ultra må gerne følge mig</label>
    <input type="checkbox" name="ultra" value="ultra" />

    <button type="submit" name="submit" class="btn btn-default btn-block">Opdater interesser</button>
  </form>
  <?php
} else {

}

include("footer.php");
?>
