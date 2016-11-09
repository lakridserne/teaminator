<?php
$teaminator_url = "https://www.rathhansen.com/teaminator/";

function echoActiveClassIfRequestMatches($requestUri)
{
    $current_file_name = basename($_SERVER['PHP_SELF'], ".php");

    if ($current_file_name == $requestUri)
        echo 'class="active"';
}
?>
<!DOCTYPE html>
<head>
  <title>Coding Pirates Teaminator</title>
  <meta charset="utf-8">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</head>
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="<?php echo $teaminator_url; ?>" title="Coding Pirates Teaminator">Coding Pirates Teaminator til Coding Pirates Gamejam 2016!</a>
    </div>
    <ul class="nav navbar-nav">
      <li <?php echo echoActiveClassIfRequestMatches("index"); ?>>
        <a href="index.php" title="Coding Pirates Teaminator hjem">
          Hjem
        </a>
      </li>
      <li <?php echo echoActiveClassIfRequestMatches("teaminator-add-manual"); ?>>
        <a href="teaminator-add-manual.php" title="Tilføj person manuelt">
          Tilføj person manuelt
        </a>
      </li>
    </ul>
  </div>
</nav>
<div class="container">
