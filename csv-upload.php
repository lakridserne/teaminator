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
        'csv' => 'text/plain',
      ),
      true
    )) {
      throw new RuntimeException("Forkert filformat");
    }
    $new_file_location = sprintf('./uploads/%s.%s',
      sha1_file($_FILES['csv_file']['tmp_name']),
      $ext
    );
    if(!move_uploaded_file(
      $_FILES['csv_file']['tmp_name'],
      $new_file_location
    )) {
      throw new RuntimeException("Kunne ikke flytte filen");
    }
  } catch(RuntimeException $e) {
    echo $e->getMessage();
  }

  // Now we have the file scrubbed - read and put in DB
  $participants = 0;
  $firstLine = true;
  if(($filehandle = fopen($new_file_location, 'r')) !== false) {
    while(($data = fgetcsv($filehandle,1000,';')) !== false) {
      $participants++;
      /*
      * This is the indiviual row
      * [0] => Navn
      * [1] => Alder
      * [2] => Køn
      * [3] => Opskrevet
      * [4] => Tlf (barn)
      * [5] => Email (barn)
      * [6] => Tlf (forælder)
      * [7] => Email (familie)
      * [8] => Postnummer
      */
      // Jump over first line with headings
      if($firstLine == true) {
        $firstLine = false;
        $participants--;
        continue;
      }

      // Now make connection to the database and import data
      $sql = "INSERT INTO participants (name,age,gender,visualprog,textprog,
                          graphic,updated_since_csv,teaminated)
                      VALUES (:name,:age,:gender,:visualprog,:textprog,:graphic,
                        :updated_since_csv,:teaminated)";

      if ($data[2] == "Dreng/Mand") {
          $gender = 'm';
      } elseif ($data[2] == 'Pige/Kvinde') {
          $gender = 'f';
      }

      $values = [
        [":name",$data[0]],
        [":age",$data[1]],
        [":gender",$gender],
        [":visualprog",0],
        [":textprog",0],
        [":graphic",0],
        [":updated_since_csv",0],
        [":teaminated",0]
      ];
      $db->query($sql,$values);
    }
    fclose($filehandle);
    echo $participants . " pirater tilføjet til databasen.";
  }
}
include("footer.php");
?>
