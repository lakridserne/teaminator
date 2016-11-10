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
  try {
    if(
        !isset($_FILES['csv_file']['error']) ||
        is_array($_FILES['csv_file']['error'])
      ) {
      throw new RuntimeException("Invalid params");
    }

    switch($_FILES['csv_file']['error']) {
      case UPLOAD_ERR_OK:
        break;
      case UPLOAD_ERR_NO_FILE:
        throw new RuntimeException("Husk filen!");
      case UPLOAD_ERR_INI_SIZE:
      case UPLOAD_ERR_FORM_SIZE:
        throw new RuntimeException("Prøv med en mindre fil");
      default:
        throw new RuntimeException("Noget uventet gik galt. Spørg Kristoffer!");
    }

    // Check filesize
    if($_FILES['csv_file']['size'] > 51200) {
      throw new RuntimeException("Filen er for stor.");
    }

    // Check type!
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    if(false === $ext = array_search(
      $finfo->file($_FILES['csv_file']['tmp_name']),
      array(
        'csv' => 'text/csv',
      ),
      true
    )) {
      throw new RuntimeException("Forkert filformat");
    }
    if(!move_uploaded_file(
      $_FILES['csv_file']['tmp_name'],
      sprintf('./uploads/%s.%s',
        sha1_file($_FILES['csv_file']['tmp_name']),
        $ext
      )
    )) {
      throw new RuntimeException("Kunne ikke flytte filen");
    }
  } catch(RuntimeException $e) {
    echo $e->getMessage();
  }
}
include("footer.php");
?>
