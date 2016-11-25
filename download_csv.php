<?php
/**
* Coding Pirates Teaminator
* Used to generate teams at Coding Pirates Game Jam 2015-2016
*/

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

// good - all logged in - let's create CSV file
if(file_exists('hold.csv')) {
  unlink('hold.csv');
}
$file = fopen("hold.csv","w");

$team_sql = "SELECT participants.name, participants.age,team.team_ID,participants.visualprog,participants.textprog,participants.graphic,participants.ultra FROM participants INNER JOIN team ON participants.ID=team.participants_ID ORDER BY team.team_ID,participants.name";
$teams = $db->query($team_sql);
$headings['name'] = "Navn";
$headings['age'] = "Alder";
$headings['team_ID'] = "Holdnummer";
$headings['visualprog'] = "Visuel programmering";
$headings['textprog'] = "Tekstprogrammering";
$headings['graphic'] = "Grafik";
$headings['ultra'] = "Ultra";
fputcsv($file,$headings, ';', '"');
foreach($teams as $team) {
  foreach($team as $key => $value) {
    if(!is_int($key)) {
      unset($team[$key]);
    }
  }
  fputcsv($file,$team, ';', '"');
}

fclose($file);
header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
header("Location: hold.csv");
?>
