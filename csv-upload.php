<?php
/**
* Coding Pirates Teaminator
* Used to generate teams at Coding Pirates Game Jam 2015-2016
*/

include("header.php");

if(!isset($_REQUEST['submit'])) {
  ?>
  <h2>Upload CSV fil med medlemmer</h2>
  <form enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <div class="form-group">
      <input type="hidden" name="MAX_FILE_SIZE" value="51200" />
      <label for="csvInputFile">Vælg filen eller træk den hen på:</label>
      <input type="file" class="form-control-file" id="csvInputFile" name="csv_file" />
    </div>
    <input type="submit" class="btn btn-primary" name="submit" value="Send filen" />
  </form>
  <?php
} else {
  // Code to use CSV file.

}
include("footer.php");
?>
