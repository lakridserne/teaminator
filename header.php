<?php
$teaminator_url = "https://www.rathhansen.com/teaminator/";
include_once("dbConnect.php");
$db = new DB;
session_start();
if(isset($_SESSION['login_ID'])) {
  $user_sql = "SELECT user, login_hash FROM users WHERE ID=:ID";
  $user_val = [[":ID",$_SESSION['login_ID']]];
  $login_hash = $db->query($user_sql,$user_val);

  // Check hash and user from DB against session hash and user
  if($_SESSION['login_user'] != $login_hash[0]['user'] || $_SESSION['login_hash'] != $login_hash[0]['login_hash']) {
    if("https://" . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] != $teaminator_url . "login.php") {
      header("Location: " . $teaminator_url . "login.php");
    }
  }

  // Before sending the user on the way make sure to update hash
  $token = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 1).substr(md5(time()),1);
  $set_token_sql = "UPDATE users SET login_hash=:login_hash WHERE ID=:ID";
  $set_token_values = [
    [":login_hash",$token],
    [":ID",$_SESSION['login_ID']]
  ];
  $db->query($set_token_sql,$set_token_values);

  $_SESSION['login_hash'] = $token;
} else {
  if("https://" . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] != $teaminator_url . "login.php") {
    header("Location: " . $teaminator_url . "login.php");
  }
}

function echoActiveClassIfRequestMatches($requestUri)
{
    $current_file_name = basename($_SERVER['PHP_SELF'], ".php");

    if ($current_file_name == $requestUri) {
        echo 'class="active"';
      }
}
?>
<!DOCTYPE html>
<head>
  <title>Coding Pirates Teaminator</title>
  <meta charset="utf-8">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
  <script src="<?php echo $teaminator_url . 'duallistbox/dist/jquery.bootstrap-duallistbox.min.js'; ?>"></script>
  <link rel="stylesheet" type="text/css" href="<?php echo $teaminator_url . 'duallistbox/src/bootstrap-duallistbox.css'; ?>">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
</head>
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="<?php echo $teaminator_url; ?>" title="Coding Pirates Teaminator">Coding Pirates Teaminator til Coding Pirates Gamejam 2016!</a>
    </div>
    <ul class="nav navbar-nav">
      <li <?php echo echoActiveClassIfRequestMatches("index"); ?>>
        <a href="<?php echo $teaminator_url; ?>" title="Coding Pirates Teaminator hjem">
          Hjem
        </a>
      </li>
      <li <?php echo echoActiveClassIfRequestMatches("teaminator-add-manual"); ?>>
        <a href="<?php echo $teaminator_url . 'teaminator-add-manual.php'; ?>" title="Tilføj person manuelt">
          Tilføj person manuelt
        </a>
      </li>
      <li <?php echo echoActiveClassIfRequestMatches("csv-upload"); ?>>
        <a href="<?php echo $teaminator_url . 'csv-upload.php'; ?>" title="Upload CSV fil">
          Upload CSV fil
        </a>
      </li>
      <li <?php echo echoActiveClassIfRequestMatches("showTeams"); ?>>
        <a href="<?php echo $teaminator_url . 'showTeams.php'; ?>" title="Hold">
          Hold
        </a>
      </li>
      <li <?php echo echoActiveClassIfRequestMatches("add-team"); ?>>
        <a href="<?php echo $teaminator_url . 'add-team.php'; ?>" title="Tilføj hold">
          Tilføj hold
        </a>
      </li>
      <li <?php echo echoActiveClassIfRequestMatches("choose"); ?>>
        <a href="<?php echo $teaminator_url . 'choose.php'; ?>" title="Vælg interesser">
          Vælg interesser
        </a>
      </li>
      <li <?php echo echoActiveClassIfRequestMatches("genteams"); ?>>
        <a href="<?php echo $teaminator_url . 'genteams.php'; ?>" title="Generer teams">
          Generer teams
        </a>
      </li>
    </ul>
  </div>
</nav>
<div class="container">
