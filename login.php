<?php
/**
* Coding Pirates Teaminator
* Used to generate teams at Coding Pirates Game Jam 2015-2016
*/

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
        <label for="username">Kodeord</label>
        <input type="text" name="password" id="password" />
      </div>
      <br />
      <button name="submit" type="submit" class="btn btn-default btn-block">Log ind</button>
    </form>
  </div>
  <div class="col-md-4"></div>
</div>

<?php
include("footer.php");
?>
