<?php
/**
* Coding Pirates Teaminator
* Used to generate teams at Coding Pirates Game Jam 2015-2016
*/

include("header.php");
if(!isset($_REQUEST['submit'])) {
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
  // login logic
  if(isset($_REQUEST['username']) && isset($_REQUEST['password'])) {
    // both user and pass set - let's check it!
    $login_sql = "SELECT ID, pass, salt FROM users WHERE user=:username";
    $login_val = [[":username",$_REQUEST['username']]];

    $pwd = $db->query($login_sql,$login_val);
    print_r($pwd);
  }
}
include("footer.php");
?>
