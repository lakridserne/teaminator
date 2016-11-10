<?php
/**
* Coding Pirates Teaminator
* Used to generate teams at Coding Pirates Game Jam 2015-2016
*/

include("header.php");

if(!isset($_REQUEST['submit'])) {
  ?>
  <h2>Upload CSV fil med medlemmer.</h2>
  <form enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <input type="hidden" name="MAX_FILE_SIZE" value="51200" />
    Vælg filen eller træk den hen på: <input type="file" name="csv_file" />
    <input type="submit" name="submit" value="Send filen" />
  </form>
  <?php
} else {
  // Code to use CSV file.

}
include("footer.php");
?>
