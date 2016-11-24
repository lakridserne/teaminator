<?php
/**
* Coding Pirates Teaminator
* Used to generate teams at Coding Pirates Game Jam 2015-2016
*/

if(!isset($_REQUEST['submit'])) {
include("header.php");
?>

<div class="row">
  <div class="col-md-4"></div>
  <div class="col-md-4">
    <form name="loginForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
      <div class="form-group">
        <label for="username">Brugernavn</label>
        <input type="text" name="username" id="username" />
      </div>
      <div class="form-group">
        <label for="password">Kodeord</label>
        <input type="password" name="password" id="password" />
      </div>
      <br />
      <button name="submit" type="submit" class="btn btn-default btn-block">Log ind</button>
    </form>
  </div>
  <div class="col-md-4"></div>
</div>

<?php
} else {
  $teaminator_url = "https://www.rathhansen.com/teaminator/";
  include_once("dbConnect.php");
  $db = new DB;
  session_start();
  // login logic
  if(isset($_REQUEST['username']) && isset($_REQUEST['password'])) {
    // both user and pass set - let's check it!
    $login_sql = "SELECT ID, pass, salt FROM users WHERE user=:username";
    $login_val = [[":username",$_REQUEST['username']]];

    if($db->count($login_sql,$login_val) == 1) {
      $pwd = $db->query($login_sql,$login_val);
      $sec_pass = sha1($_REQUEST['password'] . $pwd[0]['salt']);
      if($sec_pass == $pwd[0]['pass']) {
        // We're in. Now generate a token for the user
        $token = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 1).substr(md5(time()),1);
        $set_token_sql = "UPDATE users SET login_hash=:login_hash WHERE ID=:ID";
        $set_token_values = [
          [":login_hash",$token],
          [":ID",$pwd[0]['ID']]
        ];
        $db->query($set_token_sql,$set_token_values);

        // Now update our session
        $_SESSION['login_ID'] = $pwd[0]['ID'];
        $_SESSION['login_user'] = $_REQUEST['username'];
        $_SESSION['login_hash'] = $token;

        // We're in - go to next page
        header("Location: " . $teaminator_url);
      } else {
        header("Location: " . $teaminator_url . "login.php");
      }
    } else {
      header("Location: " . $teaminator_url . "login.php");
    }
  }
}
include("footer.php");
?>
